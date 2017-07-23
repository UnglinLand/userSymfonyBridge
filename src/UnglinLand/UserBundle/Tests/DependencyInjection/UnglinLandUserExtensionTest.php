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
namespace UnglinLand\UserBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use UnglinLand\UserBundle\DependencyInjection\UnglinLandUserExtension;
use UnglinLand\UserBundle\Kernel\UserBundleKernel;
use UnglinLand\UserModule\Manager\UnglinRoleManager;
use UnglinLand\UserBundle\Tests\Kernel\OrmTestKernel;
use UnglinLand\UserBundle\Tests\Kernel\OdmTestKernel;

/**
 * UnglinLandUserExtension test
 *
 * This class is used to validate the UnglinLandUserExtension logic
 *
 * @category Test
 * @package  UserSymfonyBridge
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class UnglinLandUserExtensionTest extends TestCase
{
    /**
     * Instance
     *
     * This property store the instance to be validated
     *
     * @var UnglinLandUserExtension
     */
    private $instance;

    /**
     * Set up
     *
     * This method is used by the testing platform to initializate the test before each ones
     *
     * @see    \PHPUnit\Framework\TestCase::setUp()
     * @return void
     */
    protected function setUp()
    {
        $this->instance = new UnglinLandUserExtension();
    }

    /**
     * Test load orm
     *
     * This method validate the UnglinLandUserExtension::load method logic in case of orm driver
     *
     * @return void
     */
    public function testLoadOrm()
    {
        $container = $this->createMock(ContainerBuilder::class);
        $configs = ['unglin_land_user' => ['driver' => 'orm']];

        $container->expects($this->exactly(4))
            ->method('setDefinition')
            ->withConsecutive(
                [
                    $this->equalTo('unglin_land.role.manager'),
                    $this->anything()
                ],
                [
                    $this->equalTo('unglin_land.role.entity_manager'),
                    $this->anything()
                ],
                [
                    $this->equalTo('unglin_land.role.doctrine_orm_repository'),
                    $this->anything()
                ],
                [
                    $this->equalTo('unglin_land.role.mapper'),
                    $this->anything()
                ]
            );

        $this->instance->load($configs, $container);
    }

    /**
     * Test load odm
     *
     * This method validate the UnglinLandUserExtension::load method logic in case of odm driver
     *
     * @return void
     */
    public function testLoadOdm()
    {
        $container = $this->createMock(ContainerBuilder::class);
        $configs = ['unglin_land_user' => ['driver' => 'odm']];

        $container->expects($this->exactly(4))
            ->method('setDefinition')
            ->withConsecutive(
                [
                    $this->equalTo('unglin_land.role.manager'),
                    $this->anything()
                ],
                [
                    $this->equalTo('unglin_land.role.document_manager'),
                    $this->anything()
                ],
                [
                    $this->equalTo('unglin_land.role.doctrine_odm_repository'),
                    $this->anything()
                ],
                [
                    $this->equalTo('unglin_land.role.mapper'),
                    $this->anything()
                ]
            );

        $this->instance->load($configs, $container);
    }

    /**
     * Test prepend orm
     *
     * This method validate the prepend method of the UnglinLandUserExtension in case
     * of 'orm' driver
     *
     * @return void
     */
    public function testPrependOrm()
    {
        $container = $this->createMock(ContainerBuilder::class);
        $configs = ['unglin_land_user' => ['driver' => 'orm']];

        $container->expects($this->once())
            ->method('getExtensionConfig')
            ->with($this->equalTo('unglin_land_user'))
            ->willReturn($configs);

        $container->expects($this->once())
            ->method('getParameter')
            ->with($this->equalTo('kernel.bundles'))
            ->willReturn(['DoctrineBundle' => 'DoctrineBundlePath']);

        $container->expects($this->once())
            ->method('prependExtensionConfig')
            ->with($this->equalTo('doctrine'), $this->arrayHasKey('orm'));

        $this->instance->prepend($container);

        $kernel = new OrmTestKernel('test_orm', true);
        $kernel->boot();
        $container = $kernel->getContainer();

        $this->assertInstanceOf(
            UnglinRoleManager::class,
            $container->get('unglin_land.role.manager')
        );
    }

    /**
     * Test prepend odm
     *
     * This method validate the prepend method of the UnglinLandUserExtension in case
     * of 'odm' driver
     *
     * @return void
     */
    public function testPrependOdm()
    {
        $container = $this->createMock(ContainerBuilder::class);
        $configs = ['unglin_land_user' => ['driver' => 'odm']];

        $container->expects($this->once())
            ->method('getExtensionConfig')
            ->with($this->equalTo('unglin_land_user'))
            ->willReturn($configs);

        $container->expects($this->once())
            ->method('getParameter')
            ->with($this->equalTo('kernel.bundles'))
            ->willReturn(['DoctrineMongoDBBundle' => 'DoctrineMongoDBBundlePath']);

        $container->expects($this->once())
            ->method('prependExtensionConfig')
            ->with($this->equalTo('doctrine_mongodb'), $this->arrayHasKey('document_managers'));

        $this->instance->prepend($container);

        $kernel = new OdmTestKernel('test_odm', true);
        $kernel->boot();
        $container = $kernel->getContainer();

        $container->get('unglin_land.role.manager');

        $this->assertInstanceOf(
            UnglinRoleManager::class,
            $container->get('unglin_land.role.manager')
        );
    }
}
