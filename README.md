# Around Aruba Ticket Manager

Simple PHP/MySQL admin application for generating and managing UTV tour tickets.

## Features

- Secure admin login with hashed passwords and session protection
- Ticket creation form for UTV tours
- Ticket management table with edit, delete, email, and PDF download actions
- PDO prepared statements, CSRF protection, and basic validation
- Lightweight MVC-style structure without external dependencies

## Project Structure

- `index.php` - front controller and route entry point
- `app/Controllers` - request handlers
- `app/Models` - database queries
- `app/Views` - UI templates
- `app/Core` - bootstrap, auth, session, validation, mail, and PDF helpers
- `database/schema.sql` - MySQL schema
- `setup.php` - one-time admin creation page

## Setup

1. Create a MySQL database and import `database/schema.sql`.
2. Update `config/config.php` with your MySQL and mail settings.
3. Serve the project with PHP, for example: `php -S localhost:8000`.
4. Open `/setup.php` once to create the first admin account.
5. Delete or restrict `setup.php` after the admin is created.
6. Log in at `/index.php?route=login`.

## Notes

- Email sending uses PHP `mail()`, so the server must be configured to send mail.
- PDF generation is dependency-free and produces a simple downloadable ticket PDF.
- If you later want cleaner URLs or richer PDFs, this structure is ready for improvements.
