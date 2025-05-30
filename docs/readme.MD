# Lightweight PHP MVC Framework (Custom Laravel-style)

This is a lightweight PHP MVC project with a simple CLI for generating files and managing database tables (migrations).

---

## 📁 Directory Structure

```
framework/
├── app/
│   ├── controller/
│   ├── models/
│   ├── views/
├── bin/
│   └── cli.php
├── config/
│   └── database.php
├── core/
│   └── Database.php
├── database/
│   ├── migrations/
│   └── migrate.php
├── docs/
│   ├── readme.MD
│   └── docs.txt
├── logs/
│   ├── auth_debug.log
│   └── admin_debug.log
├── public/
│   ├── index.php
│   └── router.php
├── scripts/
│   └── admin/
│       ├── create_admin.php
│       ├── fix_admin.php
│       └── check_admin.php
└── vendor/
```

---

## ⚙️ Requirements

- PHP 7.x or later
- MySQL/MariaDB
- CLI Access (e.g., Command Prompt, Terminal)

---

## 👨‍🛠️ How to Use

### 1. 📦 Create Files (Controller, Model, View)

Use the CLI tool to generate files automatically:

```bash
# Generate a controller
php bin/cli.php make:controller UserController

# Generate a model
php bin/cli.php make:model User

# Generate a view
php bin/cli.php make:view user_view
```

Generated files will go into their respective folders:
- Controllers → `app/controller/`
- Models → `app/models/`
- Views → `app/views/`

---

### 2. 🧱 Create a Migration File (for Table Creation)

Manually create a migration file inside the `/database/migrations/` folder.

Example file: `database/migrations/2025_04_04_184533_create_faculty_table.php`

```php
<?php

class CreateFacultyTable {
    public function up($pdo) {
        $query = "
            CREATE TABLE IF NOT EXISTS faculty (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100),
                email VARCHAR(100),
                department VARCHAR(100),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
        ";
        $pdo->exec($query);
    }
}
```

📝 **Important**: 
- Class names must NOT start with numbers
- Migration files should be named with timestamp prefix (YYYY_MM_DD_HHMMSS)
- Each migration should have a unique name

---

### 3. 🚀 Run Migrations (Push Tables to DB)

Use the migration runner to push your defined tables to the database:

```bash
php database/migrate.php
```

Each migration file will:
- Be loaded
- The class will be instantiated
- The `up()` method will be called to create your table

You will see success messages in your terminal.

---

### 4. 👤 Admin Management

The framework includes several admin management scripts:

```bash
# Create a new admin user
php scripts/admin/create_admin.php

# Fix admin user issues
php scripts/admin/fix_admin.php

# Check admin user status
php scripts/admin/check_admin.php
```

---

## ✅ Example Workflow

```bash
# Step 1: Generate controller, model, and view
php bin/cli.php make:controller FacultyController
php bin/cli.php make:model Faculty
php bin/cli.php make:view faculty

# Step 2: Create migration file
# (create manually: database/migrations/2025_04_04_184533_create_faculty_table.php)

# Step 3: Run migrations
php database/migrate.php

# Step 4: Create admin user (if needed)
php scripts/admin/create_admin.php
```

---

## 🔧 Config

Edit `config/database.php` to update your DB connection:

```php
class Database {
    public static function connect() {
        return new PDO('mysql:host=localhost;dbname=your_db_name', 'root', '');
    }
}
```

---

## 💡 Tips

- Keep migration filenames unique using timestamps (e.g. `2025_04_04_184533_create_users_table.php`)
- Check the logs directory for debugging information
- Use the admin scripts for user management
- The CLI tool can be extended to support more commands

---

## 📌 License

This is a custom educational framework inspired by Laravel. Not for production use.

