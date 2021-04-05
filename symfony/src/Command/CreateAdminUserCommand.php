<?php

namespace App\Command;

use App\Service\DTO\CreateUserWithPasswordDTO;
use App\Service\Handler\CreateUserHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateAdminUserCommand extends Command
{
    protected static $defaultName = 'app:user:create';
    protected static $defaultDescription = 'Crear un usuario tipo admin';

    /**
     * @var CreateUserHandler
     */
    private CreateUserHandler $createUserHandler;

    /**
     * CreateAdminUserCommand constructor.
     * @param CreateUserHandler $createUserHandler
     */
    public function __construct(CreateUserHandler $createUserHandler)
    {
        $this->createUserHandler = $createUserHandler;
        parent::__construct();
    }


    protected function configure()
    {
        $this
            ->setDescription('Creates a new user.')
            ->addArgument('username', InputArgument::REQUIRED, 'Username of the user to create.')
            ->addArgument('email', InputArgument::REQUIRED, 'Email of the user to create.')
            ->addArgument('password', InputArgument::REQUIRED, 'Plain password of the user to create.')
            ->addArgument('role', InputArgument::REQUIRED, 'Role for the user (ROLE_ADMIN, ROLE_USER)')
        ;
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $io = new SymfonyStyle($input, $output);
        $username = $input->getArgument('username');
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        $role = $input->getArgument('role');

        $output->writeln([
            'Create user',
            '===========',
            '',
        ]);

        $createUserDTO = new CreateUserWithPasswordDTO($username,$email,$password,$role);
        $this->createUserHandler->handle($createUserDTO);

        $output->writeln('<info>Done!</info>');

        return Command::SUCCESS;
    }
}
