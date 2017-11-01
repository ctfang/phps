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
            ->setDescription('批量清理docker')
            ->setHelp('批量清理docker')
            ->addOption(
                'all',
                null,
                InputOption::VALUE_OPTIONAL,
                'clear all images and container',
                false
            )
            ->addOption(
                'container',
                null,
                InputOption::VALUE_OPTIONAL,
                'clear all images and container',
                false
            );
    }


    /**
     * 执行
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @author   明月有色 <2206582181@qq.com>
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $isAll     = $input->getOption('all');
        $docker    = new Docker();
        $images    = $docker->images();
        $container = $docker->container();

        foreach ($images as $image) {
            if ($image['tag'] != '<none>') {
                if ($image['tag'] != 'latest') {
                    $ims[$image['repository'] . ':latest'] = $image['repository'] . ':' . $image['tag'];
                } else {
                    $ims[$image['repository']] = $image['repository'];
                }
            }
        }

        if ($input->getOption('container') !== false) {
            // 删除所有容器
            foreach ($container as $con) {
                system('docker rm ' . $con['names']);
                $output->writeln("<info>delete {$con['names']}</info>");
            }
        } else if ($isAll === false) {
            // 指删除错误的
            $output->writeln("<info>删除container,没有关联的image的</info>");
            foreach ($container as $con) {
                if (!isset($ims[$con['image']])) {
                    system('docker rm ' . $con['names']);
                }
            }

            $output->writeln("<info>删除标签<none></info>");
            foreach ($images as $image) {
                if ($image['tag'] == '<none>') {
                    system('docker rmi ' . $image['image id']);
                }
            }
        } else {
            $output->write("<comment>确认删除container(y/n)</comment>");
            $input = trim(fgets(STDIN));
            if (in_array($input, ['y', 'Y'])) {
                foreach ($container as $con) {
                    system('docker rm ' . $con['names']);
                    $output->writeln("<info>delete {$con['names']}</info>");
                }
            }

            $output->write("<comment>确认删除所有images(y/n)</comment>");
            $input = trim(fgets(STDIN));
            if (in_array($input, ['y', 'Y'])) {
                foreach ($images as $image) {
                    system('docker rmi ' . $image['image id']);
                    $output->writeln("<info>delete {$image['repository']}</info>");
                }
            }
        }
    }
}