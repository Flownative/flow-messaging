<?php
namespace Flownative\Messaging\Router;

/*
 * This file is part of the Flownative.Messaging package.
 *
 * (c) Flownative GmbH - www.flownative.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Log\SystemLoggerInterface;
use TYPO3\Flow\Object\ObjectManagerInterface;
use Flownative\Messaging\Message\MessageInterface;

/**
 * Message Router
 *
 * @Flow\Scope("singleton")
 */
class MessageRouter implements MessageRouterInterface
{

    /**
     * @Flow\Inject
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @Flow\Inject
     * @var SystemLoggerInterface
     */
    protected $systemLogger;

    /**
     * Maps message types to handlers
     *
     * @var array
     */
    protected $messageHandlerMap = [];

    /**
     * Routes the given message
     *
     * @param MessageInterface $message The message to route
     * @return string
     */
    public function route(MessageInterface $message)
    {
        if (isset($this->messageHandlerMap[get_class($message)])) {
            $messageHandler = $this->objectManager->get($this->messageHandlerMap[get_class($message)]);
            $messageHandler->handle($message);
        }
    }

    /**
     * Map the given message concrete class name to the specified message handler
     *
     * @param string $messageClassName The concrete class name of the message, for example "Acme\Command\CreateOrganization"
     * @param string $messageHandlerObjectName The object name (usually the class name) of the message handler
     * @return void
     */
    public function mapToMessageHandler($messageClassName, $messageHandlerObjectName) {
        $this->messageHandlerMap[$messageClassName] = $messageHandlerObjectName;
    }

}
