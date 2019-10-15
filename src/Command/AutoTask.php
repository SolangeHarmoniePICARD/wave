<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AutoTask extends Command
{
  protected static $defaultName = 'app:AutoTask';

    // protected function configure()
    // {
    //     $this
    //         ->setDescription('delete files with a timeout')
    //         ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
    //         ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
    //     ;
    // }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $timeNow = time();
    $tabFiles = array_slice(scandir('public/zip'), 2);

    foreach($tabFiles as $file){
      if(($timeNow - filectime(getcwd().'\\public\\zip\\'.$file)) >= 172800){
        unlink(getcwd().'\\public\\zip\\'.$file);
      }
    }
  }
}
