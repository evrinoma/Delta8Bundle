<?php


namespace Evrinoma\Delta8Bundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class EvrinomaDelta8BundleExtension
 *
 * @package Evrinoma\Delta8Bundle\DependencyInjection
 */
class EvrinomaDelta8BundleExtension extends Extension
{
//    /**
//     * @var array
//     */
//    private static $doctrineDrivers = [
//        'orm' => [
//            'registry' => 'doctrine',
//            'tag' => 'doctrine.event_subscriber',
//        ]
//    ];

//region SECTION: Public
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $configuration = $this->getConfiguration($configs, $container);
        $config        = $this->processConfiguration($configuration, $configs);

//        $container->setAlias('delta8.doctrine_registry', new Alias(self::$doctrineDrivers['orm']['registry'], false));
//        $definition = $container->getDefinition('evrinoma.delta8.object_manager');
//        $definition->setFactory([new Reference('delta8.doctrine_registry'), 'getManager']);

        $menu = $config['menu'];

        $definition = new Definition($menu);
        $definition->addTag('evrinoma.menu');
        $alias = new Alias('evrinoma.delta8.menu');

        $container->addDefinitions(['evrinoma.delta8.menu' => $definition]);
        $container->addAliases([$menu => $alias]);

    }
//endregion Public

//region SECTION: Getters/Setters
    public function getAlias()
    {
        return 'delta8';
    }
//endregion Getters/Setters
}