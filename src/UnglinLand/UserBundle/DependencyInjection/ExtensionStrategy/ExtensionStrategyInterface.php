<?php
/**
 * This file is part of UserSymfonyBridge
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 7.2
 *
 * @category Bundle
 * @package  UserSymfonyBridge
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace UnglinLand\UserBundle\DependencyInjection\ExtensionStrategy;

/**
 * Extension strategy interface
 *
 * This interface define the base extension strategy methods
 *
 * @category Bundle
 * @package  UserSymfonyBridge
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface ExtensionStrategyInterface
{
    /**
     * Support
     *
     * This method indicate if the strategy support the given options
     *
     * @param array $options The strategy options
     *
     * @return bool
     */
    public function support(array $options) : bool;

    /**
     * Process
     *
     * This method process the given strategy options
     *
     * @param array $options The strategy options
     *
     * @return void
     */
    public function process(array $options) : void;
}
