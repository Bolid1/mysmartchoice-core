<?php

declare(strict_types=1);

namespace App\Console\Commands\Make;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;
use function array_keys;
use function array_values;
use function class_basename;
use function lcfirst;
use function str_replace;
use function trim;

class MakeResourceCommand extends GeneratorCommand
{
    protected $name = 'make:enhanced:resource';
    protected $description = 'Create a new resource class';
    protected $type = 'Resource';

    protected function getStub(): string
    {
        return __DIR__.'/stubs/resource.stub';
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\Http\Resources';
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
