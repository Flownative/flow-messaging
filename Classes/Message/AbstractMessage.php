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

use Ramsey\Uuid\Uuid;

/**
 * Base class for Domain Messages
 *
 * @api
 */
abstract class AbstractMessage implements MessageInterface
{

    /**
     * @var string
     */
    protected $messageIdentifier;

    /**
     * @var \DateTimeImmutable
     */
    protected $messageCreationDateTime;

    /**
     * The user-defined "headers" of a message
     *
     * @var array
     */
    protected $messageMetadata;

    /**
     * The user-defined "body" of a message
     *
     * @var array
     */
    protected $messagePayload;

    /**
     * Create a new message instance based on the given message data, without calling the constructor
     * or re-initializing its metadata.
     *
     * This method is used for reconstituting messages from a storage or transport channel.
     *
     * @param array $messageData The message data. Must contain keys "messageIdentifier", "messageCreationDateTime", "messagePayload" and "messageMetadata".
     * @return AbstractMessage
     * @api
     */
    public static function recreate(array $messageData)
    {
        foreach (['messageIdentifier', 'messageCreationDateTime', 'messagePayload', 'messageMetadata'] as $key) {
            if (!isset($messageData[$key])) {
                throw new \InvalidArgumentException(sprintf('Message data must contain %s.', $key), 1469565781338);
            }
        }

        $messageClass = new \ReflectionClass(get_called_class());
        /** @var AbstractMessage $message */
        $message = $messageClass->newInstanceWithoutConstructor();
        $message->messageIdentifier = $messageData['messageIdentifier'];
        $message->messageCreationDateTime = $messageData['messageCreationDateTime'];
        $message->setMessagePayload($messageData['messagePayload']);
        $message->setMessageMetadata($messageData['messageMetadata']);

        return $message;
    }

    /**
     * Returns the identifier of this message
     *
     * @return string
     * @api
     */
    public function getMessageIdentifier()
    {
        return $this->messageIdentifier;
    }

    /**
     * Returns the date / time of when this message has been created
     *
     * @return \DateTimeImmutable
     * @api
     */
    public function getMessageCreationDateTime()
    {
        return $this->messageCreationDateTime;
    }

    /**
     * Returns the metadata of this message
     *
     * @return array
     * @api
     */
    public function getMessageMetadata()
    {
        return $this->messageMetadata;
    }

    /**
     * Returns the payload of this message
     *
     * @return array
     * @api
     */
    public function getMessagePayload()
    {
        return $this->messagePayload;
    }

    /**
     * Initializes the message with the necessary identifier and timestamp
     *
     * @return void
     */
    protected function initialize()
    {
        if ($this->messageIdentifier === null) {
            $this->messageIdentifier = Uuid::uuid4()->toString();
        }

        if ($this->messageCreationDateTime === null) {
            $time = microtime(true);
            if (false === strpos($time, '.')) {
                $time .= '.0000';
            }
            $this->messageCreationDateTime = \DateTimeImmutable::createFromFormat('U.u', $time);
        }
    }

    /**
     * Set the message's payload
     *
     * This method is called when message is instantiated named constructor recreate()
     *
     * @param array $messagePayload
     * @return void
     */
    protected function setMessagePayload(array $messagePayload)
    {
        $this->messagePayload = $messagePayload;
    }

    /**
     * Set the message's metadata
     *
     * This method is called when message is instantiated named constructor recreate()
     *
     * @param array $messageMetadata
     * @return void
     */
    protected function setMessageMetadata(array $messageMetadata)
    {
        $this->messageMetadata = $messageMetadata;
    }

}
