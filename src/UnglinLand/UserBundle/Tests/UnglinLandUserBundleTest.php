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
namespace UnglinLand\UserBundle\Tests;

use PHPUnit\Framework\TestCase;
use UnglinLand\UserBundle\UnglinLandUserBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use UnglinLand\UserBundle\DependencyInjection\Compiler\RoleModelCompilerPass;

/**
 * UnglinLandUserBundle test
 *
 * This class is used to validate the UnglinLandUserBundle class
 *
 * @category Test
 * @package  UserSymfonyBridge
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class UnglinLandUserBundleTest extends TestCase
{
    /**
     * Test build
     *
     * This method validate the UserSymfonyBridge::build method
     *
     * @return void
     */
    public function testBuild()
    {
        $container = $this->createMock(ContainerBuilder::class);
        $bundle = new UnglinLandUserBundle();

        $container->expects($this->once())
            ->method('addCompilerPass')
            ->with($this->isInstanceOf(RoleModelCompilerPass::class));

        $bundle->build($container);
    }
}
