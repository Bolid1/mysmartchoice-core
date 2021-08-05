<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Managers\UsersManager;
use App\Validators\UserValidator;
use Illuminate\Console\Command;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function trim;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create
        { --name= : Username }
        { --email= : Email }
        { --password= : Password }
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create user command';
    private UserValidator $validator;
    private UsersManager  $manager;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(UserValidator $validator, UsersManager $manager)
    {
        parent::__construct();
        $this->validator = $validator;
        $this->manager = $manager;
    }

    /**
     * Ask about missed options.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        while (!trim((string)$this->option('name'))) {
            $input->setOption('name', $this->ask('Name?'));
        }

        while (!trim((string)$this->option('email'))) {
            $input->setOption('email', $this->ask('Email?'));
        }

        while (!trim((string)$this->option('password'))) {
            $input->setOption('password', $this->secret('Password?'));
        }
    }

    /**
     * Creates user from options.
     *
     * @throws ValidationException
     */
    public function handle(): void
    {
        $user = $this->manager->register(
            $this->validator->validateForCreate($this->options())
        );

        $this->getOutput()->success("User {$user->id} was successfully created");
        $this->table(
            ['id', 'email'],
            [
                [
                    'id' => $user->id,
                    'email' => $user->email,
                ],
            ]
        );
    }
}
