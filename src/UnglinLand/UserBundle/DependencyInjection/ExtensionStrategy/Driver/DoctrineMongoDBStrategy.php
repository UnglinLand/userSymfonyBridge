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
 * Doctrine MongoDB strategy
 *
 * This extension strategy is in charge of the DoctrineMongoDBBundle configuration
 *
 * @category BundleExtension
 * @package  UserSymfonyBridge
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class DoctrineMongoDBStrategy implements ExtensionStrategyInterface
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
        $config = $options['config'];

        $container->prependExtensionConfig(
            'doctrine_mongodb',
            [
                'document_managers' => [
                    $config['driver_configuration']['odm_manager_name'] => [
                        'mappings' => [
                            'UnglinLandUserBundle' => [
                                'prefix' => 'UnglinLand\UserModule\Model',
                                'alias' => 'UnglinLandUserBundle'
                            ]
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
            $options['config']['driver'] == 'odm' &&
            in_array('DoctrineMongoDBBundle', array_keys($options['bundles']))
        );
    }
}
