<?php
/**
 * This file is part of UserSymfonyBridge
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 7.2
 *
 * @category Compilation
 * @package  UserSymfonyBridge
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace UnglinLand\UserBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use UnglinLand\UserBundle\DependencyInjection\Configuration;

/**
 * Role model compiler pass
 *
 * This clas is used to compile the RoleModel logic
 *
 * @category Compilation
 * @package  UserSymfonyBridge
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class RoleModelCompilerPass implements CompilerPassInterface
{
    /**
     * Process
     *
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container The application container
     *
     * @return void
     */
    public function process(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig('unglin_land_user');
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $repositoryService = $this->getRoleRepository($config);

        $container->setAlias('unglin_land.role.default_repository', $repositoryService);
    }

    /**
     * Get role repository
     *
     * This method return the service repository name to be used as default repository for the roles entities
     *
     * @param array $config The bundle configuration
     *
     * @return string
     */
    private function getRoleRepository(array $config) : string
    {
        $driver = $config['driver'];
        if (!isset($config['driver_configuration']['role_repository'])) {
            return $this->getRepositoryServiceFor($driver);
        }

        return $config['driver_configuration']['role_repository'];
    }

    /**
     * Get repository service for driver
     *
     * This method return the default repository service for a given driver
     *
     * @param string $driver The driver name
     *
     * @return string
     */
    private function getRepositoryServiceFor(string $driver) : string
    {
        $map = [
            'orm' => 'unglin_land.role.doctrine_orm_repository',
            'odm' => 'unglin_land.role.doctrine_odm_repository'
        ];

        return $map[$driver];
    }

    /**
     * Process configuration
     *
     * This method process the given configuration
     *
     * @param ConfigurationInterface $configuration The configuration object that provide the configuration tree
     * @param array                  $configs       The configuration array to process
     *
     * @return array
     */
    private function processConfiguration(ConfigurationInterface $configuration, array $configs) : array
    {
        $processor = new Processor();

        return $processor->processConfiguration($configuration, $configs);
    }
}
