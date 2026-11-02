# Hielos del Maipo · API de solicitudes de pedido (Unidad 1)

Evaluación Sumativa U1 · Desarrollo Backend.

API REST en PHP con Laravel para registrar y consultar **solicitudes de pedido**.


## Requisitos
- PHP 8.3 o superior
- Composer 2
- MySQL o MariaDB (se probó con el que trae XAMPP)

## Instalación y ejecución local
1. Clonar el repositorio y entrar en la carpeta del proyecto.
2. Instalar dependencias: `composer install`
3. Copiar la configuración de ejemplo: `copy .env.example .env` (en Linux o Mac: `cp .env.example .env`)
4. Generar la clave de la aplicación: `php artisan key:generate`
5. Crear una base de datos vacía llamada `hielos_maipo` (cotejamiento `utf8mb4_unicode_ci`).
6. Revisar en `.env` los datos de conexión (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`). El archivo `.env` no se sube al repositorio.
7. Crear las tablas y cargar datos de prueba: `php artisan migrate --seed`
8. Levantar el servidor: `php artisan serve` (queda en `http://127.0.0.1:8000`)

## Endpoints
Todas las rutas llevan el prefijo `/api`. Enviar siempre el header `Accept: application/json`.

| Método | Ruta | Descripción | Códigos |
|---|---|---|---|
| GET | `/api/solicitudes-pedido` | Lista paginada (`?page=1&per_page=15`, máximo 100) | 200 |
| POST | `/api/solicitudes-pedido` | Crea una solicitud | 201, 422 |
| GET | `/api/solicitudes-pedido/{id}` | Muestra una solicitud | 200, 404 |
| PUT / PATCH | `/api/solicitudes-pedido/{id}` | Actualiza (PUT: todos los campos; PATCH: solo los enviados) | 200, 404, 422 |
| DELETE | `/api/solicitudes-pedido/{id}` | Elimina una solicitud | 204, 404 |

### Modelo `SolicitudPedido`
| Campo | Tipo | Regla de validación |
|---|---|---|
| id | entero | Generado automáticamente |
| cliente | texto | Obligatorio, de 3 a 100 caracteres (nombre o referencia ficticia) |
| cantidad | entero | Obligatorio, de 1 a 100000 (unidad de medida por confirmar) |
| fecha_requerida | fecha | Obligatoria, formato `AAAA-MM-DD`, no anterior a hoy |
| estado | texto | Opcional; uno de `pendiente`, `en_revision`, `completada`, `cancelada` (por defecto `pendiente`) |

### Ejemplo de petición válida
`POST /api/solicitudes-pedido`
```json
{ "cliente": "Cliente de ejemplo", "cantidad": 25, "fecha_requerida": "2026-12-15" }
```
Respuesta `201 Created` (ejemplo):
```json
{ "data": { "id": 17, "cliente": "Cliente de ejemplo", "cantidad": 25, "fecha_requerida": "2026-12-15", "estado": "pendiente" } }
```

### Ejemplo de petición inválida
`POST /api/solicitudes-pedido`
```json
{ "cliente": "", "cantidad": 0, "fecha_requerida": "15-12-2026", "estado": "inventado" }
```
Respuesta `422 Unprocessable Content` con un mensaje por cada campo en `errors`.

## Pruebas y evidencias
- Colección de Postman con 11 peticiones y pruebas automáticas: `docs/Hielos-del-Maipo-API.postman_collection.json`
- Resultado de la ejecución completa (21 pruebas, 0 fallos): `docs/`
- Comparación de rendimiento antes y después de la paginación, con las etiquetas de Git `antes-paginacion` y `despues-paginacion`.
- Para generar volumen de prueba: `php artisan db:seed --class=SolicitudPedidoMasivoSeeder` (20.000 registros ficticios).

## Relación con el frontend
Es un proyecto separado del frontend (otra asignatura). No se integran técnicamente en la Unidad 1, pero comparten el contexto. Correspondencia de campos:

| Frontend (formulario) | Backend (`SolicitudPedido`) |
|---|---|
| nombre | cliente |
| cantidad | cantidad |
| (no existe) | fecha_requerida, estado |
| contacto, formato, sector, comentario | no están en la entidad mínima |

## Dificultades conocidas
- La regla `fecha_requerida` no admite fechas pasadas, por lo que un `PUT` sobre una solicitud antigua exige una fecha nueva. El `PATCH` de solo el estado sí funciona.
- La paginación usa `OFFSET`; en páginas muy profundas de tablas con millones de filas sería más lenta (alternativa: paginación por cursor).
- No hay autenticación ni autorización: cualquier cliente puede usar todos los endpoints (alcance excluido en la Unidad 1).
- Las rutas usan HTTP sin cifrado (`http://127.0.0.1`), solo para desarrollo local.


## Declaración de uso de Inteligencia Artificial
* Ayuda con la instalación de php laravel.
* Ayuda para iterar error generado por un mal nombre en la bbdd (.env)
* Analisis de resultados de las pruebas aplicadas por mi (modo confirmación)
* Generación de readme estandar para ir completando con la información necesaria.
* Ayuda con un error de github por credenciales antiguas vinculadas a mi pc.
