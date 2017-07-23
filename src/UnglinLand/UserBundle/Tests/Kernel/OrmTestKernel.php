<?php
/**
 * This file is part of UserSymfonyBridge
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 7.2
 *
 * @category Test
 * @package  UserSymfonyBridge
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace UnglinLand\UserBundle\Tests\Kernel;

use UnglinLand\UserBundle\Kernel\AbstractKernel;

/**
 * ORM test kernel
 *
 * This class is used to load the minimum requirements of the UnglinLandUserBundle with orm driver
 *
 * @category UserSymfonyBridge
 * @package  UserSymfonyBridge
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class OrmTestKernel extends AbstractKernel
{
    /**
     * Get configuration file
     *
     * Return the configuration file path of the kernel
     *
     * @return string
     */
    public function getConfigurationFile()
    {
        return __DIR__.'/../KernelConfig/config_orm.yml';
    }

    /**
     * Get cache dir
     *
     * Gets the cache directory.
     *
     * @return string The cache directory
     */
    public function getCacheDir()
    {
        return sys_get_temp_dir().DIRECTORY_SEPARATOR.'UserBundleKernel';
    }

    /**
     * Get log dir
     *
     * Gets the log directory.
     *
     * @return string The log directory
     */
    public function getLogDir()
    {
        return sys_get_temp_dir().DIRECTORY_SEPARATOR.'UserBundleKernel';
    }
}
