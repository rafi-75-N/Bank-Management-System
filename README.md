# Banking System (PHP + MySQL + Bootstrap)

A beginner-friendly CRUD project that implements the Banking System from your ER diagram.

## Stack
- PHP 8+ (XAMPP Apache)
- MySQL (XAMPP)
- Bootstrap 5

## Setup
1. Copy the entire **banking_system** folder into your XAMPP `htdocs` directory.
2. Start **Apache** and **MySQL** in XAMPP.
3. Open **phpMyAdmin** at `http://localhost/phpmyadmin`.
4. Create a database named **bank_db**.
5. Import the SQL file: `banking_system/database.sql`.
6. Visit the app: `http://localhost/banking_system/`.

## Notes
- All primary keys are `AUTO_INCREMENT` for easy inserts.
- Foreign keys enforce referential integrity.
- Use the navbar to navigate each entity and perform Create / Read / Update / Delete.
