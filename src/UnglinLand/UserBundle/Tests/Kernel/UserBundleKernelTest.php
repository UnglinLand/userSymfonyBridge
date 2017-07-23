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

use PHPUnit\Framework\TestCase;
use UnglinLand\UserBundle\Kernel\UserBundleKernel;
use Symfony\Component\Config\Loader\LoaderInterface;
use UnglinLand\UserBundle\UnglinLandUserBundle;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Doctrine\Bundle\MongoDBBundle\DoctrineMongoDBBundle;
use Symfony\Bundle\MonologBundle\MonologBundle;
use UnglinLand\UserBundle\Kernel\AbstractKernel;

/**
 * UserBundleKernel test
 *
 * This class is used to validate the UserBundleKernel logic
 *
 * @category Test
 * @package  UserSymfonyBridge
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class UserBundleKernelTest extends TestCase
{
    /**
     * Test configuration
     *
     * This method validate the kernel configuration
     *
     * @return void
     */
    public function testConfiguration()
    {
        $loader = $this->createMock(LoaderInterface::class);
        $loader->expects($this->once())
            ->method('load')
            ->with($this->equalTo(__DIR__.'/../KernelConfig/config_orm.yml'));

        $kernel = $this->getMockForAbstractClass(
            AbstractKernel::class,
            ['test', true],
            '',
            true,
            true,
            true,
            ['getConfigurationFile']
        );

        $kernel->expects($this->once())
            ->method('getConfigurationFile')
            ->willReturn(__DIR__.'/../KernelConfig/config_orm.yml');

        $kernel->registerContainerConfiguration($loader);
    }

    /**
     * Test orm bundle registered
     *
     * This method validate the registered bundles for orm driver
     *
     * @return void
     */
    public function testOrmBundleRegistered()
    {
        $instance = new OrmTestKernel('test', true);

        $expectedBundles = [
            UnglinLandUserBundle::class,
            MonologBundle::class,
            DoctrineBundle::class
        ];

        $bundles = $instance->registerBundles();
        $this->assertCount(3, $bundles);
        $this->assertInstanceOf($expectedBundles[0], $bundles[0]);
        $this->assertInstanceOf($expectedBundles[1], $bundles[1]);
        $this->assertInstanceOf($expectedBundles[2], $bundles[2]);
    }

    /**
     * Test odm bundle registered
     *
     * This method validate the registered bundles for odm driver
     *
     * @return void
     */
    public function testOdmBundleRegistered()
    {
        $instance = new OdmTestKernel('test', true);

        $expectedBundles = [
            UnglinLandUserBundle::class,
            MonologBundle::class,
            DoctrineBundle::class,
            FrameworkBundle::class,
            DoctrineMongoDBBundle::class
        ];

        $bundles = $instance->registerBundles();
        $this->assertCount(5, $bundles);
        $this->assertInstanceOf($expectedBundles[0], $bundles[0]);
        $this->assertInstanceOf($expectedBundles[1], $bundles[1]);
        $this->assertInstanceOf($expectedBundles[2], $bundles[2]);
        $this->assertInstanceOf($expectedBundles[3], $bundles[3]);
        $this->assertInstanceOf($expectedBundles[4], $bundles[4]);
    }

    /**
     * Test no driver bundle registered
     *
     * This method validate the registered bundles with no configured driver
     *
     * @return void
     */
    public function testNoDriverBundle()
    {
        $kernel = $this->getMockForAbstractClass(
            AbstractKernel::class,
            ['test', true],
            '',
            true,
            true,
            true,
            ['getConfigurationFile']
        );

        $kernel->expects($this->once())
            ->method('getConfigurationFile')
            ->willReturn('unexistingFile');

        $expectedBundles = [
            UnglinLandUserBundle::class,
            MonologBundle::class
        ];

        $bundles = $kernel->registerBundles();
        $this->assertCount(2, $bundles);
        $this->assertInstanceOf($expectedBundles[0], $bundles[0]);
        $this->assertInstanceOf($expectedBundles[1], $bundles[1]);
    }
}
