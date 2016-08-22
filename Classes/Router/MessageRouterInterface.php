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

use Flownative\Messaging\Message\MessageInterface;

/**
 * Message Router interface
 */
interface MessageRouterInterface
{

    /**
     * Routes the given message
     *
     * @param MessageInterface $message The message to route
     * @return string
     */
    public function route(MessageInterface $message);

    /**
     * Map the given message concrete class name to the specified message handler
     *
     * @param string $messageClassName The concrete class name of the message, for example "Acme\Command\CreateOrganization"
     * @param string $messageHandlerObjectName The object name (usually the class name) of the message handler
     * @return void
     */
    public function mapToMessageHandler($messageClassName, $messageHandlerObjectName);

}
