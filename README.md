# Prueba Practica Backend GrupoApok (Graph API) - Solución

Esta es una solución a la prueba técnica de grupoapok para desarrolladores Backend (PHP/Laravel), la solución consiste en una API REST para la gestión de estructuras de árboles (nodos), con soporte para internacionalización y conversión de zona horaria.

## 🛠 Tecnologías
- **Framework:** Laravel 12.49.0 / PHP 8.2
- **Motor DB:** MySQL 8.0 (Soporte para CTEs)
- **Librería Clave:** `staudenmeir/laravel-adjacency-list` para gestión eficiente de grafos.

## ⚙️ Instalación

1. **Clonar el Repositorio**
   ```bash
	git clone https://github.com/DancasDev/grupoapok-test-php.git
	cd grupoapok-test-php
   ```
2. **Instalar Dependencias**
   ```bash
	composer install
   ```
3. **Configuración del Entorno**
   ```bash
	cp .env.example .env
   ```

`Nota:` Abre el archivo .env y configura las credenciales de la base de datos (DB_DATABASE, DB_USERNAME, DB_PASSWORD). Asegúrate de usar un motor compatible con CTEs

4. **Preparar la Aplicación**
   ```bash
	php artisan migrate --seed
	php artisan db:seed --class=NodeSeeder
   ```

5. **Iniciar el Servidor**
   ```bash
	php artisan serve
   ```
   
## 🔌 Documentación de la API

**Headers Requeridos para Funcionalidades Especiales**
- `Accept-Language`: `en` | `es` - Traduce el campo `title`.
- `X-Timezone`: Ejemplo `America/Caracas` o `Europe/Madrid`

**Endpoints**
- `POST /api/v1/nodes`: Crea un nodo. Envía `{"parent": id}` o `{"parent": null}`.
- `GET /api/v1/nodes/{id}/parents?depth=-n`: Lista los ancestros del nodo (`solución 1` a `Listar nodos padres`).
- `GET /api/v1/nodes/root`: Lista los nodos raiz (`solución 2` a `Listar nodos padres`).
- `GET /api/v1/nodes/{id}/children?depth=n&toTree=true`: Lista hijos con profundidad y formato de árbol opcional.
- `DELETE /api/v1/nodes/{id}`: Elimina si no tiene hijos.

**Colecciones de API (Importable)**

Para facilitar las pruebas de integración, se han incluido dos archivos de colección en la raíz del proyecto que contienen ejemplos pre-configurados de todas las peticiones, incluyendo los headers de lenguaje y zona horaria:

- `collection-postman.json`: Colección estándar para ser utilizada en Postman.
- `collection-bruno.json`: Colección estándar para ser utilizada en Bruno.