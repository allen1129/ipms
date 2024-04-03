<?php
// src/Command/CreateUserCommand.php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateUserCommand extends Command
{
    protected static $defaultName = 'app:create-user';

    private $entityManager;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a new user.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $this->askForEmail($input, $output);
        $password = $this->askForPassword($input, $output);

        $user = new User();
        $user->setEmail($email);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
        $user->setRoles(['ROLE_USER']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln('User created successfully.');

        return Command::SUCCESS;
    }

    private function askForEmail(InputInterface $input, OutputInterface $output): string
    {
        $helper = $this->getHelper('question');
        $question = $helper->question('Enter user email:');
        return $helper->ask($input, $output, $question);
    }

    private function askForPassword(InputInterface $input, OutputInterface $output): string
    {
        $helper = $this->getHelper('question');
        $question = $helper->question('Enter user password:');
        $question->setHidden(true);
        $question->setHiddenFallback(false);
        return $helper->ask($input, $output, $question);
    }
}

?>