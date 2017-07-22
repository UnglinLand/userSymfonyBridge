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
namespace UnglinLand\UserBundle\Tests\DependencyInjection\Compiler;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use UnglinLand\UserBundle\DependencyInjection\Compiler\RoleModelCompilerPass;
use UnglinLand\UserBundle\DependencyInjection\Configuration;

/**
 * RoleModuleCompilerPass test
 *
 * This class is used to validate the RoleModuleCompilerPass logic
 *
 * @category Test
 * @package  UserSymfonyBridge
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class RoleModelCompilerPassTest extends TestCase
{
    /**
     * Test process
     *
     * This method validate the RoleModelCompilerPass::process method logic
     *
     * @return void
     */
    public function testProcess()
    {
        $container = $this->createMock(ContainerBuilder::class);

        $container->expects($this->once())
            ->method('getExtensionConfig')
            ->with($this->equalTo('unglin_land_user'))
            ->willReturn(['unglin_land_user' => ['driver' => 'orm']]);

        $container->expects($this->once())
            ->method('setAlias')
            ->with(
                $this->equalTo('unglin_land.role.default_repository'),
                $this->equalTo('unglin_land.role.doctrine_orm_repository')
            );

        $instance = new RoleModelCompilerPass();
        $instance->process($container);
    }

    /**
     * Config provider
     *
     * This method is used to provide data for testGetRoleRepository
     *
     * @return array
     */
    public function configProvider()
    {
        return [
            [
                ['driver' => 'orm'],
                'unglin_land.role.doctrine_orm_repository'
            ],
            [
                ['driver' => 'orm', 'driver_configuration' => ['role_repository' => 'test_role_repository']],
                'test_role_repository'
            ]
        ];
    }

    /**
     * Test getRoleRepository
     *
     * This method validate the RoleModelCompilerPass::getRoleRepository method logic
     *
     * @param array  $config   The bundle configuration
     * @param strign $expected The expected method result
     *
     * @dataProvider configProvider
     * @return       void
     */
    public function testGetRoleRepository(array $config, string $expected)
    {
        $instance = new RoleModelCompilerPass();

        $compilerReflection = new \ReflectionClass(RoleModelCompilerPass::class);
        $method = $compilerReflection->getMethod('getRoleRepository');
        $method->setAccessible(true);

        $this->assertEquals($expected, $method->invoke($instance, $config));
    }

    /**
     * Test getRepositoryServiceFor
     *
     * This method validate the RoleModelCompilerPass::getRepositoryServiceFor method logic
     *
     * @return void
     */
    public function testGetRepositoryFor()
    {
        $instance = new RoleModelCompilerPass();

        $compilerReflection = new \ReflectionClass(RoleModelCompilerPass::class);
        $method = $compilerReflection->getMethod('getRepositoryServiceFor');
        $method->setAccessible(true);

        $this->assertEquals('unglin_land.role.doctrine_orm_repository', $method->invoke($instance, 'orm'));
    }

    /**
     * Test processConfiguration
     *
     * This method validate the RoleModelCompilerPass::processConfiguration method logic
     *
     * @return void
     */
    public function testProcessConfiguration()
    {
        $instance = new RoleModelCompilerPass();

        $compilerReflection = new \ReflectionClass(RoleModelCompilerPass::class);
        $method = $compilerReflection->getMethod('processConfiguration');
        $method->setAccessible(true);

        $configuration = new Configuration();
        $result = $method->invoke($instance, $configuration, ['unglin_land_user' => ['driver' => 'orm']]);

        $this->assertEquals(['driver' => 'orm', 'driver_configuration' => ['odm_manager_name' => 'default']], $result);
    }
}
