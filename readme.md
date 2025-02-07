# 👩‍💻 Milton Alberto Girón López

# 🛠️ Prueba técnica Angular + Laravel

🚀 Pasos para instalar y ejecutar tanto el **frontend (Angular)** como el **backend (Laravel)** en entorno local.  

---

## 📦 **Requisitos previos**
Antes de comenzar, asegurarse de tener instalados los siguientes programas en el sistema:

🔹 **[Node.js](https://nodejs.org/)** (para Angular v22.13.1)   
🔹 **[Composer](https://getcomposer.org/)** (para Laravel v2.5.8)   
🔹 **[PHP](https://www.php.net/)** (v8.2.25)      
🔹 **[MySQL](https://www.mysql.com/)**  
🔹 **[Laragon](https://laragon.org/download/)** (solo se necesita descargar la versión de node y agregarla dentro del path laragon/bin/nodejs)    
🔹 **[GitHub desktop](https://desktop.github.com/download/)** o por consola **[GitBash](https://git-scm.com/downloads)** (para clonar el repositorio)  

---

### 📝 Notas
* Para generar un api key con fines de pruebas, realizar una petición GET http://127.0.0.1:8000/generar-api-key
Respuesta
```
{
    "success": true,
    "message": "API key generada exitosamente",
    "data": {
        "key": "GZYc4RJn8iCfLMebHOdaJ5Mv4uXOe2E7"
    }
}
```
* Se adjunta collecciones de postman (api-key.postman_collection.json y estudiantes.postman_collection.json) con los endpoints y variables de entorno (prueba-tecnica.postman_environment.json) para realizar pruebas, se pueden encontrar en la raíz del proyecto prueba-tecnica, también se pueden ver desde [Postman](https://www.postman.com/miltongiron/workspace/prueba-tecnica-backend/request/10563632-2047036b-68c8-47fd-9a00-50331284eb98?action=share&creator=10563632&ctx=documentation&active-environment=10563632-b0e391f9-8d39-40f3-8cba-dd006ada0784)
* Se adjuntan capturas de la aplicación en angular (carpeta capturas en la raíz del proyecto) corriendo con diferentes escenarios (creación de estudiante, actualización de estudiante, listado de estudiantes según filtro y mensaje de no autorizado)

## 📝 **Clonar el repositorio**
Abir terminal ejecutar:  

```bash
git clone https://github.com/miltong261/prueba-tecnica.git
```

Moverse al directorio del proyecto
```bash
cd prueba-tecnica
```

```bash
git checkout feature/MiltonGiron
```

## 🚀 Backend (Laravel)
### 📦 1️⃣ Instalar dependencias

```bash
cd back-end
```

```bash
composer install
```

### ⚙️ 2️⃣ Configurar variables de entorno


```bash
cp .env.example .env
```
```
# DB_CONNECTION=sqlite
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306    
DB_DATABASE=nombre_base_datos
DB_USERNAME=usuario
DB_PASSWORD=contraseña 

API_KEY="your-api-key"
PAGINATION_SIZE=10
```

### 🔑 3️⃣ Generar clave de aplicación

```bash
php artisan key:generate
```

### 🛢️ 4️⃣ Ejecutar migraciones y seeders

```bash
php artisan migrate --seed
```

### ▶️ 5️⃣ Iniciar el servidor
```bash
php artisan serve
```

📌 El backend se ejecutará en: http://127.0.0.1:8000

## 🎨 Frontend (Angular)

### 📦 1️⃣ Instalar dependencias

```bash
cd fron-tend
```

```bash
npm install
```

### ⚙️ 2️⃣ Configurar variables de entorno

```bash
touch .env
```

```
NG_APP_API_ENDPOINT=endpoint
NG_APP_API_KEY=apikey
```

### ▶️ 3️⃣ Iniciar el servidor

```
ng serve --open
```
📌 El frontend se ejecutará en: http://localhost:4200

### ❌ Posibles mensajes de error

No autorizado (401 Unauthorized)
```
{
    "success": false,
    "message": "No autorizado: API key inválida"
}
```
Validación de campos (422 Unprocessable Content), en este caso todos los datos del estudiante son obligatorios
```
{
    "message": "El campo nombre es obligatorio.",
    "errors": {
        "first_name": [
            "El campo nombre es obligatorio."
        ]
    }
}
```
Error en servidor (500 Internal Server Error)
```
{
    "success": false,
    "error": "Se produjo un error al crear información del estudiante - Error de prueba"
}
```

### 🚀 endpoints

---
#  **Listar grados y secciones**

**Método:** `GET`  
**Ruta:** `/api/v1/grados-secciones`  
**Descripción:**  
Esta ruta permite obtener los grados y secciones existentes.


Petición
```
curl --location 'http://127.0.0.1:8000/api/v1/grados-secciones' \
--header 'Content-Type: application/json' \
--header 'Accept: application/json' \
--header 'X-API-Key: ••••••' \
--data ''
```
Respuesta (200 Ok)
```
{
    "success": true,
    "message": "Lista de grados y secciones",
    "data": {
        "grades": [
            {
                "id": 1,
                "name": "Primero",
                "sections": [
                    {
                        "id": 1,
                        "name": "A"
                    },
                    {
                        "id": 2,
                        "name": "B"
                    },
                    {
                        "id": 3,
                        "name": "C"
                    }
                ]
            }
        ]
    }
}
```
---
#  **Listar estudiantes**

**Método:** `GET`  
**Ruta:** `/api/v1/consultar-alumnos/{id_grado?}/{id_seccion?}`  
**Descripción:**  
Esta ruta permite obtener todos los estudiantes pertenecientes a un grado y/o sección, si no se enviara id_grado e id_seccion, muestra todos los grados en general, obteniendo 5 registros por página.


Petición
```
curl --location 'http://127.0.0.1:8000/api/v1/consultar-alumnos' \
--header 'Content-Type: application/json' \
--header 'Accept: application/json' \
--header 'X-API-Key: ••••••' \
--data ''
```
Respuesta (200 Ok)
```
{
    "success": true,
    "message": "Listado de estudiantes",
    "data": {
        "students": [
            {
                "id": 1,
                "first_name": "John",
                "last_name": "Doe",
                "complete_name": "John Doe",
                "date_of_birth": "2010-01-01",
                "date_of_birth_formatted": "01 de enero de 2010",
                "father_name": "John Doe Father",
                "mother_name": "John Doe Mother",
                "grade_id": 7,
                "grade": {
                    "id": 7,
                    "name": "Primero básico"
                },
                "section_id": 1,
                "section": {
                    "id": 1,
                    "name": "A"
                },
                "enrollment_date": "2025-02-06",
                "enrollment_date_formatted": "06 de febrero de 2025",
                "status": "activo"
            }
        ],
        "current_page": 1,
        "per_page": 5,
        "total": 11
    }
}
```
---
#  **Generar un nuevo recurso**

**Método:** `POST`  
**Ruta:** `/api/v1/crear-alumno`  
**Descripción:**  
Esta ruta permite crear un nuevo estudiante.


Petición
```
curl --location 'http://127.0.0.1:8000/api/v1/crear-alumno' \
--header 'Content-Type: application/json' \
--header 'Accept: application/json' \
--header 'X-API-Key: ••••••' \
--data '{
    "first_name": "John",
    "last_name": "Doe",
    "date_of_birth": "2010-01-01",
    "father_name": "John Doe Father",
    "mother_name": "John Doe Mother",
    "grade_id": 8,
    "section_id": 1,
    "enrollment_date": "2025-02-06",
    "status": "activo"
}'
```
Respuesta (201 Created)
```
{
    "success": true,
    "message": "Información del estudiante ingresada exitosamente",
    "data": {
        "student": {
            "id": 11,
            "first_name": "John",
            "last_name": "Doe",
            "complete_name": "John Doe",
            "date_of_birth": "2010-01-01",
            "date_of_birth_formatted": "01 de enero de 2010",
            "father_name": "John Doe Father",
            "mother_name": "John Doe Mother",
            "grade_id": 8,
            "grade": {
                "id": 8,
                "name": "Segundo básico"
            },
            "section_id": 1,
            "section": {
                "id": 1,
                "name": "A"
            },
            "enrollment_date": "2025-02-06",
            "enrollment_date_formatted": "06 de febrero de 2025",
            "status": "activo"
        }
    }
}
```
---
#  **Actualizar un recurso**

**Método:** `PUT`  
**Ruta:** `/api/v1/actualizar-alumno/{id}`  
**Descripción:**  
Esta ruta permite actualizar información de un estudiante.


Petición
```
curl --location --request PUT 'http://127.0.0.1:8000/api/v1/actualizar-alumno/1' \
--header 'Content-Type: application/json' \
--header 'Accept: application/json' \
--header 'X-API-Key: ••••••' \
--data '{
    "first_name": "John",
    "last_name": "Doe",
    "date_of_birth": "2010-01-01",
    "father_name": "John Doe Father",
    "mother_name": "John Doe Mother",
    "grade_id": 7,
    "section_id": 1,
    "enrollment_date": "2025-02-06",
    "status": "activo"
}'
```
Respuesta (200 OK)
```
{
    "success": true,
    "message": "Información del estudiante actualizada exitosamente",
    "data": {
        "student": {
            "id": 11,
            "first_name": "John",
            "last_name": "Doe",
            "complete_name": "John Doe",
            "date_of_birth": "2010-01-01",
            "date_of_birth_formatted": "01 de enero de 2010",
            "father_name": "John Doe Father",
            "mother_name": "John Doe Mother",
            "grade_id": 8,
            "grade": {
                "id": 8,
                "name": "Segundo básico"
            },
            "section_id": 1,
            "section": {
                "id": 1,
                "name": "A"
            },
            "enrollment_date": "2025-02-06",
            "enrollment_date_formatted": "06 de febrero de 2025",
            "status": "activo"
        }
    }
}
```