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

### Technical Stack

- Frontend: HTML, JavaScript, CSS, AJAX
- Backend: Pyodide for online Python code execution
- Database: MySQL
- Development Technique: Model-View-Controller (MVC)

### Getting Started!

...


### Authentication and Authorization

- User authentication ensures privacy and access control based on user roles.
- Administrators manage teacher accounts but cannot access or modify their personal data.

### Notes

- Users cannot simultaneously be both a teacher and a student in the same course.
- All interactions are secured through authentication, providing role-based access to distinct features.

### License

This project is licensed under the MIT License.
