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
        $output->writeln("<info>images</info>");
        if ($list) {
            foreach ($list as $con) {
                system('docker stop ' . $con['names']);
                $output->writeln("<info>stop {$con['names']}</info>");
            }
        }
    }
}