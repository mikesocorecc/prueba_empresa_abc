
# Getting started

## Installation

Pasos para realizar la instalacion

Clone el repositorio

    git clone https://github.com/mikesocorecc/prueba_empresa_abc.git

Cambiar a la carpeta

    cd prueba_empresa_abc

Instale todas las dependencias de composer

    composer install

Copie el ejemplo de Ejemplo ENV y haga los cambios de configuración requeridos en el archivo .env

    cp .env.example .env

Generar una nueva clave de aplicación

    php artisan key:generate

Ejecute las migraciones de la base de datos (** Establezca la conexión de la base de datos en .env antes de migrar **)

    php artisan migrate

Iniciar el servidor de desarrollo local

    php artisan serve

Ahora puede acceder al servidor en http://localhost:8000

** TL; Lista de comandos DR **

    git clone https://github.com/mikesocorecc/prueba_empresa_abc.git
    cd prueba_empresa_abc
    composer install
    cp .env.example .env
    php artisan key:generate
    
** Asegúrese de configurar la información de conexión de base de datos correcta antes de ejecutar las migraciones ** [variables de entorno](#Variables de entorno)

    php artisan migrate
    php artisan serve

## crédito
- [volar template](https://getstisla.com/)
- [framework laravel](https://laravel.com/)
- [vue.js](https://vuejs.org/v2/guide/)
- [jwt token](https://jwt.io/)
- [bootstrap](https://getbootstrap.com/docs/4.6/getting-started/introduction/)
- [SweetAlert](https://sweetalert2.github.io/)


