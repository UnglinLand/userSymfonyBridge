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
namespace UnglinLand\UserBundle\Tests\Functionnal\Role;

use PHPUnit\Framework\TestCase;
use UnglinLand\UserModule\Manager\UnglinRoleManager;
use UnglinLand\UserBundle\Kernel\UserBundleKernel;
use UnglinLand\UserBundle\Tests\Kernel\OdmTestKernel;
use UnglinLand\UserBundle\Tests\Kernel\OrmTestKernel;

/**
 * Role manager test
 *
 * This class is used to validate the functionnal capacity of the RoleManager
 *
 * @category Test
 * @package  UserSymfonyBridge
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class RoleManagerTest extends TestCase
{
    /**
     * Get odm kernel
     *
     * This method return the kernel with odm configuration
     *
     * @return UserBundleKernel
     */
    protected function getOdmKernel()
    {
        $kernel = new OdmTestKernel('test_odm', true);
        $kernel->boot();

        return $kernel;
    }

    /**
     * Get orm kernel
     *
     * This method return the kernel with orm configuration
     *
     * @return UserBundleKernel
     */
    protected function getOrmKernel()
    {
        $kernel = new OrmTestKernel('test_orm', true);
        $kernel->boot();

        return $kernel;
    }

    /**
     * Test orm capacity
     *
     * This method validate the orm capacity of the role manager
     *
     * @return void
     */
    public function testOrmCapacity() : void
    {
        $kernel = $this->getOrmKernel();

        $container = $kernel->getContainer();

        $manager = $container->get('unglin_land.role.manager');

        $this->assertInstanceOf(UnglinRoleManager::class, $manager);

        $role = $manager->createInstance();
        $role->setLabel('ROLE_TEST');
        $manager->save($role);

        $this->assertEquals($role, $manager->loadById($role->getId()));

        $manager->delete($role);

        $this->assertNull($manager->loadById($role->getId()));
        return;
    }

    /**
     * Test odm capacity
     *
     * This method validate the odm capacity of the role manager
     *
     * @return void
     */
    public function testOdmCapacity() : void
    {
        $kernel = $this->getOdmKernel();

        $container = $kernel->getContainer();

        $manager = $container->get('unglin_land.role.manager');

        $this->assertInstanceOf(UnglinRoleManager::class, $manager);

        $role = $manager->createInstance();
        $role->setLabel('ROLE_TEST');
        $manager->save($role);

        $this->assertEquals($role, $manager->loadById($role->getId()));

        $manager->delete($role);

        $this->assertNull($manager->loadById($role->getId()));
        return;
    }
}
