# Bibliotech

Bibliotech es una app ficticia para gestionar una biblioteca.

---

##Instalación

### 1. Descargar proyecto del repositorio
descargar proyecto del repositorio

### 2. Instalar aplicaciones necesarias
Se deberán instalar las siguientes aplicaciones para ejecutar este proyecto:
- Symfony
- Composer
- Yarn

### 3. Instalar dependencias
Instalar dependencias

### 4. Crear y configurar la base de datos
Crear una base de datos mysql y enlazarla en archivo .env

### 4. Ejecuta las migraciones
En el directorio raiz de la apliación ejecuta las migraciones con este comando:

    php bin/console doctrine:migrations:migrate

### 5. Crea los datos de prueba
Ejecuta el siguiente comando para crear algunos datos de prueba (editoriales, categorías y autores):

    php bin/console app:create-dummy-data

### 6. Compila los assets
Ejecuta el siguiente comando para compilar los assets:

    yarn encore dev --watch

### 7. Inicia el servidor
Ejecuta el siguiente comando para iniciar el servidor:

    symfony server:start

---

Tras estos pasos el proyecto debería estar disponible en la ruta predefinida en symfony (por defecto: http://127.0.0.1:8000/)

NOTA IMPORTANTE: Cuando te pongas a programar no te fíes del código previo. Hay algo de espagueti intencionado del que
no estamos orgullosos ;)