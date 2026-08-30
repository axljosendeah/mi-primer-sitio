# 1. Creamos las variables con los datos correctos del usuario
usuario_registrado = "jose"
contrasena_registrada = "render123"

# 2. Simulamos los datos que alguien escribe al intentar entrar
usuario_ingresado = "jose"
contrasena_ingresada = "render123"

# 3. Usamos un condicional (IF) para tomar una decisión inteligente
if usuario_ingresado == usuario_registrado and contrasena_ingresada == contrasena_registrada:
    print("¡Acceso concedido! Bienvenido al panel de administración.")
else:
    print("Error: El usuario o la contraseña son incorrectos.")
