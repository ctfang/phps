<?php

namespace Command\Web;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ApacheImportCommand extends Command
{

    protected function configure()
    {
        $this->setName('apache:import')
            ->setDescription('导入到现有配置')
            ->setHelp('导入到现有配置');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $list      = $sitesEnabled = [];
        $webConfig = \Config::get('web');
        $sitesPath = $webConfig['sites-path'];
        foreach (scandir($sitesPath) as $file) {
            $arrTemp = explode('.conf', $file);
            if (count($arrTemp) == 2 && $arrTemp[1] == '') {
                $list[] = $sitesPath . '/' . $file;
            }
        }
        foreach ($list as $file) {
            $config  = [];
            $arrTemp = file($file);
            foreach ($arrTemp as $string) {
                $string = trim($string);
                if (strpos($string, '<VirtualHost ') === 0) {
                    $string         = @end(explode(':', $string));
                    $config['port'] = strstr($string, '>', true);
                } elseif (strpos($string, 'ServerAlias ') === 0) {
                    $string = @end(explode('ServerAlias', $string));
                    $arr    = explode(' ', $string);
                    foreach ($arr as $domain) {
                        if ($domain) {
                            $config['domain'][] = trim($domain);
                        }
                    }
                } elseif (strpos($string, 'DocumentRoot ') === 0) {
                    $config['document'] = str_replace('"','',trim(@end(explode('DocumentRoot', $string))));
                }
            }
            $sitesEnabled [] = $config;
        }
        $webConfig['sites-enabled'] = $sitesEnabled;
        $string  = var_export($webConfig,true);
        file_put_contents(__DIR__.'/../../config/web.php',"<?php\nreturn {$string};\n",LOCK_EX);
    }
}