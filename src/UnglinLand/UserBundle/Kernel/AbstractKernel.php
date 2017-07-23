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
use UnglinLand\UserBundle\UnglinLandUserBundle;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * AbstractKernel
 *
 * This class is used to load the minimum requirements of the UnglinLandUserBundle
 *
 * @category UserSymfonyBridge
 * @package  UserSymfonyBridge
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
abstract class AbstractKernel extends Kernel
{
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
            new MonologBundle()
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
    abstract public function getConfigurationFile();

    /**
     * Get driver
     *
     * This method return the current configured drive for userSymfonyBridge system
     *
     * @return string
     */
    private function getDriver() : string
    {
        if (is_file($this->getConfigurationFile())) {
            $yaml = new Yaml();
            $config = $yaml->parse(file_get_contents($this->getConfigurationFile()));
            return isset($config['unglin_land_user']) && isset($config['unglin_land_user']['driver']) ?
                $config['unglin_land_user']['driver'] :
                '';
        }

        return '';
    }
}
