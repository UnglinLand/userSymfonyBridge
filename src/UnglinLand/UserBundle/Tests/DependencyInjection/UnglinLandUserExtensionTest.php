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
use UnglinLand\UserBundle\DependencyInjection\UnglinLandUserExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

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
     * Test load
     *
     * This method validate the UnglinLandUserExtension::load method logic
     *
     * @return void
     */
    public function testLoad()
    {
        $container = $this->createMock(ContainerBuilder::class);
        $configs = ['unglin_land_user'=>[]];

        $this->instance->load($configs, $container);
        $this->assertTrue(true);
    }
}
