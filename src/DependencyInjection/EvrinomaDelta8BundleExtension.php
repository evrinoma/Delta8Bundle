<?php


namespace Evrinoma\Delta8Bundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

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

//        $container->setAlias('delta8.doctrine_registry', new Alias(self::$doctrineDrivers['orm']['registry'], false));
//        $definition = $container->getDefinition('evrinoma.delta8.object_manager');
//        $definition->setFactory([new Reference('delta8.doctrine_registry'), 'getManager']);

    }
//endregion Public

//region SECTION: Getters/Setters
    public function getAlias()
    {
        return 'delta8';
    }
//endregion Getters/Setters
}