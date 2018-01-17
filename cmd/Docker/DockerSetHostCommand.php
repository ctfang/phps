<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2017/12/28
 * Time: 16:44
 */

namespace Command\Docker;


use Packers\Docker\Docker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DockerSetHostCommand extends Command
{
    protected function configure()
    {
        $this->setName('docker:setHost')
            ->setDescription('设置所有容器的域名')
            ->setHelp('设置所有容器的域名');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $docker = new Docker();
        $list   = $docker->running();
        dump($list);
    }
}