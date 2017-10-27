<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2017/10/25
 * Time: 19:57
 */

namespace Command\Docker;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DockerCommand extends Command
{
    protected function configure()
    {
        $this->setName('docker')
            ->setDescription('进入配置的目录，充当docker-compose命令')
            ->setHelp('docker-compose命令的别名')
            ->addArgument(
                'options',
                InputArgument::REQUIRED,
                'start,stop,restart'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $options = $input->getArgument('options');
        $config  = \Config::get('docker');
        $dir     = $config['dir'];
        chdir($dir);
        system('docker-compose ' . $options);
    }
}