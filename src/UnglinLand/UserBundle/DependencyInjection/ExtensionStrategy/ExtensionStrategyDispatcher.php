<?php
/**
 * This file is part of UserSymfonyBridge
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 7.1
 *
 * @category BundleExtension
 * @package  UserSymfonyBridge
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace UnglinLand\UserBundle\DependencyInjection\ExtensionStrategy;

/**
 * Extension strategy dispatcher
 *
 * This class is used to dispatch the extension strategy
 *
 * @category BundleExtension
 * @package  UserSymfonyBridge
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ExtensionStrategyDispatcher extends \SplObjectStorage
{
    /**
     * Attach
     *
     * Adds an object in the storage
     *
     * @param object $object <p>
     *                       The object to add.
     *                       </p>
     * @param mixed  $data   [optional] <p>
     *                       The data to
     *                       associate with
     *                       the object.
     *                       </p>          </p>
     *
     * @link   http://www.php.net/manual/en/splobjectstorage.attach.php
     * @return $this
     */
    public function attach($object, $data = null) : ExtensionStrategyDispatcher
    {
        parent::attach($object, $data);

        return $this;
    }

    /**
     * Dispatch
     *
     * This method dispatch an option array between each attached strategy
     *
     * @param array $options The option array
     *
     * @return void
     */
    public function dispatch(array $options) : void
    {
        foreach ($this as $strategy) {
            $this->processStrategy($strategy, $options);
        }

        return;
    }

    /**
     * Process strategy
     *
     * This method test a strategy support and execute if available
     *
     * @param ExtensionStrategyInterface $strategy The strategy to process
     * @param array                      $options  The option array
     *
     * @return void
     */
    protected function processStrategy(ExtensionStrategyInterface $strategy, array $options) : void
    {
        if (!$strategy->support($options)) {
            return;
        }

        $strategy->process($options);
        return;
    }
}
