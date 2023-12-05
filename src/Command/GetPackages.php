<?php
namespace App\Command;

use App\Service\ApiService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;



#[AsCommand(name: 'app:get-packages')]
class GetPackages extends Command{

    protected $service;

    public function __construct(ApiService $service)
    {
        $this->service=$service;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Getting packages from api')
            ->setHelp('This command allows you to get packages from Packagist api')
            ->addArgument('page_number', InputArgument::REQUIRED,'page number')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->service->fetchApi($input->getArgument('page_number'));

        $output->writeln([
            'Your argument is',
            '============',
            ''.$input->getArgument('page_number'),
        ]);

        return Command::SUCCESS;
    }   
    
}