# Project Structure and Naming Conventions

## Folder Structure

- **`src/`**: Contains all the source code of the application.
- **`src/imgs`**: Contains all images of the application.
- **`src/libs`**: Contiene las librerías creadas para la conexión a la bbdd, para creación de tablas, utilización del editor de código online y para la funcionalidad de la app.
- **`src/navs`**: Contiene todos los ficheros destinados a la creación de los navs
- **`src/sessions`**: Contiene el fichero que comprueba si existe una sesión de rol del usuario para permitir al entorno del usuario registrado
- **`src/usr_adm`**: Contiene todos los ficheros en los que únicamente tiene acceso el administrador
- **`src/usr_prof`**: Contiene todos los ficheros en los que tiene acceso el administrador y los profesores
- **`src/usr_alu`**: Contiene todos los ficheros en los que tiene acceso el administrador, los profesores y los alumnos (Todos los usuarios registrados)
- **`src`**: `01_login_X.php` and `02_registration_X.php`where X could be _m, _v or _c are visible for all users including the unregistered users.

## Naming Conventions

- **Models (_m):** Files representing data logic and interaction with the database.
  - Example: `01_login_m.php`

- **Views (_v):** Files responsible for presentation and the user interface.
  - Example: `01_login_v.php`

- **Controllers (_c):** Files managing UI logic and coordinating interactions between models and views.
  - Example: `01_login_c.php`
