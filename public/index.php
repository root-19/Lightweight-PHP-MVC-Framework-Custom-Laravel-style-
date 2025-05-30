<?php
// session_start();
require_once __DIR__ . '/../vendor/autoload.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to Root-Dev</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .typewriter-text::after {
            content: '|';
            animation: blink 1s infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }

        .full-height {
            min-height: 100vh;
        }

        .code-block {
            background-color: #1a1a1a;
            padding: 1rem;
            border-radius: 0.5rem;
            font-family: monospace;
            overflow-x: auto;
        }

        .guide-section {
            margin-bottom: 2rem;
            padding: 1rem;
            border: 1px solid #333;
            border-radius: 0.5rem;
            flex: 1 1 calc(50% - 1rem);
            min-width: 300px;
        }

        .step-number {
            background-color: #dc2626;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.5rem;
        }

        .step {
            margin-bottom: 1rem;
            padding: 0.5rem;
            border-left: 2px solid #dc2626;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s, transform 0.5s;
        }

        .step.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .step-content {
            display: none;
        }

        .step-content.visible {
            display: block;
        }
    </style>
</head>
<body class="bg-black text-white">
    <!-- Header -->
    <header class="py-4">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <div class="text-2xl font-bold text-red-600">Next Gen </div>
                <nav class="space-x-6">
                    <a href="/login" class="nav-link text-white hover:text-red-600">Login</a>
                    <a href="/register" class="nav-link text-white hover:text-red-600">Register</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Welcome Section -->
    <div class="container mx-auto px-4 py-8">
        <div class="text-center mb-12">
            <h1 class="text-6xl font-bold mb-6">
                <span class="text-red-600">Root-Dev</span> PHP Framework
            </h1>

            <p id="typewriter" class="text-xl text-gray-300 mb-10 typewriter-text"></p>

         
        </div>

        <!-- Framework Guide -->
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold mb-6 text-red-600">Framework Guide</h2>

            <!-- Guide Sections Grid -->
            <div class="flex flex-wrap gap-4">
                <!-- Project Structure -->
                <div class="guide-section">
                    <h3 class="text-2xl font-bold mb-4">Project Structure</h3>
                    <div class="code-block">
                        <pre>
framework/
├── app/
│   ├── controller/    # Controllers
│   ├── models/        # Database models
│   ├── views/         # View files
│   └── middleware/    # Middleware classes
├── config/            # Configuration files
├── public/            # Public assets
├── routes/            # Route definitions
└── vendor/            # Composer dependencies</pre>
                    </div>
                </div>

                <!-- Creating a New Controller -->
                <div class="guide-section">
                    <h3 class="text-2xl font-bold mb-4">Creating a New Controller</h3>
                    <div class="code-block">
                        <pre>
// app/controller/ExampleController.php
namespace root_dev\Controller;

class ExampleController {
    public function index() {
        // Your code here
    }
}</pre>
                    </div>
                </div>

                <!-- Database Migrations -->
                <div class="guide-section">
                    <h3 class="text-2xl font-bold mb-4">Database Migrations</h3>
                    <div class="code-block">
                        <pre>
// Create a new migration file in app/database/migrations/
// Example: 2024_03_20_create_users_table.php

class CreateUsersTable {
    public function up() {
        $sql = "CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        
        // Execute the SQL
        $db = new Database();
        $db->query($sql);
    }

    public function down() {
        $sql = "DROP TABLE IF EXISTS users";
        $db = new Database();
        $db->query($sql);
    }
}</pre>
                    </div>
                </div>

                <!-- Creating Models -->
                <div class="guide-section">
                    <h3 class="text-2xl font-bold mb-4">Creating Models</h3>
                    <div class="code-block">
                        <pre>
// app/models/User.php
namespace root_dev\Models;

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function find($id) {
        $sql = "SELECT * FROM users WHERE id = ?";
        return $this->db->query($sql, [$id])->fetch();
    }

    public function create($data) {
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        return $this->db->query($sql, [
            $data['username'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT)
        ]);
    }
}</pre>
                    </div>
                </div>

                <!-- Adding Routes -->
                <div class="guide-section">
                    <h3 class="text-2xl font-bold mb-4">Adding Routes</h3>
                    <div class="code-block">
                        <pre>
// routes/web.php
$routes = [
    '/example' => [ExampleController::class, 'index', false],
    '/protected' => [ExampleController::class, 'protected', true, 'user'],
    '/admin' => [ExampleController::class, 'admin', true, 'admin']
];</pre>
                    </div>
                </div>

                <!-- Environment Configuration -->
                <div class="guide-section">
                    <h3 class="text-2xl font-bold mb-4">Environment Configuration</h3>
                    <div class="code-block">
                        <pre>
