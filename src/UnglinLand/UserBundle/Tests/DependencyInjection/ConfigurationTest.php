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
use UnglinLand\UserBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Configuration test
 *
 * This class is used to validate the UnglinLandUserBundle configuration logic
 *
 * @category Test
 * @package  UserSymfonyBridge
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ConfigurationTest extends TestCase
{
    /**
     * Instance
     *
     * This property store the instance to be validated
     *
     * @var Configuration
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
        $this->instance = new Configuration();
    }

    /**
     * Test configTreeBuilder return
     *
     * This method is used to validate the Configuration::getConfigTreeBuilder method return value
     *
     * @return void
     */
    public function testConfigTreeBuilderReturn()
    {
        $tree = $this->instance->getConfigTreeBuilder();
        $this->assertInstanceOf(TreeBuilder::class, $tree);
        $this->assertEquals('unglin_land_user', $tree->buildTree()->getName());
    }
}
