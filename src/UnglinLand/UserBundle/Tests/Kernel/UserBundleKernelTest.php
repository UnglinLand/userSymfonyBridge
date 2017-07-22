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
        $configFile = __DIR__.'/../KernelConfig/config_orm.yml';

        $instance = new UserBundleKernel('test', true);

        $classReflex = new \ReflectionClass(UserBundleKernel::class);
        $rootDir = dirname($classReflex->getFileName());
        $baseConfigFile = $rootDir.'/config/config_test.yml';
        $this->assertEquals($baseConfigFile, $instance->getConfigurationFile());

        $instance->setConfigurationFile($configFile);

        $this->assertNull($instance->boot());

        $this->assertEquals(sys_get_temp_dir().DIRECTORY_SEPARATOR.'UserBundleKernel', $instance->getLogDir());
        $this->assertEquals(sys_get_temp_dir().DIRECTORY_SEPARATOR.'UserBundleKernel', $instance->getCacheDir());
        $this->assertEquals($configFile, $instance->getConfigurationFile());

        $loader = $this->createMock(LoaderInterface::class);
        $loader->expects($this->once())
            ->method('load')
            ->with($configFile);
        $instance->registerContainerConfiguration($loader);
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
        $instance = new UserBundleKernel('test', true);
        $instance->setConfigurationFile(__DIR__.'/../KernelConfig/config_orm.yml');

        $expectedBundles = [
            UnglinLandUserBundle::class,
            DoctrineBundle::class
        ];

        $bundles = $instance->registerBundles();
        $this->assertCount(2, $bundles);
        $this->assertInstanceOf($expectedBundles[0], $bundles[0]);
        $this->assertInstanceOf($expectedBundles[1], $bundles[1]);
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
        $instance = new UserBundleKernel('test', true);
        $instance->setConfigurationFile(__DIR__.'/../KernelConfig/config_odm.yml');

        $expectedBundles = [
            UnglinLandUserBundle::class,
            DoctrineBundle::class,
            FrameworkBundle::class,
            DoctrineMongoDBBundle::class
        ];

        $bundles = $instance->registerBundles();
        $this->assertCount(4, $bundles);
        $this->assertInstanceOf($expectedBundles[0], $bundles[0]);
        $this->assertInstanceOf($expectedBundles[1], $bundles[1]);
        $this->assertInstanceOf($expectedBundles[2], $bundles[2]);
        $this->assertInstanceOf($expectedBundles[3], $bundles[3]);
    }

    /**
     * Test no driver bundle registered
     *
     * This method validate the registered bundles with no configured driver
     *
     * @return void
     */
    public function testNoDriverBundleRegistered()
    {
        $instance = new UserBundleKernel('test', true);
        $instance->setConfigurationFile('unexisting.file');

        $expectedBundles = [
            UnglinLandUserBundle::class
        ];

        $bundles = $instance->registerBundles();
        $this->assertCount(1, $bundles);
        $this->assertInstanceOf($expectedBundles[0], $bundles[0]);
    }
}
