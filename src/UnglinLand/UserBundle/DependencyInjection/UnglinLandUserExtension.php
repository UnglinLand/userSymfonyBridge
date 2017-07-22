<?php
/**
 * This file is part of UserSymfonyBundle
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 7.2
 *
 * @category Bundle
 * @package  UserSymfonyBundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace UnglinLand\UserBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use UnglinLand\UserBundle\DependencyInjection\Configuration;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use UnglinLand\UserBundle\DependencyInjection\ExtensionStrategy\ExtensionStrategyDispatcher;
use UnglinLand\UserBundle\DependencyInjection\ExtensionStrategy\Driver\DoctrineStrategy;
use UnglinLand\UserBundle\DependencyInjection\ExtensionStrategy\Driver\DoctrineMongoDBStrategy;

/**
 * UnglinLand user extension
 *
 * This extension is used to configure the UserSymfonyBridge UnglinLad project bundle
 *
 * @category Bundle
 * @package  UserSymfonyBundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class UnglinLandUserExtension extends Extension implements PrependExtensionInterface
{
    /**
     * Load
     *
     * Loads a specific configuration.
     *
     * @param array            $configs   An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     * @return void
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $bundleConfig = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $loader->load('services.yml');
        $loader->load($bundleConfig['driver'].'_services.yml');
    }

    /**
     * Prepend
     *
     * Allow an extension to prepend the extension configurations.
     *
     * @param ContainerBuilder $container The application container
     *
     * @return void
     */
    public function prepend(ContainerBuilder $container)
    {
        $config = $this->processConfiguration(
            new Configuration(),
            $container->getExtensionConfig($this->getAlias())
        );

        $dispatcher = new ExtensionStrategyDispatcher();
        $dispatcher->attach(new DoctrineStrategy())
            ->attach(new DoctrineMongoDBStrategy())
            ->dispatch(
                [
                    'bundles' => $container->getParameter('kernel.bundles'),
                    'container' => $container,
                    'config' => $config
                ]
            );
    }
}
