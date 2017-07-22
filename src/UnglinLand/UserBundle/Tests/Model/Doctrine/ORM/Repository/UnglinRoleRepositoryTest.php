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
namespace UnglinLand\UserBundle\Tests\Model\Doctrine\ORM\Repository;

use PHPUnit\Framework\TestCase;
use UnglinLand\UserBundle\Model\Doctrine\ORM\Repository\UnglinRoleRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\UnitOfWork;
use UnglinLand\UserModule\Model\UnglinRole;
use Doctrine\ORM\Persisters\Entity\EntityPersister;

/**
 * UnglinRoleRepository test
 *
 * This class is used to validate the UnglinRoleRepository logic
 *
 * @category Test
 * @package  UserSymfonyBridge
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class UnglinRoleRepositoryTest extends TestCase
{
    /**
     * Test findOneById
     *
     * This method validate the UnglinRoleRepository::findOneById method logic
     *
     * @return void
     */
    public function testFindOneById()
    {
        $entityPersister = $this->createMock(EntityPersister::class);
        $unitOfWork = $this->createMock(UnitOfWork::class);
        $entityManager = $this->createMock(EntityManager::class);
        $metadata = $this->createMock(ClassMetadata::class);

        $metadata->name = UnglinRole::class;

        $entityManager->expects($this->once())
            ->method('getUnitOfWork')
            ->willReturn($unitOfWork);

        $unitOfWork->expects($this->once())
            ->method('getEntityPersister')
            ->with($this->equalTo(UnglinRole::class))
            ->willReturn($entityPersister);

        $entityPersister->expects($this->once())
            ->method('load')
            ->with($this->equalTo(['id' => 123]));

        $instance = new UnglinRoleRepository($entityManager, $metadata);

        $instance->findOneById(123);
    }
}
