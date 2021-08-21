<?php

declare(strict_types=1);

namespace App\Console\Commands\Make;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use RuntimeException;
use Symfony\Component\Console\Input\InputOption;
use function app_path;
use function class_basename;
use function is_dir;

class MakeModelCommand extends GeneratorCommand
{
    protected $name = 'make:enhanced:model';
    protected $description = 'Create a new Eloquent model class';
    protected $type = 'Model';

    public function handle(): bool
    {
        if (false === parent::handle() && !$this->option('force')) {
            return false;
        }

        if ($this->option('all')) {
            $this->input->setOption('factory', true);
            $this->input->setOption('seeder', true);
            $this->input->setOption('migration', true);
            $this->input->setOption('controllers', true);
            $this->input->setOption('resource', true);
            $this->input->setOption('policy', true);
            $this->input->setOption('requests', true);
            $this->input->setOption('views', true);
        }

        if ($this->option('factory')) {
            $this->createFactory();
        }

        if ($this->option('seeder')) {
            $this->createSeeder();
        }

        if ($this->option('migration')) {
            $this->createMigration();
        }

        if ($this->option('controllers')) {
            $this->createController('web');
            $this->createController('api');
        }

        if ($this->option('resource')) {
            $this->createResource();
        }

        if ($this->option('policy')) {
            $this->createPolicy();
        }

        if ($this->option('requests')) {
            $this->createRequest('store');
            $this->createRequest('update');
        }

        if ($this->option('views')) {
            $this->createView('index');
            $this->createView('edit');
            $this->createView('show');
        }

        return true;
    }

    protected function createFactory(): void
    {
        $factory = Str::studly($this->argument('name'));

        $this->call('make:factory', [
            'name' => "{$factory}Factory",
            '--model' => $this->qualifyClass($this->getNameInput()),
        ]);
    }

    protected function createSeeder(): void
    {
        $seeder = Str::studly(class_basename($this->argument('name')));

        $this->call('make:seeder', [
            'name' => "{$seeder}Seeder",
        ]);
    }

    protected function createMigration(): void
    {
        $table = Str::snake(Str::pluralStudly(class_basename($this->getNameInput())));

        if ($this->option('pivot')) {
            $table = Str::singular($table);
        }

        $this->call('make:migration', [
            'name' => "create_{$table}_table",
            '--create' => $table,
        ]);
    }

    protected function createController(string $type): void
    {
        $this->call('make:enhanced:controller', [
            'name' => Str::pluralStudly(class_basename($this->getNameInput())).'Controller',
            '--model' => $this->qualifyClass($this->getNameInput()),
            '--type' => $type,
            '--tests' => true,
            '--write' => true,
        ]);
    }

    protected function createResource(): void
    {
        $model = Str::studly(class_basename($this->getNameInput()));

        $this->call('make:enhanced:resource', [
            'name' => "{$model}Resource",
            '--model' => $this->qualifyClass($this->getNameInput()),
        ]);
    }

    protected function createPolicy(): void
    {
        $model = Str::studly(class_basename($this->getNameInput()));

        $this->call('make:policy', [
            'name' => "{$model}Policy",
            '--model' => $this->qualifyClass($this->getNameInput()),
        ]);
    }

    protected function createRequest(string $type): void
    {
        $type = Str::studly($type);
        $model = Str::studly(class_basename($this->getNameInput()));

        $this->call('make:request', [
            'name' => "{$type}{$model}Request",
        ]);
    }

    protected function createView(string $type): void
    {
        $namesMap = [
            'index' => Str::pluralStudly(class_basename($this->getNameInput())),
            'edit' => Str::studly(class_basename($this->getNameInput())).'Edit',
            'show' => Str::studly(class_basename($this->getNameInput())),
        ];

        if (!isset($namesMap[$type])) {
            throw new RuntimeException("Invalid view type \"{$type}\"");
        }

        $this->call('make:enhanced:view', [
            'name' => $namesMap[$type],
            '--model' => $this->qualifyClass($this->getNameInput()),
            '--type' => $type,
        ]);
    }

    protected function getStub(): string
    {
        $baseDir = __DIR__.'/stubs/';

        return $this->option('pivot')
            ? $baseDir.'model.pivot.stub'
            : $baseDir.'model.stub';
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return is_dir(app_path('Models')) ? $rootNamespace.'\\Models' : $rootNamespace;
    }

    protected function getOptions(): array
    {
        return [
            ['all', 'a', InputOption::VALUE_NONE, 'Generate a migration, seeder, factory, and resource controller for the model'],
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the model already exists'],
            ['pivot', 'p', InputOption::VALUE_NONE, 'Indicates if the generated model should be a custom intermediate table model'],
            ['factory', 'f', InputOption::VALUE_NONE, 'Create a new factory for the model'],
            ['seeder', 's', InputOption::VALUE_NONE, 'Create a new seeder for the model'],
            ['migration', 'm', InputOption::VALUE_NONE, 'Create a new migration for the model'],
            ['controllers', 'c', InputOption::VALUE_NONE, 'Create two web & api controllers for the model'],
            ['resource', 'r', InputOption::VALUE_NONE, 'Create a new resource for the model'],
            ['policy', null, InputOption::VALUE_NONE, 'Create a new policy for the model'],
            ['requests', null, InputOption::VALUE_NONE, 'Create two store & update requests for the model '],
            ['views', null, InputOption::VALUE_NONE, 'Create a new views for the model'],
        ];
    }
}
