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
use function resource_path;
use function str_replace;
use function trim;

class MakeViewCommand extends GeneratorCommand
{
    protected $name = 'make:enhanced:view';
    protected $description = 'Create a new view for Eloquent model';
    protected $type = 'View';

    protected function getStub(): string
    {
        return __DIR__."/stubs/view.{$this->getTypeInput()}.stub";
    }

    public function handle(): bool
    {
        $name = $this->getNameInput();
        $path = resource_path("js/Pages/{$name}.vue");

        // Next, we will generate the path to the location where this class' file should get
        // written. Then, we will build the class and make the proper replacements on the
        // stub files so that it gets the correctly formatted namespace and class name.
        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($name));

        $this->info($this->type.' created successfully.');

        return true;
    }

    protected function getTypeInput(): string
    {
        return Str::lower(trim($this->option('type') ?: 'index'));
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
            ['type', 't', InputOption::VALUE_OPTIONAL, 'The type of view: index, show or edit. By default: index'],
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