// .env file
DB_HOST=localhost
DB_NAME=your_database
DB_USER=your_username
DB_PASS=your_password

JWT_SECRET=your_secret_key
JWT_EXPIRATION=3600

APP_URL=http://localhost:8000
APP_ENV=development</pre>
                    </div>
                </div>
            </div>

            <!-- Step by Step Guide -->
            <div class="mt-12">
                <h2 class="text-3xl font-bold mb-6 text-red-600">Step by Step Guide</h2>
                
                <!-- Creating Files -->
                <div class="guide-section">
                    <h3 class="text-2xl font-bold mb-4">Creating New Files</h3>
                    <div class="space-y-4">
                        <div class="step" id="step1">
                            <span class="step-number">1</span>
                            <span class="font-bold">Create Controller</span>
                            <div class="step-content" id="step1-content">
                                <p class="ml-8 mt-2">Create a new file in <code>app/controller/</code> with your controller name (e.g., <code>UserController.php</code>)</p>
                            </div>
                        </div>
                        <div class="step" id="step2">
                            <span class="step-number">2</span>
                            <span class="font-bold">Create Model</span>
                            <div class="step-content" id="step2-content">
                                <p class="ml-8 mt-2">Create a new file in <code>app/models/</code> with your model name (e.g., <code>User.php</code>)</p>
                            </div>
                        </div>
                        <div class="step" id="step3">
                            <span class="step-number">3</span>
                            <span class="font-bold">Create View</span>
                            <div class="step-content" id="step3-content">
                                <p class="ml-8 mt-2">Create a new file in <code>app/views/</code> with your view name (e.g., <code>user.php</code>)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Database Migration Steps -->
                <div class="guide-section">
                    <h3 class="text-2xl font-bold mb-4">Database Migration Steps</h3>
                    <div class="space-y-4">
                        <div class="step" id="step4">
                            <span class="step-number">1</span>
                            <span class="font-bold">Create Migration File</span>
                            <div class="step-content" id="step4-content">
                                <p class="ml-8 mt-2">Create a new file in <code>app/database/migrations/</code> with timestamp (e.g., <code>2024_03_20_create_users_table.php</code>)</p>
                            </div>
                        </div>
                        <div class="step" id="step5">
                            <span class="step-number">2</span>
                            <span class="font-bold">Define Table Structure</span>
                            <div class="step-content" id="step5-content">
                                <p class="ml-8 mt-2">Write your table creation SQL in the <code>up()</code> method</p>
                            </div>
                        </div>
                        <div class="step" id="step6">
                            <span class="step-number">3</span>
                            <span class="font-bold">Define Rollback</span>
                            <div class="step-content" id="step6-content">
                                <p class="ml-8 mt-2">Write your table deletion SQL in the <code>down()</code> method</p>
                            </div>
                        </div>
                        <div class="step" id="step7">
                            <span class="step-number">4</span>
                            <span class="font-bold">Run Migration</span>
                            <div class="step-content" id="step7-content">
                                <p class="ml-8 mt-2">Execute the migration using the framework's migration command</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Welcome message typewriter effect
        const text = "Why settle for the old ways? Start better with PHP and build modern web apps faster, easier, and cleaner — only with Root-Dev.";
        const element = document.getElementById("typewriter");
        let i = 0;

        function type() {
            if (i < text.length) {
                element.innerHTML += text.charAt(i);
                i++;
                setTimeout(type, 45);
            } else {
                // Start showing steps after welcome message is done
                setTimeout(showSteps, 1000);
            }
        }

        // Step by step animation
        function showSteps() {
            const steps = document.querySelectorAll('.step');
            const stepContents = document.querySelectorAll('.step-content');
            let currentStep = 0;

            function showNextStep() {
                if (currentStep < steps.length) {
                    // Show step
                    steps[currentStep].classList.add('visible');
                    
                    // Type out step content
                    const content = stepContents[currentStep];
                    const text = content.querySelector('p').textContent;
                    content.classList.add('visible');
                    content.querySelector('p').textContent = '';
                    
                    let charIndex = 0;
                    function typeContent() {
                        if (charIndex < text.length) {
                            content.querySelector('p').textContent += text.charAt(charIndex);
                            charIndex++;
                            setTimeout(typeContent, 30);
                        } else {
                            currentStep++;
                            setTimeout(showNextStep, 500);
                        }
                    }
                    typeContent();
                }
            }

            showNextStep();
        }

        window.onload = type;

        function goToLogin() {
            window.location.href = '/login';
        }
    </script>
</body>
</html>
