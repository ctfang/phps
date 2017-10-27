<?php

namespace Command\Web;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ApacheBuildCommand extends Command
{

    protected function configure()
    {
        $this->setName('apache:build')
            ->setDescription('生产apache配置文件')
            ->setHelp('生产apache配置文件');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $webConfig    = \Config::get('web');
        $sitesPath    = $webConfig['sites-path'];
        $sitesEnabled = $webConfig['sites-enabled'];
        $example      = file_get_contents($webConfig['vhost']);
        foreach ($sitesEnabled as $config){
            $strConfig = str_replace(['[port]','[domain]','[document]'],[$config['port'],implode(' ',$config['domain']),$config['document']],$example);
            file_put_contents($sitesPath.'/'.reset($config['domain']).'.conf',$strConfig,LOCK_EX);
        }
    }
}