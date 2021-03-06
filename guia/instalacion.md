# Instrucciones de instalación y despliegue

## En local

#### Debes tener:
- *PHP 7.3.0*
- *PostgreSQL 11.7 o superior*
- *Composer*
- *Cuenta de email*
- *Git*
- *Cuenta en [IGDB](https://api.igdb.com/)*

#### Instalación:

1. Crear un directorio `myplaylist` y nos cambiamos a ese directorio.

2. Ejecutamos los siguientes comandos:
```
git clone https://github.com/jmsaborido/myplaylist.git .
composer install
```

3. Crear las variable de entorno en el archivo `.env` listadas en su pariente versionado `.env.dist`:
    * `SMTP_PASS` con la clave de aplicacion de la dirección de correo.
    * `SMTP_USERNAME` con la direccion de correo electronico.
    * `APIKEY`  Con la clave de acceso a la plataforma IGDB

4. Creamos la base de datos y las respectivas tablas para hacer funcionar la aplicación:
```
db/create.sh
db/load.sh
```
6. Ejecutamos el comando `make serve`
7. Para acceder introducimos en el navegador `localhost:8080`.

## En la nube

#### Requisitos:
- *Heroku cli*

#### Despliegue:

1.  Realizamos un fork a el proyecto en: https://github.com/jmsaborido/myplaylist

2.  Creamos una aplicación en heroku y la enlazamos con nuestro forkeo en github.

3. Añadiremos el add-on *Heroku Postgres*

4.  Nos vamos al directorio donde hemos clonado la aplicación y ejecutamos:
```
heroku login
heroku psql < db/myplaylist.sql -a nombre_aplicacion
```
5.  Configuramos las variables de entorno:
    * `YII_ENV` con el modo en el que se desplegará la aplicación.
    * `DATABASE_URL` con la URL de la base de datos proporcionada en el paso 3.
     * `SMTP_PASS` con la clave de aplicacion   de la dirección de correo.
    * `SMTP_USERNAME` con la direccion de correo electronico.
    * `APIKEY`  Con la clave de acceso a la plataforma IGDB
    *  `TZ` con la zona horaria en la que estes.

6. La aplicación está lista para funcionar