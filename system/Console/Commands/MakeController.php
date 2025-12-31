<?php

namespace System\Console\Commands;

use System\Console\Command;

class MakeController extends Command
{
    protected string $name = 'make:controller';
    protected string $description = 'Create a new controller class';

    public function execute($args)
    {
        $className = $args[0] ?? null;

        if (!$className) {
            echo "Error: Please provide a controller name.\n";
            return;
        }

        $template = "<?php\nnamespace App\Controllers;\n\nuse System\Controller;\nuse System\Libraries\AssetLoader;\nuse System\Libraries\Flasher;\nuse System\Libraries\Hasher;\n\nclass {$className} extends Controller{\n public function index(){\n// code..\n}\n}\n";

        $path = dirname(__DIR__, 3) . "/app/Controllers/{$className}.php";

        if (file_exists($path)) {
            echo "Controller already exists!\n";
            return;
        }

        file_put_contents($path, $template);
        echo "Controller [{$path}] created successfully.\n";
    }
}