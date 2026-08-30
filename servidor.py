from fastapi import FastAPI, Request
from fastapi.middleware.cors import CORSMiddleware
import httpx

app = FastAPI()

# Permitir que las páginas web se comuniquen con este servidor sin bloqueos
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# Buzón en memoria para guardar los datos de la partida actual
partida = {
    "mensajes_usuario": [],
    "respuestas_genio": [],
    "ip": "No detectada",
    "ubicacion": "Desconocida"
}

# 1. RUTA PARA EL JUGADOR: Recibir sus pistas
@app.post("/enviar-pista")
async def recibir_pista(datos: dict, request: Request):
    texto = datos.get("texto", "")
    if texto:
        partida["mensajes_usuario"].append(texto)
    
    # Capturar la IP real del jugador
    ip_cliente = request.headers.get("X-Forwarded-For", request.client.host)
    
    if ip_cliente:
        # Tomamos la primera IP de la lista y limpiamos espacios con la lógica [0].strip()
        partida["ip"] = ip_cliente.split(",")[0].strip()

    # RASTREAR UBICACIÓN: Si la IP es válida y no es local, consultamos la API de mapas
    if partida["ubicacion"] == "Desconocida" and partida["ip"] not in ["127.0.0.1", "localhost", "No detectada"]:
        try:
            async with httpx.AsyncClient() as client:
                res = await client.get(f"https://ipapi.co{partida['ip']}/json/")
                if res.status_code == 200:
                    info = res.json()
                    partida["ubicacion"] = f"{info.get('city', 'Ciudad desconocida')}, {info.get('country_name', 'País desconocido')}"
        except Exception:
            partida["ubicacion"] = "Error al localizar"

    return {"status": "ok"}

# 2. RUTA PARA EL ADMIN: Recibir tus respuestas
@app.post("/enviar-respuesta")
def recibir_respuesta(datos: dict):
    texto = datos.get("texto", "")
    if texto:
        partida["respuestas_genio"].append(texto)
    return {"status": "ok"}

# 3. RUTA DE MONITOREO: Para descargar los datos actualizados cada 2 segundos
@app.get("/actualizar-partida")
def actualizar_partida():
    return partida

# 4. RUTA DE LIMPIEZA: Para reiniciar el juego cuando gustes
@app.post("/reiniciar")
def reiniciar():
    partida["mensajes_usuario"] = []
    partida["respuestas_genio"] = []
    partida["ip"] = "No detectada"
    partida["ubicacion"] = "Desconocida"
    return {"status": "partida_reiniciada"}
