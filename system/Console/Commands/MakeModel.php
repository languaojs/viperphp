<?php

namespace System\Console\Commands;

use System\Console\Command;

class MakeModel extends Command
{
    protected string $name = 'make:model';
    protected string $description = 'Create a new model class';

    public function execute($args)
    {
        $className = $args[0] ?? null;
        $privar = '$con';
        $deictic = '$this';

        if (!$className) {
            echo "Error: Please provide a model name.\n";
            return;
        }

        $template = "<?php\nnamespace App\Models;\n\nuse System\Database;\n\nclass {$className}{\nprivate {$privar};\npublic function __construct(){\n{$deictic}->con = new Database();\n}\n}\n";

        $path = dirname(__DIR__, 3) . "/app/Models/{$className}.php";

        if (file_exists($path)) {
            echo "Model already exists!\n";
            return;
        }

        file_put_contents($path, $template);
        echo "Model [{$path}] created successfully.\n";
    }
}