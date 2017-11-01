<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2017/10/25
 * Time: 17:34
 */

namespace Packers\Docker;


class Docker
{
    public function running()
    {
        $arrList = [];
        $baseCmd = 'docker inspect [name] | grep \'"IPAddress"\'';

        exec('docker ps -a', $arr);

        foreach ($this->getDockerList($arr) as $arrData) {
            $arr = $ports = [];
            exec(str_replace('[name]', $arrData['names'], $baseCmd), $arr);
            foreach ($arr as $value) {
                if (isset($value{29})) {
                    $temp          = explode(':', trim($value));
                    $ip            = $temp[1];
                    $arrData['ip'] = trim(str_replace(['"', ','], '', $ip));
                }
            }
            $arr = explode(',', $arrData['ports']);
            foreach ($arr as $item) {
                $item    = strstr($item, '/', true);
                $item    = explode(':', $item);
                $ports[] = trim(end($item));
            }
            $arrData['ports'] = implode(',', $ports);
            unset($arrData['command'], $arrData['container id'], $arrData['created']);
            $arrList[] = $arrData;
        }
        return $arrList;
    }

    public function images()
    {
        exec('docker images', $arr);

        return $this->getDockerList($arr);
    }


    public function container()
    {
        exec('docker ps -a', $arr);

        return $this->getDockerList($arr);
    }

    private function decodeTitle($str)
    {
        $arrTitleConfig = [];
        $arr            = explode('  ', $str);
        foreach ($arr as $name) {
            if ($name) {
                $arrTitleConfig[$name] = strpos($str, $name);
            }
        }
        $temp      = array_keys($arrTitleConfig);
        $newConfig = [];
        foreach ($temp as $i => $title) {
            if (isset($temp[$i + 1])) {
                $newConfig[$title] = [
                    'start' => $arrTitleConfig[$temp[$i]],
                    'end'   => $arrTitleConfig[$temp[$i + 1]] - 1,
                ];
            } else {
                $newConfig[$title] = [
                    'start' => $arrTitleConfig[$temp[$i]],
                ];
            }
        }
        return $newConfig;
    }

    private function decodeString($arr, $arrTitleConfig)
    {
        $data = [];
        foreach ($arr as $string) {
            $temp = [];
            foreach ($arrTitleConfig as $title => $config) {
                $temp[strtolower(trim($title))] = trim(substr($string, $config['start'], isset($config['end']) ? $config['end'] - $config['start'] : 100));
            }
            $data[] = $temp;
        }
        return $data;
    }

    private function getDockerList($arr)
    {
        $arrTitleConfig = $this->decodeTitle($arr[0]);
        unset($arr[0]);
        return $this->decodeString($arr, $arrTitleConfig);
    }
}