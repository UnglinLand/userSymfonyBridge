<?php
/**
 * This file is part of UserSymfonyBridge
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 7.2
 *
 * @category UserSymfonyBridge
 * @package  UserSymfonyBridge
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace UnglinLand\UserBundle\Kernel;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;
use UnglinLand\UserBundle\UnglinLandUserBundle;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Yaml\Yaml;

/**
 * UserBundleKernel
 *
 * This class is used to load the minimum requirements of the UnglinLandUserBundle
 *
 * @category UserSymfonyBridge
 * @package  UserSymfonyBridge
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class UserBundleKernel extends Kernel
{
    /**
     * Configuration file
     *
     * This property store the configuration file path
     *
     * @var string
     */
    private $configurationFile;

    /**
     * Register container configuration
     *
     * Loads the container configuration.
     *
     * @param LoaderInterface $loader A LoaderInterface instance
     *
     * @return void
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getConfigurationFile());
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

    /**
     * Register bundle
     *
     * Returns an array of bundles to register.
     *
     * @return BundleInterface[] An array of bundle instances
     */
    public function registerBundles()
    {
        $bundles = [
            new UnglinLandUserBundle(),
        ];

        $driver = $this->getDriver();

        $doctrineOrmBundle = 'Doctrine\Bundle\DoctrineBundle\DoctrineBundle';
        if (class_exists($doctrineOrmBundle) && in_array($driver, ['orm', 'odm'])) {
            $bundles[] = new $doctrineOrmBundle();
        }

        $doctrineODMBundle = 'Doctrine\Bundle\MongoDBBundle\DoctrineMongoDBBundle';
        $frameworkBundle = 'Symfony\Bundle\FrameworkBundle\FrameworkBundle';
        if (class_exists($doctrineODMBundle) && class_exists($frameworkBundle) && $driver == 'odm') {
            $bundles[] = new $frameworkBundle();
            $bundles[] = new $doctrineODMBundle();
        }

        return $bundles;
    }

    /**
     * Get configuration file
     *
     * Return the configuration file path of the kernel
     *
     * @return string
     */
    public function getConfigurationFile()
    {
        if (!empty($this->configurationFile)) {
            return $this->configurationFile;
        }

        return $this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml';
    }

    /**
     * Set configuration file
     *
     * Update the kernel configuration file of the kernel
     *
     * @param string $configurationFile The configuration file path
     *
     * @return UserBundleKernel
     */
    public function setConfigurationFile($configurationFile) : UserBundleKernel
    {
        $this->configurationFile = $configurationFile;
        return $this;
    }

    /**
     * Get driver
     *
     * This method return the current configured drive for userSymfonyBridge system
     *
     * @return string
     */
    private function getDriver() : string
    {
        if (is_file($this->configurationFile)) {
            $yaml = new Yaml();
            $config = $yaml->parse(file_get_contents($this->configurationFile));
            return isset($config['unglin_land_user']) && isset($config['unglin_land_user']['driver']) ?
                $config['unglin_land_user']['driver'] :
                '';
        }

        return '';
    }
}
