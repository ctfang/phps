<?php

namespace Command\web;

use Packers\Host\SystemHost;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class WebHostCommand extends Command
{

    protected function configure()
    {
        $this->setName('web:host')
            ->setDescription('从web配置的域名设置到系统')
            ->setHelp('从web配置的域名设置到系统')
            ->addOption(
                'ip',
                null,
                InputOption::VALUE_OPTIONAL,
                '所有域名指向的ip',
                '127.0.0.1'
            );
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ip           = $input->getOption('ip');
        $webConfig    = \Config::get('web');
        $sitesEnabled = $webConfig['sites-enabled'];
        $host         = new SystemHost();
        foreach ($sitesEnabled as $config){
            foreach ($config['domain'] as $domain){
                $isOk = $host->save($ip,$domain);
                if($isOk){
                    $output->writeln("<info>设置成功</info>");
                }else{
                    $output->writeln("<error>设置失败</error>");
                    $output->writeln("<error>==========</error>");
                    $output->writeln("<error>必须在管理员用户下运行才可以设置</error>");
                    $output->writeln("<error>如果是windows10系统</error>");
                    $output->writeln("<error>1，鼠标移到左下角</error>");
                    $output->writeln("<error>2，选择右键</error>");
                    $output->writeln("<error>3，选择Windows PowerShell (管理员)</error>");
                }
            }
        }
    }
}