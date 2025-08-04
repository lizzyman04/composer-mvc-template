# Composer MVC Template

This project is a lightweight, modern MVC template built with **PHP** and **Composer**, following the Model-View-Controller (MVC) architecture. It provides a clean, organized structure for developing PHP applications, with features like user authentication, image uploading, email handling, environment configuration, and styling with **Tailwind CSS** via the Play CDN.

This README guides you through setting up the project, using its features, and understanding its structure.

## Table of Contents

1. [Prerequisites](#prerequisites)
2. [Installation](#installation)
3. [Project Structure](#project-structure)
4. [Configuration](#configuration)
5. [Usage](#usage)
   - [Authentication](#authentication)
   - [Image Upload](#image-upload)
   - [Sending Emails](#sending-emails)
   - [Styling with Tailwind CSS](#styling-with-tailwind-css)
   - [Using jQuery](#using-jquery)
6. [Environment Configuration](#environment-configuration)
7. [Troubleshooting](#troubleshooting)
8. [Contributing](#contributing)
9. [License](#license)

---

## Prerequisites

Before you begin, ensure you have the following installed:

- **PHP** >= 7.4
- **Composer**: [Download Composer](https://getcomposer.org/)
- **Database**: MySQL or PostgreSQL (configured in `.env`)
- **Internet Connection**: Required for loading **Tailwind CSS** via the Play CDN and **jQuery** CDN.

---

## Installation

1. Clone the repository:

```bash
git clone https://github.com/lizzyman04/composer-mvc-template.git my-composer-app
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

7. Composer provides useful scripts for managing the project:

   - **Start the local development server** on `http://localhost:8000`:

   ```bash
   composer serve
   ```

   - **Run migrations** to create missing database tables:

   ```bash
   composer migrate
   ```

   - **Reset the database** (drops all tables and recreates them):

   ```bash
   composer migrate:reset
   ```

   > **Note**: The `migrate:reset` command deletes all existing tables and recreates them. The `migrate` command only creates tables that do not yet exist.

8. Start the local server:

```bash
composer serve
```

Visit [http://localhost:8000](http://localhost:8000) in your browser.

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
│   │   ├── /layouts
│   │   │   ├── main.php
│   │   │   ├── tailwinds.php
│   ├── └──...
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

- **/public**: Contains publicly accessible files:
  - `/assets`: Static files (eg: images, JavaScript).
  - `index.php`: Application entry point.
  - `/uploads`: Directory for user-uploaded files (e.g., images).

- **/src**: Core application logic:
  - `/Controllers`: Handles requests and interacts with models.
  - `/Models`: Defines data structures and interacts with the database.
  - `/Views`: Templates for rendering HTML pages.
  - `/Views/layouts`: Contains layout files including `main.php` (base template).

- **/core**: Utility classes:
  - `Mailer.php`: Manages email sending.
  - `Router.php`: Handles routing (uses `/config/endpoints.php`).
  - `Uploader.php`: Manages file uploads.
  - `View.php`: Renders views and templates.

- **/database**: Database management files:
  - `connection.php`: Establishes database connections.
  - `migrate.php`: Manages database migrations (uses `/config/database.php`).

- **/config**: Configuration files:
  - `config.php`: Main project configuration.
  - `database.php`: Database settings and migration functions.
  - `endpoints.php`: Application routes.

- **.env**: Stores sensitive configuration (e.g., database credentials, email settings).
- **.env.example**: Template for creating `.env`.
- **.gitignore**: Specifies files/directories ignored by Git.
- **composer.json**: Manages Composer dependencies.
- **LICENSE**: Project license.
- **README.md**: Project documentation.

---

## Configuration

### 1. **Database Configuration**
Update the `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

### 2. **Email Configuration (Optional)**
Configure SMTP settings in the `.env` file for email functionality:

```env
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

The project includes user authentication with login and registration forms, handled by the `AuthController`. Customize the views in `/src/Views/auth.php` as needed.

- **Login**: Users provide email and password to log in.
- **Registration**: Users create accounts with name, email, and password.

The `AuthController` validates input and manages authentication.

### Image Upload

The `Uploader` class handles file uploads (e.g., images):

```php
use Core\Uploader;

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

Ensure the `uploads/` directory has write permissions (e.g., `chmod 755 uploads`).

### Sending Emails

The `Mailer` class uses **PHPMailer** to send emails:

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

Emails are sent in HTML format with personalized greetings and a footer.

### Styling with Tailwind CSS

This project uses **Tailwind CSS** via the Play CDN for styling, eliminating the need for a build step during development. The base layout (`/src/Views/layouts/main.php`) includes the Tailwind CSS CDN.

#### Example Usage in Views

Apply Tailwind utility classes directly in your views:

```php
<div class="bg-gray-100 p-6 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold text-clifford">Welcome!</h1>
    <p class="mt-4 text-gray-600">This is a Tailwind-styled component.</p>
</div>
```

### Using jQuery

The project includes **jQuery** via a CDN for client-side scripting, loaded in the `main.php` layout. Use jQuery to add interactivity to your views.

#### Example jQuery Usage

```php
<script>
    $(document).ready(function() {
        $('.toggle-button').click(function() {
            $('.content').toggleClass('hidden');
        });
    });
</script>
```

```php
<button class="toggle-button bg-blue-500 text-white px-4 py-2 rounded">Toggle</button>
<div class="content mt-4">This content can be toggled.</div>
```

Ensure jQuery scripts are placed after the CDN include in `main.php`.

---

## Troubleshooting

1. **Missing Dependencies**: If `composer install` fails, ensure PHP extensions (e.g., `pdo_mysql`) are enabled. Re-run `composer install`.

2. **Database Connection Error**: Verify `.env` database credentials and ensure the database server is running.

3. **Email Sending Issues**: Check `.env` SMTP settings. Test with a third-party email service if needed.

4. **File Upload Issues**: Ensure the `uploads/` directory has write permissions (e.g., `chmod 755 uploads`).

5. **Tailwind CSS Not Loading**: Confirm an active internet connection for the Play CDN. For production, switch to a static build.

6. **jQuery Errors**: Ensure jQuery scripts are loaded after the CDN include. Check browser console for errors.

---

## Contributing

Contributions are welcome! To contribute:

1. Fork the repository.
2. Create a feature branch (`git checkout -b feature/your-feature`).
3. Commit your changes (`git commit -m 'Add your feature'`).
4. Push to the branch (`git push origin feature/your-feature`).
5. Open a pull request.

Please include tests and documentation for your changes.

---

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

---

## Conclusion

This Composer MVC template provides a robust foundation for PHP applications, with features like authentication, file uploads, email handling, Tailwind CSS for styling, and jQuery for interactivity. With minimal setup, you can build and customize powerful web applications.

Happy coding! 🚀