<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2017/10/25
 * Time: 17:09
 */

namespace Command\Docker;


use Packers\Docker\Docker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DockerShowCommand extends Command
{
    protected function configure()
    {
        $this->setName('docker:show')
            ->setDescription('显示docker运行情况')
            ->setHelp('显示docker，name、images、ip、port');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $docker = new Docker();
        $list   = $docker->running();
        $images = $docker->images();
        $io     = new SymfonyStyle($input,$output);
        $output->writeln("<info>show all images</info>");
        $io->table(array_keys(end($images)),$images);
        $output->writeln("<info>show all container</info>");
        $io->table(array_keys(end($list)),$list);
    }
}