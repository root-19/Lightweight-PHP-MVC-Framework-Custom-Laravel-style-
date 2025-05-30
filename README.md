# Root-Dev Framework

A lightweight PHP MVC Framework with Laravel-style syntax, built for modern web applications.

## Installation

You can install the framework using Composer:

```bash
composer require root_dev/framework
```

## Quick Start

1. After installation, create a new project:
```bash
composer create-project root_dev/framework my-project
cd my-project
```

2. Configure your environment:
```bash
cp .env.example .env
```

3. Start the development server:
```bash
php -S localhost:8000 -t public
```

## Features

- MVC Architecture
- Database Migrations
- CLI Commands
- Admin Management
- JWT Authentication
- Clean Routing System

## Basic Usage

### Creating a Controller

```php
namespace root_dev\Controller;

class ExampleController {
    public function index() {
        return $this->view->render('example/index', [
            'title' => 'Welcome'
        ]);
    }
}
```

### Database Migrations

```php
// database/migrations/2024_03_20_create_examples_table.php
class CreateExamplesTable {
    public function up($pdo) {
        $query = "
            CREATE TABLE IF NOT EXISTS examples (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(100) NOT NULL,
                description TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
        ";
        $pdo->exec($query);
    }
}
```

### CLI Commands

```bash
# Generate a new controller
php bin/cli.php make:controller UserController

# Generate a new model
php bin/cli.php make:model User

# Generate a new view
php bin/cli.php make:view user_view
```

## Documentation

For more detailed documentation, please visit our [documentation page](docs/readme.MD).

## License

This framework is open-sourced software licensed under the [MIT license](LICENSE). 