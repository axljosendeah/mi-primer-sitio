from fastapi import FastAPI, Request
from fastapi.middleware.cors import CORSMiddleware
import httpx

app = FastAPI()

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

partida = {
    "mensajes_usuario": [],
    "respuestas_genio": [],
    "ip": "No detectada",
    "ubicacion": "Desconocida"
}

@app.post("/enviar-pista")
async def recibir_pista(datos: dict, request: Request):
    texto = datos.get("texto", "")
    if texto:
        partida["mensajes_usuario"].append(texto)

    ip_cliente = request.headers.get("X-Forwarded-For", request.client.host)
    if ip_cliente:
        partida["ip"] = ip_cliente.split(",")[0].strip()

    if partida["ubicacion"] == "Desconocida" and partida["ip"] not in ["127.0.0.1", "localhost", "No detectada"]:
        try:
            async with httpx.AsyncClient() as client:
                # ✅ CORREGIDO: la URL tenía sintaxis de Markdown pegada por error
                url = f"https://ipapi.co/{partida['ip']}/json/"
                res = await client.get(url, headers={"User-Agent": "Mozilla/5.0"})
                if res.status_code == 200:
                    info = res.json()
                    partida["ubicacion"] = f"{info.get('city', 'Ciudad desconocida')}, {info.get('country_name', 'País desconocido')}"
                else:
                    partida["ubicacion"] = "Ubicación no encontrada"
        except Exception:
            partida["ubicacion"] = "Error al localizar"

    return {"status": "ok"}

@app.post("/enviar-respuesta")
async def recibir_respuesta(datos: dict):
    texto = datos.get("texto", "")
    if texto:
        partida["respuestas_genio"].append(texto)
    return {"status": "ok"}

@app.get("/actualizar-partida")
async def actualizar_partida():
    return partida

@app.post("/reiniciar")
async def reiniciar():
    partida["mensajes_usuario"] = []
    partida["respuestas_genio"] = []
    partida["ip"] = "No detectada"
    partida["ubicacion"] = "Desconocida"
    return {"status": "partida_reiniciada"}
