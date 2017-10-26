<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2017/10/26
 * Time: 11:09
 */

namespace Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateCommand extends Command
{

    protected function configure()
    {
        $this->setName('command:create')
            ->setDescription('创建命令模板')
            ->setHelp('创建命令模板')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                '命令名称，符合命名空间'
            );
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name    = $input->getArgument('name');
        $saveDir = __DIR__;
        $arrInfo = pathinfo($name);

        $nameSpace = 'namespace Command\\' . str_replace('/', '\\', $arrInfo['dirname']);
        $str       = file_get_contents(__DIR__ . '/../packers/command/DemoCommand.php');

        $str       = str_replace(['namespace Command','DemoCommand'],[$nameSpace,$arrInfo['basename']],$str);
        $saveDir   = strtolower($saveDir.'/'.$arrInfo['dirname']);
        if( !is_dir($saveDir) ){
            mkdir($saveDir,0755,true);
        }

        file_put_contents($saveDir.'/'.$arrInfo['basename'].'.php',$str,LOCK_EX);
    }
}