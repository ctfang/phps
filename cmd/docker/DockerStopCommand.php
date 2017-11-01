<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2017/11/1
 * Time: 下午11:14
 */

namespace Command\Docker;


use Packers\Docker\Docker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DockerStopCommand extends Command
{
    public function configure()
    {
        $this->setName('docker:stop')
            ->setDescription('暂停所有容器')
            ->setHelp('暂停所有容器');
    }


    public function execute(InputInterface $input, OutputInterface $output)
    {
        $docker = new Docker();
        $list   = $docker->running();
        $io     = new SymfonyStyle($input, $output);
        if ($list) {
            foreach ($list as $con) {
                $output->write("<info>stop </info>");
                system('docker stop ' . $con['names']);
            }
        }
    }
}