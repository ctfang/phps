<?php

namespace Command\Host;

use Packers\Host\SystemHost;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HostSetCommand extends Command
{
    protected function configure()
    {
        $this->setName('host:set')
            ->setDescription('新增或编辑host')
            ->setHelp('新增或编辑host')
            ->addArgument(
                'ip',
                InputArgument::REQUIRED,
                'ip'
            )
            ->addArgument(
                'domain',
                InputArgument::REQUIRED,
                '域名'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ip     = $input->getArgument('ip');
        $arrIp  = explode('.',$ip);
        if( count($arrIp)!=4 ){
            $output->writeln("<error>设置失败</error>");
            return false;
        }
        foreach ($arrIp as $num){
            if(!is_numeric($num)){
                $output->writeln("<error>设置失败</error>");
                return false;
            }
        }

        $domain = $input->getArgument('domain');

        $isOk   = (new SystemHost())->save($ip,$domain);
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