# Online Code Courses Platform

This web application has been developed to address the need for a straightforward online programming code editor that enhances the user experience within the context of programming courses. It functions as a web-based course platform catering to administrators, teachers, students, and unregistered users. Unregistered users have the capability to browse available courses, while registered users can request enrollment in a specific course.

The platform facilitates course information retrieval, allows users to complete assignments using an online code editor environment powered by Pyodide (Python in the browser), eliminating the need for a separate server to run Python code. Students can view their assignment grades, and courses are managed by both responsible and non-responsible teachers.

## Features

### User Roles

- **Unregistered Users:**
  - View available courses.

- **Registered Users:**
  - Request enrollment in courses.
  - Access course details.
  - Complete and submit assignments using the online code editor.
  - View assignment grades.

- **Teachers (Responsible and Non-Responsible):**
  - Create tasks and assignments.
  - Edit course information.
  - Grade assignments for students.
  - Accept or reject student enrollment requests.
  - Manage non-responsible teachers for each course.

- **Administrators:**
  - Create and manage teacher accounts.
  - Assign administrative roles.
  - No ability to create new administrator accounts within the application.

## Technical Stack

- Frontend: HTML, JavaScript, CSS, AJAX.
- Backend: PHP, Pyodide for online Python code execution.
- Database: MySQL.
- Development Technique: Model-View-Controller (MVC).


## Getting Started

To get started with this project, follow these steps:

### Prerequisites

Ensure you have the following components installed:

- [MySQL](https://www.mysql.com/): Make sure you have a recent version of MySQL installed on your system. You can use XAMPP, but it's optional.

If you choose to use XAMPP:

- [XAMPP](https://www.apachefriends.org/index.html): We use XAMPP as the development environment, which includes Apache, MySQL, PHP, and more.
- [PHP](https://www.php.net/): Ensure you have a recent version of PHP installed on your system.

### Installation

1. Download and install [XAMPP](https://www.apachefriends.org/index.html) if you haven't already.
2. Clone this repository to your local machine.
   ```bash
   git clone https://github.com/JulioMontesinos/Online-Code-Courses-Platform.git
3. Start XAMPP and ensure that Apache and MySQL are active.
4. Import the provided SQL file in the db/ folder into your database using phpMyAdmin.
5. Open your browser and access the project via `http://localhost/YourProject`.

## Authentication and Authorization

- User authentication ensures privacy and access control based on user roles.
- Administrators manage teacher accounts but cannot access or modify their personal data.

## Notes

- Users cannot simultaneously be both a teacher and a student in the same course.
- All interactions are secured through authentication, providing role-based access to distinct features.

## License

This project is licensed under the MIT License.
