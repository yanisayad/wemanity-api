<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RunTestsCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('locastic:phpunit')
            ->setDescription('Resets database and runs unit tests')
            ->addArgument('test', InputArgument::OPTIONAL)
            ->addOption(
                'coverage',
                null,
                InputOption::VALUE_REQUIRED,
                'Should coverage be run?',
                false
            );
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
//        get database parameters
        $container = $this->getApplication()->getKernel()->getContainer();
        // $db_name = $container->getParameter('database_name');
        // $db_user = $container->getParameter('database_user');
        // $db_pass = $container->getParameter('database_password');
        $db_name = 'test_wemanity';
        $db_user = 'root';
        $db_pass = '';

        $output->writeln(
            [
                '',
                'Reseting database and importing fixtures',
                '========================================',
                '',
            ]
        );
//       restart database schema
        $command = $this->getApplication()->find('doctrine:schema:drop');
        $arguments = [
            'command' => 'doctrine:schema:drop',
            '--force' => true,
            '--env' => 'test',
        ];

        $command->run(new ArrayInput($arguments), $output);
        $command = $this->getApplication()->find('doctrine:schema:update');
        $arguments = [
            'command' => 'doctrine:schema:update',
            '--force' => true,
            '--env' => 'test',
        ];
        $command->run(new ArrayInput($arguments), $output);
//      create folder for test database
        shell_exec('mkdir -m 777 -p var/db');
        $query = 'mysql -u' . $db_user . ' ' . $db_name . ' < test_wemanity.sql';
        echo ($query);die;
        shell_exec($query);
        // shell_exec(
        //     // 'mysqldump -u '.$db_user.' -p'.$db_pass.' '.$db_name. ' > ../../testing_database.sql --add-drop-table'
        //     'mysql -u ' . $db_user . ' -p' . $db_pass . ' ' . $db_name . ' < ../../wemanity.sql'
        // );

        $output->writeln(
            [
                '',
                'Running phpunit tests',
                '=====================',
                '',
            ]
        );

        shell_exec("php bin/phpunit");
    }
}
