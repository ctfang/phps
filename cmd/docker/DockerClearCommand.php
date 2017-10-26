<?php

namespace Command\Docker;

use Packers\Docker\Docker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DockerClearCommand extends Command
{

    protected function configure()
    {
        $this->setName('docker:clear')
            ->setDescription('清理docker')
            ->setHelp('清理docker')
            ->addOption(
                'all',
                null,
                InputOption::VALUE_OPTIONAL,
                'clear all images and container',
                false
            );
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $isAll     = $input->getOption('all');
        $docker    = new Docker();
        $images    = $docker->images();
        if ($isAll === false) {
            $output->writeln("<info>删除标签<none></info>");
            foreach ($images as $image){
                if( $image['tag']=='<none>' ){
                    system('docker rmi '.$image['image id']);
                }
            }
        }else{
            $output->writeln("<comment>确认删除所有images(y/n)</comment>");
            $input = trim(fgets(STDIN));
            if( in_array($input,['y','Y']) ){
                foreach ($images as $image){
                    system('docker rmi '.$image['image id']);
                    $output->writeln("<info>delete {$image['repository']}</info>");
                }
            }
        }
    }
}