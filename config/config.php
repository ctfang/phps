<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2017/10/25
 * Time: 17:13
 */
return [
    \Command\Docker\DockerShowCommand::class,
    \Command\Docker\DockerComposeCommand::class,
    \Command\Docker\DockerSaveCommand::class,
    \Command\Docker\DockerClearCommand::class,
    \Command\Docker\DockerDeleteCommand::class,
    \Command\Docker\DockerStopCommand::class,

    \Command\CreateCommand::class,
    \Command\InstallCommand::class,

    \Command\Host\HostListCommand::class,
    \Command\Host\HostDeleteCommand::class,
    \Command\Host\HostSetCommand::class,
    \Command\Web\ApacheBuildCommand::class,
    \Command\Web\ApacheImportCommand::class,
    \Command\web\WebHostCommand::class,
];