<?php
namespace Flownative\Messaging\Bus;

/*
 * This file is part of the Flownative.Messaging package.
 *
 * (c) Flownative GmbH - www.flownative.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Flownative\Messaging\Message\MessageInterface;
use Flownative\Messaging\Router\MessageRouterInterface;
use TYPO3\Flow\Annotations as Flow;

/**
 * A base class for message bus implementations
 *
 * @api
 */
abstract class AbstractMessageBus implements MessageBusInterface
{

    /**
     * Commands to be dispatched
     *
     * @var array
     */
    protected $messageDispatchQueue = [];

    /**
     * @var boolean
     */
    protected $dispatching = false;

    /**
     * @Flow\Inject
     * @var MessageRouterInterface
     */
    protected $messageRouter;

    /**
     * Dispatch the given command
     *
     * @param MessageInterface $message
     * @return void
     */
    public function dispatch(MessageInterface $message)
    {
        $this->messageDispatchQueue[] = $message;

        if (!$this->dispatching) {
            $this->dispatching = true;
            while ($message = array_shift($this->messageDispatchQueue)) {
                $this->messageRouter->route($message);
            }
            $this->dispatching = false;
        }
    }

}
