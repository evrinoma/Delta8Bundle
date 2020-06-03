<?php


namespace Evrinoma\Delta8Bundle\DependencyInjection;

use Evrinoma\Delta8Bundle\Menu\Delta8Menu;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Evrinoma\LiveVideoBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
//region SECTION: Getters/Setters
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('delta8');
        $rootNode    = $treeBuilder->getRootNode();
        $rootNode
            ->children()
                ->scalarNode('menu')->defaultValue(Delta8Menu::class)
                ->info('This option is used for plug menu as tag serivce')
            ->end();

        return $treeBuilder;
    }
//endregion Getters/Setters
}