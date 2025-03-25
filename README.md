# Composer MVC Template

This project is a powerful, lightweight MVC template built with **PHP** and **Composer**. It follows the MVC (Model-View-Controller) architecture to provide a clean, organized structure for developing modern PHP applications. It also incorporates useful features like image uploading, email handling, user authentication, and environment configuration using `.env` files.

This README will guide you through setting up the project, using its features, and understanding its structure.

## Table of Contents

1. [Prerequisites](#prerequisites)
2. [Installation](#installation)
3. [Project Structure](#project-structure)
4. [Configuration](#configuration)
5. [Usage](#usage)
   - [Authentication](#authentication)
   - [Image Upload](#image-upload)
   - [Sending Emails](#sending-emails)
6. [Environment Configuration](#environment-configuration)
7. [Troubleshooting](#troubleshooting)

---

## Prerequisites

Before you begin, ensure you have the following installed:

- **PHP** >= 7.4
- **Composer**: [Download Composer](https://getcomposer.org/)
- **Database**: MySQL or PostgreSQL (depending on your choice in `.env`)

---

## Installation

1. Clone the repository:

```bash
git clone https://github.com/Lizzyman04/composer-mvc-template.git my-composer-app
```

2. Navigate to the project directory:

```bash
cd my-composer-app
```

3. Install the required Composer dependencies:

```bash
composer install
```

4. Set up your environment file by copying the default `.env.example` file to `.env`:

```bash
cp .env.example .env
```

5. Update your `.env` file with your database and email configurations.

6. Set up your database by running migrations or manually creating tables according to your project's needs.

7. Composer provides some useful scripts for managing the project, particularly for migrations and server startup. 

   - **To start the local development server** on `http://localhost:8000`, you can use the following command:

   ```bash
   composer serve
   ```

   - **To run migrations** (which will create any missing tables in the database), use:

   ```bash
   composer migrate
   ```

   - **To reset the database** and drop all existing tables before recreating them, use:

   ```bash
   composer migrate:reset
   ```

   The `migrate:reset` command will **delete all the existing tables** and recreate them from scratch. The `migrate` command, on the other hand, will **only create tables that do not exist yet**, leaving any existing tables untouched.

8. After running the necessary migrations, **start the local server** with:

```bash
composer serve
```

And then visit [http://localhost:8000](http://localhost:8000).

---

## Project Structure

Here's an overview of the main project directories and files:

```
/composer-mvc-template
├── /public
│   ├── /assets
│   │   ├── /css
│   │   ├── /img
│   │   └── /js
│   ├── index.php
│   ├── 404.php
│   ├── /uploads
├── /src
│   ├── /Controllers
│   ├── /Models
│   ├── /Views
├── /core
│   ├── Mailer.php
│   ├── Router.php
│   ├── Uploader.php
│   └── View.php
├── /database
│   ├── connection.php
│   └── migrate.php
├── /config
│   ├── config.php
│   ├── database.php
│   └── endpoints.php
├── .env
├── .env.example
├── .gitignore
├── composer.json
├── LICENSE
└── README.md
```

### Directory Descriptions:

- **/public**: The public directory contains all publicly accessible files. This includes:
  - `/assets`: Static files such as images, CSS, and JavaScript.
  - `index.php`: The entry point for the application.
  - `404.php`: Custom 404 error page.
  - `/uploads`: Directory for user-uploaded files (such as images).

- **/src**: This folder contains the core logic of your application:
  - `/Controllers`: Controllers responsible for handling requests and interacting with models.
  - `/Models`: Models which interact with the database and define the application’s data structure.
  - `/Views`: Templates for rendering the HTML pages of the application.

- **/core**: Contains helper and utility classes:
  - `Mailer.php`: Handles email sending functionality.
  - `Router.php`: Loads and manages the routes defined in `/config/endpoints.php`.
  - `Uploader.php`: Handles file uploads (such as images).
  - `View.php`: Responsible for rendering the views and templates.

- **/database**: Contains files related to database management:
  - `connection.php`: Establishes the connection to the database.
  - `migrate.php`: Manages database migrations to create tables as defined in `/config/database.php` from the `config` folder.

- **/config**: Contains basic configuration files:
  - `config.php`: The main configuration file for the project.
  - `database.php`: Contains functions and settings for creating and managing the database.
  - `endpoints.php`: Defines the routes for the application.

- **.env**: Environment file that contains sensitive configuration data such as database credentials and email settings.
- **.env.example**: Example environment file template for creating your own `.env` file.
- **.gitignore**: Specifies files and directories that Git should ignore.
- **composer.json**: The Composer dependencies file, used to manage project libraries and dependencies.
- **LICENSE**: The project license file.
- **README.md**: The project documentation.

---

## Configuration

Before running the application, you must configure the following:

### 1. **Database Configuration**:
In the `.env` file, set your database credentials:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

### 2. **Email Configuration (Optional)**:
Set your email SMTP configuration in the `.env` file:

```
MAIL_HOST=smtp.your-email-provider.com
MAIL_PORT=587
MAIL_USERNAME=your-email@example.com
MAIL_PASSWORD=your-email-password
MAIL_FROM_ADDRESS=no-reply@example.com
MAIL_FROM_NAME=YourApp
SUPPORT_EMAIL=support@example.com
```

---

## Usage

### Authentication

The system includes user authentication with login and registration forms. You can customize the `auth.php` views as needed.

1. **Login**: Users can log in by providing their email and password.
2. **Registration**: Users can create a new account by providing their name, email, and password.

Both forms are handled by the `AuthController`. This controller uses basic validation to ensure fields are filled and users are properly authenticated.

### Image Upload

The `Uploader` class provides a simple method for uploading images. Here's how to use it:

```php
use Core\Uploader;

// Assuming a form is used to upload an image
if ($_FILES['image']) {
    try {
        $targetDir = 'uploads/images';
        $uploadedImagePath = Uploader::uploadImage($_FILES['image'], $targetDir);
        echo "Image uploaded to: " . $uploadedImagePath;
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
```

This handles both Laravel-style file uploads and regular file array uploads.

### Sending Emails

The `Mailer` class uses **PHPMailer** to send emails. Here's how you can create and send an email:

```php
use Core\Mailer;

$mailer = new Mailer();
$name = "Arlindo Abdul";
$message = "Welcome to our platform! We're glad to have you on board.";
$body = $mailer->create($name, $message);

$sendResult = $mailer->send('recipient@example.com', $name, 'Welcome to Our Platform', $body);

if ($sendResult['success']) {
    echo "Email sent successfully!";
} else {
    echo "Failed to send email: " . $sendResult['message'];
}
```

This email is sent in HTML format, and includes a personalized greeting and footer with support information.

---

## Environment Configuration

Make sure your `.env` file is set up correctly before running the application. The `.env` file contains essential information like database credentials, SMTP settings, and environment-specific variables.

### Example `.env` file:

```env

# Application Configuration
APP_URL=
APP_ENV=

# Database Configuration
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

# Mail Configuration
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME=

# Support Email Configuration
SUPPORT_EMAIL=

```

---

## Troubleshooting

1. **Missing Dependencies**: If Composer fails to install the required dependencies, ensure that you have the necessary PHP extensions installed. Run `composer install` again after fixing any missing extensions.

2. **Database Connection Error**: Double-check your `.env` file for the correct database credentials. Make sure the database server is running.

3. **Email Sending Issues**: Ensure that your email SMTP settings are correct in the `.env` file. You can test the email configuration by sending a test email from a different service.

4. **File Upload Issues**: If image uploads fail, ensure that your web server has the necessary permissions to write to the `uploads/` directory. You might need to adjust folder permissions (e.g., `chmod 755`).

---

## Conclusion

This Composer MVC template is a great starting point for building PHP applications using the MVC architecture. It provides easy-to-use features for user authentication, file uploads, and email handling. With a few simple configurations, you can have a powerful web application up and running quickly.

If you have any questions or run into issues, feel free to open an issue on the project’s GitHub repository.

Happy coding!