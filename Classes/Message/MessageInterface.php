<?php
namespace Flownative\Messaging\Message;

/*
 * This file is part of the Flownative.Messaging package.
 *
 * (c) Flownative GmbH - www.flownative.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Message interface
 */
interface MessageInterface
{

    /**
     * Returns the unique identifier of the message
     *
     * @return string
     */
    public function getMessageIdentifier();

    /**
     * Returns the date and time of when the message has been created
     *
     * @return \DateTimeImmutable
     */
    public function getMessageCreationDateTime();

    /**
     * Returns user-defined meta data of the message
     *
     * @return array
     */
    public function getMessageMetadata();

    /**
     * Returns the payload of the message
     *
     * @return array
     */
    public function getMessagePayload();

}
