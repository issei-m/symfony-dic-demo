<?php

use App\DependencyInjection\ContainerFactory;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

require __DIR__ . '/vendor/autoload.php';

$environment = $_SERVER['argv'][1];

$containerFactory = new ContainerFactory(
    [
        function (ContainerBuilder $container) use ($environment) {
            $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/config'));
            $loader->load('container_' . $environment . '.yml');
        }
    ],
    __DIR__ . '/cache'
);

$container = $containerFactory->create($environment, $environment !== 'prod');
$container->get('application')->run();
