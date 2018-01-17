<?php

namespace Command\Host;

use Packers\Host\SystemHost;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FromCommand extends Command
{
    protected function configure()
    {
        $this->setName('host:from')
            ->setDescription('导入web配置域名到物理机')
            ->setHelp('导入web配置域名到物理机')
            ->addArgument(
                'webServer',
                InputArgument::REQUIRED,
                '必须输入的参数'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $webServer = $input->getArgument('webServer');
        if( $webServer=='nginx' ){
            $this->fromNginx($input,$output);
        }
    }

    protected function fromNginx(InputInterface $input, OutputInterface $output)
    {
        $host    = \Config::get('host');
        $path    = $host['nginx_config_path'];
        $arrFile = scandir($path);
        $arrFile = array_splice($arrFile, 2);
        $sysHost = new SystemHost();
        foreach ($arrFile as $fileName) {
            $filePath  = $path . '/' . $fileName;
            $file      = file($filePath);
            $arrDomain = [];
            foreach ($file as $str) {
                $str = trim($str);
                $str = preg_replace("/\s(?=\s)/", "\\1", $str);
                $str = str_replace(";", "", $str);
                $arr = explode(' ', $str);
                if ($arr[0] == 'server_name') {
                    unset($arr[0]);
                    foreach ($arr as $domain) {
                        $arrDomain[] = $domain;
                    }
                    break;
                }
            }
            foreach ($arrDomain as $domain) {
                $sysHost->save('127.0.0.1',$domain);
                $output->writeln("<info>127.0.0.1 {$domain}</info>");
            }
        }
    }
}