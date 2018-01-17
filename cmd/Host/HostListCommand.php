<?php

namespace Command\Host;

use Packers\Host\SystemHost;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class HostListCommand extends Command
{

    protected function configure()
    {
        $this->setName('host:list')
            ->setDescription('显示系统已经设置的host')
            ->setHelp('显示系统已经设置的host');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $host = new SystemHost();
        $list = $host->get();
        foreach ($list as $domain=>$ip){
            $hostList[] = ['ip'=>$ip,'domain'=>$domain];
        }
        $io     = new SymfonyStyle($input,$output);
        $io->table(array_keys(end($hostList)),$hostList);
    }
}