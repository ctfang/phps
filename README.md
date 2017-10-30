# phps
使用php扩展系统命令

在使用windows系统时候，总是觉得命令不够方便，可以使用php cli模式对系统命令进行扩展，做一些自定义操作

例如：在源码安装redis和mysql时候,启动服务总需要进入对应的目录，再去点击bat文件才能运行服务

例如：使用docker获取vagrant这些开发环境时，也是需要cd 进入目录，再去vagrant up或者docker-compose start
，这些操作可以放在一个命令就方便很多


## 安装

我使用git bash 工具执行命令，代码放到d盘
````php
cd d:
git clone https://github.com/selden1992/phps
````

在管理员下执行命令安装
````php
php phps install
````

手动安装，把路径
````php
D:\phps\bin\
````
添加到系统的环境变量Path获取用户的Path当中，没有就新建


# 使用 
 
配好环境变量就可使用以下命令
````php
phps list
````
如果不喜欢phps作为根命令，需要改成其他单词，如：moon
````php
cd D:\phps\bin\
mv phps moon
mv phps.bat moon.bat
````
安装包已经内置一些常用命令

````php

// 查看系统host的设置
phps host:list

// 查看docker运行细节，名称，ip等
phps docker:show

// 导入已有的apache配置
phps apache:inport

// 从web文件生成系统host
phps web:host --ip=127.0.0.1

// 其他命令查看帮助命令
……
````
内置命
````$xslt
Available commands:
  docker-compose  进入配置的目录，充当docker-compose命令
  help            Displays help for a command
  install         安装phps命令到全局
  list            Lists commands
 apache
  apache:build    生产apache配置文件
  apache:import   导入到现有配置
 command
  command:create  创建命令模板
 docker
  docker:clear    批量清理docker
  docker:delete   删除单个image
  docker:save     导出docker image到本地文件
  docker:show     显示docker运行情况
 host
  host:delete     删除host
  host:list       显示系统已经设置的host
  host:set        新增或编辑host
 web
  web:host        从web配置的域名设置到系统

````



如果不需要的命令可以在配置文件去掉，对应文件也可删除，命令文件在cmd目录
````php
D:\phps\config\config.app
````

#### 