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
namespace UnglinLand\UserBundle\Tests\Model\Doctrine\Mapper;

use PHPUnit\Framework\TestCase;
use Doctrine\Common\Persistence\ObjectManager;
use UnglinLand\UserModule\Model\Repository\UnglinRoleRepositoryInterface;
use UnglinLand\UserBundle\Model\Doctrine\Mapper\UnglinRoleMapper;
use UnglinLand\UserModule\Model\UnglinRole;

/**
 * UnglinRoleMapper test
 *
 * This class is used to validate the UnglinRoleMapper logic
 *
 * @category Test
 * @package  UserSymfonyBridge
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class UnglinRoleMapperTest extends TestCase
{
    /**
     * Test findOneById
     *
     * This method validate the UnglinRoleMapper::findOneById method logic
     *
     * @return void
     */
    public function testFindOneById()
    {
        $objectManager = $this->createMock(ObjectManager::class);
        $repository = $this->createMock(UnglinRoleRepositoryInterface::class);

        $instance = new UnglinRoleMapper($objectManager, $repository);

        $role = $this->createMock(UnglinRole::class);

        $repository->expects($this->once())
            ->method('findOneById')
            ->with($this->equalTo(123))
            ->willReturn($role);

        $this->assertSame($role, $instance->findOneById(123));
    }

    /**
     * Test save
     *
     * This method validate the UnglinRoleMapper::save method logic
     *
     * @return void
     */
    public function testSave()
    {
        $objectManager = $this->createMock(ObjectManager::class);
        $repository = $this->createMock(UnglinRoleRepositoryInterface::class);

        $instance = new UnglinRoleMapper($objectManager, $repository);

        $role = $this->createMock(UnglinRole::class);

        $objectManager->expects($this->once())
            ->method('flush')
            ->with($this->identicalTo($role));

        $this->assertNull($instance->save($role));
    }

    /**
     * Test persist
     *
     * This method validate the UnglinRoleMapper::persist method logic
     *
     * @return void
     */
    public function testPersist()
    {
        $objectManager = $this->createMock(ObjectManager::class);
        $repository = $this->createMock(UnglinRoleRepositoryInterface::class);

        $instance = new UnglinRoleMapper($objectManager, $repository);

        $role = $this->createMock(UnglinRole::class);

        $objectManager->expects($this->once())
            ->method('persist')
            ->with($this->identicalTo($role));

        $this->assertNull($instance->persist($role));
    }
}
