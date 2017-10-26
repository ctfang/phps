<?php

namespace Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DemoCommand extends Command
{

    protected function configure()
    {
        $this->setName('test')
            ->setDescription('备注标题')
            ->setHelp('命令细节')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                '必须输入的参数'
            );
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {

    }
}