<?php

namespace Command\Web;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ApacheConfigCommand extends Command
{

    protected function configure()
    {
        $this->setName('apache:build')
            ->setDescription('备注标题')
            ->setHelp('命令细节');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {

    }
}