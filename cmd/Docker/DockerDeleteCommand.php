<?php

namespace Command\Docker;

use Packers\Docker\Docker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DockerDeleteCommand extends Command
{

    protected function configure()
    {
        $this->setName('docker:delete')
            ->setDescription('删除单个image')
            ->setHelp('删除单个image');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $docker = new Docker();
        $images = $docker->images();
        $id     = 1;
        $list   = [];
        foreach ($images as $image){
            $list[$id] = ['id'=>$id]+$image;
            $id++;
        }
        $io     = new SymfonyStyle($input,$output);
        $io->table(array_keys(end($list)),$list);
        $output->write("<info>输入id进行删除：</info>");
        $inputId = trim(fgets(STDIN));
        if( $inputId && isset($list[$inputId]) ){
            $show = [$list[$inputId]];
            system('docker rmi '.$list[$inputId]['image id']);
            $output->writeln("<info>已经执行删除以下image</info>");
            $io->table(array_keys(end($show)),$show);
        }else{
            $output->writeln("<info>没有删除任何东西</info>");
        }
    }
}