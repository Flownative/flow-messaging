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

/**
 * Message Bus interface
 */
interface MessageBusInterface
{

    /**
     * Dispatches the given message
     *
     * @param MessageInterface $message The message to dispatch
     * @return string
     */
    public function dispatch(MessageInterface $message);

}
