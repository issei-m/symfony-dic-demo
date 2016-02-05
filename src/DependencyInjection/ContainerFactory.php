<?php

namespace App\DependencyInjection;

use Symfony\Component\Config\ConfigCache;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Dumper\XmlDumper;
use Symfony\Component\DependencyInjection\Loader\ClosureLoader;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Kernel;

/**
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class ContainerFactory
{
    /**
     * @var \Closure[]
     */
    private $loaders;

    /**
     * @var string
     */
    private $cacheDir;

    public function __construct(array $loaders, $cacheDir)
    {
        $this->loaders  = $loaders;
        $this->cacheDir = $cacheDir;
    }

    /**
     * Returns a new created container instance.
     *
     * @param string $environment
     * @param bool   $debug
     *
     * @return ContainerInterface
     */
    public function create($environment, $debug = false)
    {
        $cachedContainerClassName = ucfirst($environment) . ($debug ? 'Debug' : '') . 'Container';
        $cache = new ConfigCache($this->cacheDir . '/' . $cachedContainerClassName . '.php', $debug);

        if (!$cache->isFresh()) {
            $container = new ContainerBuilder(new ParameterBag([
                'environment' => $environment,
                'debug'       => $debug,
            ]));

            $container->addObjectResource($this);

            foreach ($this->loaders as $loader) {
                (new ClosureLoader($container))->load($loader);
            }

            $container->compile();

            $dumper = new PhpDumper($container);
            $content = $dumper->dump(['class' => stristr(basename($cache->getPath()), '.', true)]);

            $cache->write($debug ? $content : self::stripComments($content), $container->getResources());

            if ($debug) {
                self::dumpForDebug(preg_replace('/\.php/', '.xml', $cache->getPath()), $container);
            }
        }

        require_once $cache->getPath();

        return new $cachedContainerClassName();
    }

    private static function stripComments($content)
    {
        if (class_exists(Kernel::class)) {
            $content = Kernel::stripComments($content);
        }

        return $content;
    }

    private static function dumpForDebug($filename, ContainerBuilder $container)
    {
        $dumper = new XmlDumper($container);
        $filesystem = new Filesystem();
        $filesystem->dumpFile($filename, $dumper->dump());
    }
}
