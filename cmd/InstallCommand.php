<?php

namespace Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstallCommand extends Command
{

    protected function configure()
    {
        $this->setName('install')
            ->setDescription('安装phps命令到全局')
            ->setHelp('安装phps命令到全局');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $php_os  = strtolower(substr(PHP_OS, 0, 3));

        if ($php_os == 'win') {
            $output->writeln("<info>管理员身份调用bat文件</info>");
            $output->writeln("<info>如果bat执行失败，手动把./bin目录添加系统环境变量path</info>");
            $this->installForWin($output);
            $output->writeln("<info>path生效有延迟，重启或等待或手动设置</info>");
        } else {
            $this->installForLinux();
        }
    }

    private function installForLinux()
    {
        $binPath = realpath(__DIR__.'/../phps');
        $local   = '/usr/local/bin/phps';
        system("ln -s {$binPath} {$local}");
        system("chmod 777 {$local}");
    }

    private function installForWin( OutputInterface $output)
    {
        exec('echo %PATH%',$path);
        $arr  = explode(';',reset($path));
        if( in_array(realpath(__DIR__.'/bin'),$arr) ){
            $output->writeln("<error>bin路径已经在path里</error>");
        }else{
            system('start '.realpath(__DIR__.'/../install.bat'));
        }
    }
}