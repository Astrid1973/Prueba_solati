# Documentación de la API

## Autenticación

### Obtener usuario autenticado
**Endpoint:** `GET /api/user`
- **Autenticación:** Requiere token de `auth:sanctum`
- **Respuesta exitosa:**
```json
{
  "id": 1,
  "name": "Usuario Ejemplo",
  "email": "usuario@example.com"
}
```

### Iniciar sesión
**Endpoint:** `POST /api/autenticacion`
- **Parámetros:**
```json
{
  "email": "usuario@example.com",
  "password": "contraseña123"
}
```
- **Respuesta exitosa:**
```json
{
  "token": "token_de_acceso"
}
```

### Cerrar sesión
**Endpoint:** `POST /api/logout`
- **Autenticación:** Requiere token de `auth:sanctum`
- **Respuesta exitosa:**
```json
{
  "message": "Cierre de sesión exitoso"
}
```

### Obtener información del usuario autenticado
**Endpoint:** `GET /api/me`
- **Autenticación:** Requiere token de `auth:sanctum`
- **Respuesta exitosa:**
```json
{
  "id": 1,
  "name": "Usuario Ejemplo",
  "email": "usuario@example.com"
}
```

## Usuarios

### Listar usuarios
**Endpoint:** `GET /api/listUser`
- **Autenticación:** Requiere token de `auth:sanctum`
- **Respuesta exitosa:** Lista de usuarios

### Crear usuario
**Endpoint:** `POST /api/createUser`
- **Parámetros:**
```json
{
  "name": "Nuevo Usuario",
  "email": "nuevo@example.com",
  "password": "contraseña123"
}
```
- **Respuesta exitosa:**
```json
{
  "message": "Usuario creado exitosamente"
}
```

## Tareas

### Crear una tarea
**Endpoint:** `POST /api/createTask`
- **Autenticación:** Requiere token de `auth:sanctum`
- **Parámetros:**
```json
{
  "title": "Nueva tarea",
  "description": "Descripción de la tarea",
  "user_id": 1
}
```
- **Respuesta exitosa:**
```json
{
  "id": 1,
  "title": "Nueva tarea",
  "description": "Descripción de la tarea",
  "user_id": 1
}
```

### Listar todas las tareas
**Endpoint:** `GET /api/listTask`
- **Autenticación:** Requiere token de `auth:sanctum`
- **Respuesta exitosa:** Lista de tareas

### Listar tareas por usuario
**Endpoint:** `GET /api/listTaskByUser/{id?}`
- **Autenticación:** Requiere token de `auth:sanctum`
- **Parámetro opcional:** id del usuario
- **Respuesta exitosa:** Lista de tareas del usuario

### Actualizar una tarea
**Endpoint:** `PUT /api/updateTask/{id}`
- **Autenticación:** Requiere token de `auth:sanctum`
- **Parámetros:**
```json
{
  "title": "Tarea actualizada",
  "description": "Nueva descripción"
}
```
- **Respuesta exitosa:**
```json
{
  "message": "Tarea actualizada exitosamente"
}
```

### Actualizar estado de una tarea
**Endpoint:** `PATCH /api/updateStatusTask/{id}`
- **Autenticación:** Requiere token de `auth:sanctum`
- **Respuesta exitosa:**
```json
{
  "message": "Estado de la tarea actualizado"
}
```

### Eliminar una tarea
**Endpoint:** `DELETE /api/deleteTask/{id}`
- **Autenticación:** Requiere token de `auth:sanctum`
- **Respuesta exitosa:**
```json
{
  "message": "Tarea eliminada"
}
```

## Posibles Errores
- `401 Unauthorized`: Token inválido o sesión expirada.
- `404 Not Found`: Recurso no encontrado (ejemplo: tarea inexistente).
- `422 Unprocessable Entity`: Datos inválidos o faltantes.
- `500 Internal Server Error`: Error en el servidor.

## Comentarios finales
- No fue posible utilizar la base de datos PostgreSQL porque no se pudo conectar a Laravel.
- No se pudo finalizar la utilización de las API en el front de las tareas por falta de tiempo.

