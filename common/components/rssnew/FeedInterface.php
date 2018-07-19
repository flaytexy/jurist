<?php

namespace common\components\rssnew;

/**
 * Interface FeedInterface
 * @package common\components\rssnew
 */
interface FeedInterface
{
    /**
     * Add channel
     * @param ChannelInterface $channel
     * @return $thisJ
     */
    public function addChannel(ChannelInterface $channel);

    /**
     * Render XML
     * @return string
     */
    public function render();

    /**
     * Render XML
     * @return string
     */
    public function __toString();
}
