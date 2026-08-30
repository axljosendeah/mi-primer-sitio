from fastapi import FastAPI

# 1. Creamos la aplicación del servidor
app = FastAPI()

# 2. Creamos una ruta principal (la raíz del sitio)
@app.get("/")
def inicio():
    # Este mensaje se enviará a cualquier persona que visite la URL de Render
    return {
        "estado": "servidor_activo",
        "mensaje": "¡Acceso concedido! Bienvenido al panel de administración en vivo.",
        "curso": "Backend con Python y FastAPI en Render"
    }
