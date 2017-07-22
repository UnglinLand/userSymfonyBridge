<?php
/**
 * This file is part of UserSymfonyBridge
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 7.2
 *
 * @category Bundle
 * @package  UserSymfonyBridge
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace UnglinLand\UserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * Configuration
 *
 * This class is used as bundle configurator for the userSymfonyBridge project
 *
 * @category Bundle
 * @package  UserSymfonyBridge
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Get configuration tree builder
     *
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $root = $treeBuilder->root('unglin_land_user');

        $root->children()
            ->enumNode('driver')
            ->defaultValue('orm')
            ->cannotBeEmpty()
            ->isRequired()
            ->values(['orm', 'odm'])
            ->end()
            ->append($this->getDriverConfiguration())
            ->end();

        return $treeBuilder;
    }

    /**
     * Get driverConfiguration
     *
     * This method return the driver configuration tree builder
     *
     * @return ArrayNodeDefinition
     */
    protected function getDriverConfiguration()
    {
        $treeBuilder = new TreeBuilder();
        $root = $treeBuilder->root('driver_configuration');

        $root->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('role_repository')
            ->cannotBeEmpty()
            ->isRequired()
            ->end()
            ->scalarNode('odm_manager_name')
            ->defaultValue('default')
            ->end()
            ->end()
            ->end();

        return $root;
    }
}
