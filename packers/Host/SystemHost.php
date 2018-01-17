<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2017/10/26
 * Time: 16:42
 */

namespace Packers\Host;


class SystemHost
{
    private $save;
    private $host;

    public function __construct()
    {
        $this->save = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? 'C:\Windows\System32\drivers\etc\hosts' : '/etc/hosts';
        $arrHost    = [];
        foreach (file($this->save) as $str) {
            $str = trim($str);
            if (isset($str{0}) && is_numeric($str{0})) {
                $arrTemp                      = explode(' ', $str);
                $arrHost[trim(end($arrTemp))] = trim(reset($arrTemp));
            }
        }
        $this->host = $arrHost;
    }

    private function getHostString()
    {
        return file_get_contents($this->save);
    }

    public function get()
    {
        return $this->host;
    }

    public function save($ip, $domain)
    {
        if (isset($this->host[$domain])) {
            // 更改ip指向
            $arrHost = file($this->save);
            foreach ($arrHost as $key => &$str) {
                $str = trim($str);
                if (isset($str{0}) && is_numeric($str{0}) && strpos($str, ' ' . $domain)) {
                    $arr = explode(' ' . $domain, $str);
                    if (count($arr) == 2 && '' == $arr[1]) {
                        $str = str_replace($this->host[$domain], $ip, $str);
                    }
                }
            }
            $write = @file_put_contents($this->save, implode("\n", $arrHost), LOCK_EX);
        } else {
            // 新增
            $oldString = $this->getHostString();
            $newStr    = $oldString . "\n{$ip} {$domain}";
            $write     = @file_put_contents($this->save, $newStr, LOCK_EX);
        }
        return $write;
    }

    public function delete($domain)
    {
        $write = false;

        if (isset($this->host[$domain])) {
            // 更改ip指向
            $arrHost = file($this->save);
            foreach ($arrHost as $key => $str) {
                $str = trim($str);
                if (isset($str{0}) && is_numeric($str{0}) && strpos($str, ' ' . $domain)) {
                    $arr = explode(' ' . $domain, $str);
                    if (count($arr) == 2 && '' == $arr[1]) {
                        unset($arrHost[$key]);
                    }
                }elseif ( empty($str) ){
                    unset($arrHost[$key]);
                }
            }
            $write = @file_put_contents($this->save, implode("\n", $arrHost), LOCK_EX);
        }
        return $write;
    }
}