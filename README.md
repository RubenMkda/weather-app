# Instalación y uso de la API Laravel con Sanctum

Este proyecto es una API desarrollada con Laravel y Sanctum para autenticación.  
Aplica principios SOLID en servicios y controladores.  
Además, incluye documentación Swagger y una colección Postman para facilitar las pruebas.

---

## Requisitos

- PHP >= 8.0  
- Composer  
- MySQL o base de datos compatible  
- Laravel 10.x (o versión compatible con Sanctum)  

---

## Instalación desde el repositorio

1. Clona este repositorio:

   ```bash
   git clone https://github.com/tuusuario/tu-repo-api.git
   cd tu-repo-api
````

2. Instala las dependencias de PHP y npm:

   ```bash
   composer install
   npm install
   ```

3. Copia el archivo de entorno de ejemplo:

   ```bash
   cp .env.example .env
   ```

4. Genera la clave de aplicación:

   ```bash
   php artisan key:generate
   ```

5. Ejecuta las migraciones y los seeders:

   ```bash
   php artisan migrate --seed
   ```

6. Levanta el servidor:

   ```bash
   php artisan serve
   ```

---

## Funcionalidad

Los usuarios pueden consultar el clima sin autenticarse.
Sin embargo, si hacen demasiadas solicitudes anónimas, perderán el acceso a datos actualizados hasta que se registren.

La API es multilenguaje.
Puedes cambiar el encabezado `Accept-Language` para registrar usuarios en diferentes idiomas, como chino.

---

## Documentación

* **Postman:** [Colección aquí](https://www.postman.com/api-zois/weatherapp/request/fnznl63/index)
* **Swagger:** [Documentación aquí](https://app.swaggerhub.com/apis/rubenmkda-03d/weather-api/1.4)

---

## Notas técnicas

* Arquitectura basada en principios **SOLID**.
* Estructura limpia con separación clara entre lógica de negocio y controladores.
* Buenas prácticas de desarrollo y seguridad implementadas.
