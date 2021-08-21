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

class MakeTestControllerCommand extends GeneratorCommand
{
    protected $name = 'make:enhanced:test-controller';
    protected $description = 'Create a new controller test class';
    protected $type = 'Test';

    protected function getStub(): string
    {
        $baseDir = __DIR__.'/stubs/';

        return 'api' === $this->getTypeInput()
            ? $baseDir.'controller.api.test.stub'
            : $baseDir.'controller.web.test.stub';
    }

    protected function getPath($name): string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return base_path('tests'.str_replace('\\', '/', $name).'.php');
    }

    protected function rootNamespace(): string
    {
        return 'Tests';
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return "{$rootNamespace}\\".Str::studly($this->getTypeInput());
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
}
