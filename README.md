# 🎓 College Events Management System
A dynamic web application built with **Vanilla PHP** and **MySQL** to manage campus events.

## 🚀 Features
* **Event CRUD:** Add, Edit, and Delete events via an Admin panel.
* **Student Registration:** Users can sign up for specific events.
* **Email Verification:** PHP-based OTP system for secure registration.
* **Responsive UI:** Built with HTML5, CSS3, and Bootstrap 5.

## 🛠️ Tech Stack
* **Backend:** PHP (Procedural/OOP)
* **Database:** MySQL
* **Frontend:** Bootstrap 5, JavaScript, jQuery

## ⚙️ Setup Instructions
1. Clone this repo: `git clone https://github.com/Luxmi1310/college-events-php.git`
2. Move the folder to your local server (e.g., `C:/xampp/htdocs/`).
3. Open **phpMyAdmin** and create a database named `college_db`.
4. Import the `database.sql` file included in this repository.
5. Update your database credentials in `db_config.php`:
   ```php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "event";
