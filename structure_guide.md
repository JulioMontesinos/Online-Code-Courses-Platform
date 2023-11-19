# Project Structure and Naming Conventions

## Folder Structure

- **`src/`**: Contains all the source code of the application.
- **`src/imgs/`**: Holds all the images used in the application.
- **`src/libs/`**: Houses libraries created for database connection, table creation, code editor usage, and app functionality.
- **`src/navs/`**: Stores files dedicated to the creation of navigation elements.
- **`src/sessions/`**: Includes the file responsible for checking if a user role session exists to allow access to the registered user environment.
- **`src/usr_adm/`**: Contains files accessible only to the administrator.
- **`src/usr_prof/`**: Encompasses files accessible to both the administrator and professors.
- **`src/usr_alu/`**: Encompasses files accessible to the administrator, professors, and students (all registered users).
- **`src`**: `01_login_X.php` and `02_registration_X.php`, where X could be _m, _v, or _c, are visible to all users, including unregistered users.
- **`db/`**: Contains the SQL file and user login credentials.

## Naming Conventions

- **Models (_m):** Files representing data logic and interaction with the database.
  - Example: `01_login_m.php`

- **Views (_v):** Files responsible for presentation and the user interface.
  - Example: `01_login_v.php`

- **Controllers (_c):** Files managing UI logic and coordinating interactions between models and views.
  - Example: `01_login_c.php`
