<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2017/10/25
 * Time: 20:18
 */

namespace Command\Docker;


use Packers\Docker\Docker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DockerSaveCommand extends Command
{
    protected function configure()
    {
        $this->setName('docker:save')
            ->addArgument(
                'image',
                InputArgument::OPTIONAL,
                'images名称'
            )
            ->addArgument(
                'save',
                InputArgument::OPTIONAL,
                '保存名称'
            )->addOption(
                'all',
                null,
                InputOption::VALUE_OPTIONAL,
                '是否保存全部',
                false
            )->setDescription('导出docker image到本地文件');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $isAll    = $input->getOption('all');
        $image    = $input->getArgument('image');
        $save     = $input->getArgument('save');
        $config   = \Config::get('docker');
        $savePath = $config['save_dir'];
        $time     = time();
        if ($isAll !== false) {
            // 保存所有
            $images = (new Docker())->images();
            foreach ($images as $arrImagesInfo){
                $name = str_replace("/",'_',$arrImagesInfo['repository']);
                system("docker save -o {$savePath}/{$name}_{$time}.tar {$arrImagesInfo['repository']}:{$arrImagesInfo['tag']} ");
            }
            $output->writeln("<info>save to {$savePath}</info>");
        }else{
            if (!$image) {
                $output->writeln("<error>必须指定image</error>");
                return false;
            }
            if (!$save) {
                $save = $savePath.'/'.str_replace("/",'_',$image) . '_' . $time.'.tar';
            }
            system("docker save -o {$save} {$image}");
            $output->writeln("<info>save to {$save}</info>");
        }
    }
}