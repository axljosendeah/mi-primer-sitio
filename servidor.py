from fastapi import FastAPI, Request
from fastapi.middleware.cors import CORSMiddleware
import httpx

app = FastAPI()

# Permitir que las páginas web se comuniquen con este servidor sin bloqueos de seguridad
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# Buzones en memoria para guardar la partida actual
partida = {
    "mensajes_usuario": [],
    "respuestas_genio": [],
    "ip": "No detectada",
    "ubicacion": "Desconocida"
}

# 1. RUTA PARA EL JUGADOR: Recibir sus pistas
@app.post("/enviar-pista")
async def recibir_pista(datos: dict, request: Request):
    partida["ip"] = ip_cliente.split(",")[0].strip()
    if texto:
        partida["mensajes_usuario"].append(texto)
    
    # Capturar la IP real del jugador (Render la pasa a través de una cabecera llamada X-Forwarded-For)
    ip_cliente = request.headers.get("X-Forwarded-For", request.client.host)
    # Si vienen varias IPs separadas por coma, tomamos la primera
    partida["ip"] = ip_cliente.split(",")[0].strip()

    # RASTREAR UBICACIÓN: Si la IP es válida y no la hemos buscado, consultamos un servicio gratuito
    if partida["ubicacion"] == "Desconocida" and partida["ip"] != "127.0.0.1":
        try:
            async with httpx.AsyncClient() as client:
                # Consultamos una API de geolocalización pública
                res = await client.get(f"https://ipapi.co{partida['ip']}/json/")
                if res.status_code == 200:
                    info = res.json()
                    partida["ubicacion"] = f"{info.get('city', 'Ciudad desconocida')}, {info.get('country_name', 'País desconocido')}"
        except:
            partida["ubicacion"] = "Error al localizar"

    return {"status": "ok"}

# 2. RUTA PARA EL ADMIN: Recibir tus respuestas
@app.post("/enviar-respuesta")
def recibir_respuesta(datos: dict):
    texto = datos.get("texto", "")
    if texto:
        partida["respuestas_genio"].append(texto)
    return {"status": "ok"}

# 3. RUTA DE MONITOREO: Para que ambas pantallas descarguen la información actualizada
@app.get("/actualizar-partida")
def actualizar_partida():
    return partida

# 4. RUTA DE LIMPIEZA: Para reiniciar el juego cuando quieras
@app.post("/reiniciar")
def reiniciar():
    partida["mensajes_usuario"] = []
    partida["respuestas_genio"] = []
    partida["ip"] = "No detectada"
    partida["ubicacion"] = "Desconocida"
    return {"status": "partida_reiniciada"}
