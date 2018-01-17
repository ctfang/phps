<?php

namespace Command\Host;

use Packers\Host\SystemHost;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class HostDeleteCommand extends Command
{

    protected function configure()
    {
        $this->setName('host:delete')
            ->setDescription('删除host')
            ->setHelp('删除host')
            ->addArgument(
                'domain',
                InputArgument::REQUIRED,
                '域名'
            )->addOption(
                'like',
                null,
                InputOption::VALUE_OPTIONAL,
                '是否模糊匹配',
                false
            );
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputDomain = $input->getArgument('domain');
        $like        = $input->getOption('like');
        $host        = new SystemHost();
        $list        = $host->get();
        $isOk        = 0;
        foreach ($list as $domain => $ip) {
            if ($like === false) {
                if ($inputDomain == $domain) {
                    $isOk = $host->delete($domain);
                }
            } else {
                if (strpos($domain, $inputDomain) !== false) {
                    $isOk = $host->delete($domain);
                }
            }

            if ($isOk) {
                $output->writeln("<info>已删除： {$ip} {$domain}</info>");
            } elseif ($isOk !== 0) {
                $output->writeln("<error>删除失败</error>");
                $output->writeln("<error>==========</error>");
                $output->writeln("<error>必须在管理员用户下运行才可以删除</error>");
                $output->writeln("<error>如果是windows10系统</error>");
                $output->writeln("<error>1，鼠标移到左下角</error>");
                $output->writeln("<error>2，选择右键</error>");
                $output->writeln("<error>3，选择Windows PowerShell (管理员)</error>");
                return false;
            }
        }
    }
}