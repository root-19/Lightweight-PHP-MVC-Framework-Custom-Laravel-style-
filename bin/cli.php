<?php

$command = $argv[1] ?? null;
$name = $argv[2] ?? null;

if (!$command || !$name) {
    echo "Usage: php cli.php make:[type] [Name]\n";
    exit;
}

$types = ['controller', 'model', 'view', 'migration'];

if (!preg_match('/^make:(controller|model|view|migration)$/', $command, $matches)) {
    echo "Unknown command: $command\n";
    exit;
}

$type = $matches[1];

switch ($type) {
    case 'controller':
        $content = "<?php\n\nclass $name {\n\n    public function index() {\n        // Display a listing of the resource\n        echo \"$name controller index method.\";\n    }\n\n    public function create() {\n        // Show the form for creating a new resource\n        echo \"$name controller create method.\";\n    }\n\n    public function store() {\n        // Store a newly created resource in storage\n        echo \"$name controller store method.\";\n    }\n\n    public function show(\$id) {\n        // Display the specified resource\n        echo \"$name controller show method for ID: \$id\";\n    }\n\n    public function edit(\$id) {\n        // Show the form for editing the specified resource\n        echo \"$name controller edit method for ID: \$id\";\n    }\n\n    public function update(\$id) {\n        // Update the specified resource in storage\n        echo \"$name controller update method for ID: \$id\";\n    }\n\n    public function destroy(\$id) {\n        // Remove the specified resource from storage\n        echo \"$name controller destroy method for ID: \$id\";\n    }\n}\n";
        $path = dirname(__DIR__) . "/app/controller/{$name}.php";
        break;

    case 'model':
        $content = "<?php\n\nclass $name {\n    protected \$table = '" . strtolower($name) . "s';\n    protected \$fillable = [];\n\n    public function __construct() {\n        // Initialize model properties\n    }\n\n    public function all() {\n        // Get all records\n        return [];\n    }\n\n    public function find(\$id) {\n        // Find a record by ID\n        return null;\n    }\n\n    public function create(\$data) {\n        // Create a new record\n        return null;\n    }\n\n    public function update(\$id, \$data) {\n        // Update a record\n        return null;\n    }\n\n    public function delete(\$id) {\n        // Delete a record\n        return null;\n    }\n}\n";
        $path = dirname(__DIR__) . "/app/models/{$name}.php";
        break;

    case 'view':
        $content = "<!-- $name View -->\n<h1>$name View</h1>\n";
        $path = dirname(__DIR__) . "/app/views/{$name}.php";
        break;

    case 'migration':
        $timestamp = date('Y_m_d_His');
        $className = str_replace(' ', '', ucwords(str_replace('_', ' ', $name)));
        $filename = "{$timestamp}_{$name}.php";
        $path = dirname(__DIR__) . "/migrations/{$filename}";
        $content = "<?php\n\nclass {$className} {\n    public function up(\$pdo) {\n        // Create table query here\n    }\n\n    public function down(\$pdo) {\n        // Drop table query here\n    }\n}\n";
        break;
}

if (file_exists($path)) {
    echo "$type '$name' already exists.\n";
    exit;
}

// Create directory if it doesn't exist
$directory = dirname($path);
if (!is_dir($directory)) {
    if (!mkdir($directory, 0777, true)) {
        echo "Error: Could not create directory $directory\n";
        exit;
    }
}

file_put_contents($path, $content);
echo ucfirst($type) . " '$name' created successfully at $path\n";
