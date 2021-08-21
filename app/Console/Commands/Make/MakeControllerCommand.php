<?php

declare(strict_types=1);

namespace App\Console\Commands\Make;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;
use function array_keys;
use function array_values;
use function base_path;
use function class_basename;
use function lcfirst;
use function str_replace;
use function trim;
use const PHP_EOL;

class MakeControllerCommand extends GeneratorCommand
{
    protected $name = 'make:enhanced:controller';
    protected $description = 'Create a new controller class';
    protected $type = 'Controller';

    public function handle(): bool
    {
        if (false === parent::handle() && !$this->option('force')) {
            return false;
        }

        if ($this->option('tests')) {
            $this->createTest();
        }

        if ($this->option('write')) {
            $this->appendRouteResource();
        }

        return true;
    }

    protected function createTest(): void
    {
        $this->call('make:enhanced:test-controller', [
            'name' => class_basename($this->getNameInput()).'Test',
            '--model' => $this->qualifyClass($this->option('model')),
            '--type' => $this->getTypeInput(),
        ]);
    }

    protected function appendRouteResource(): void
    {
        $this->files->append(
            base_path("routes/{$this->getTypeInput()}.php"),
            PHP_EOL.trim($this->buildRouteResource()).PHP_EOL,
        );
    }

    protected function getStub(): string
    {
        $baseDir = __DIR__.'/stubs/';

        return 'api' === $this->getTypeInput()
            ? $baseDir.'controller.api.stub'
            : $baseDir.'controller.web.stub';
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\\Http\\Controllers\\'.Str::studly($this->getTypeInput());
    }

    protected function getTypeInput(): string
    {
        return Str::lower(trim($this->option('type') ?: 'web'));
    }

    protected function getModelInput(): string
    {
        return Str::lower(trim($this->option('model')));
    }

    protected function getOptions(): array
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the controller already exists'],
            ['model', 'm', InputOption::VALUE_REQUIRED, 'The name of the model'],
            ['type', 't', InputOption::VALUE_OPTIONAL, 'The type of controller: web or api. By default: web'],
            ['tests', null, InputOption::VALUE_NONE, 'Create a new test for the model'],
            ['write', 'w', InputOption::VALUE_NONE, 'Append resource route to the web.php or api.php in routes directory'],
        ];
    }

    protected function buildClass($name): string
    {
        $replacements = $this->buildReplacements();

        return str_replace(array_keys($replacements), array_values($replacements), parent::buildClass($name));
    }

    protected function buildReplacements(): array
    {
        $modelClass = $this->qualifyModel($this->option('model'));

        return [
            '{{ FQN }}' => $this->qualifyClass($this->getNameInput()),
            '{{ namespacedModel }}' => $modelClass,
            '{{ model }}' => class_basename($modelClass),
            '{{ modelSnake }}' => Str::snake(class_basename($modelClass)),
            '{{ modelVariable }}' => lcfirst(class_basename($modelClass)),
            '{{ models }}' => Str::plural(class_basename($modelClass)),
            '{{ modelsSnake }}' => Str::plural(Str::snake(class_basename($modelClass))),
            '{{ modelsVariable }}' => Str::plural(lcfirst(class_basename($modelClass))),
        ];
    }

    protected function buildRouteResource(): string
    {
        $replacements = $this->buildReplacements();

        return str_replace(
            array_keys($replacements),
            array_values($replacements),
            $this->files->get(__DIR__."/stubs/routes.{$this->getTypeInput()}.stub")
        );
    }
}
