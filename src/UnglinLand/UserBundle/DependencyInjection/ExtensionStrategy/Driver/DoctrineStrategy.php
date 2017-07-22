<?php
/**
 * This file is part of UserSymfonyBridge
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 7.1
 *
 * @category BundleExtension
 * @package  UserSymfonyBridge
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace UnglinLand\UserBundle\DependencyInjection\ExtensionStrategy\Driver;

use UnglinLand\UserBundle\DependencyInjection\ExtensionStrategy\ExtensionStrategyInterface;

/**
 * Doctrine strategy
 *
 * This extension strategy is in charge of the DoctrineBundle configuration
 *
 * @category BundleExtension
 * @package  UserSymfonyBridge
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class DoctrineStrategy implements ExtensionStrategyInterface
{
    /**
     * Process
     *
     * This method process the given strategy options
     *
     * @param array $options The strategy options
     *
     * @return void
     */
    public function process(array $options) : void
    {
        $container = $options['container'];

        $container->prependExtensionConfig(
            'doctrine',
            [
                'orm' => [
                    'mappings' => [
                        'UnglinLandUserBundle' => [
                            'prefix' => 'UnglinLand\UserModule\Model',
                            'alias' => 'UnglinLandUserBundle'
                        ]
                    ]
                ]
            ]
        );

        return;
    }

    /**
     * Support
     *
     * This method indicate if the strategy support the given options
     *
     * @param array $options The strategy options
     *
     * @return bool
     */
    public function support(array $options) : bool
    {
        return (
            array_key_exists('config', $options) &&
            array_key_exists('bundles', $options) &&
            array_key_exists('container', $options) &&
            array_key_exists('driver', $options['config']) &&
            $options['config']['driver'] == 'orm' &&
            in_array('DoctrineBundle', array_keys($options['bundles']))
        );
    }
}
