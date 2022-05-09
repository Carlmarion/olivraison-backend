<?php

namespace App\Command;

use App\Service\Allocation;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


#[AsCommand(
    name: 'app:allocate',
    description: 'allocates deliveries to commands.',
    hidden: false,
    aliases: ['app:allocate-commands']
)]
class AllocateCommand extends Command
{
    private $allocation;

    public function __construct(Allocation $allocation)
    {
        $this->allocation = $allocation;

        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        

        $this->allocation->allocate();

        $output->writeln('allocation done!');

        return Command::SUCCESS;
    }
}





?>