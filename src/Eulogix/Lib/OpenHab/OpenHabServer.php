<?php

/*
 * This file is part of the Eulogix\Lib package.
 *
 * (c) Eulogix <http://www.eulogix.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eulogix\Lib\OpenHab;

/**
 * Allows communication with an OpenHab server
 *
 * @author Pietro Baricco <pietro@eulogix.com>
 *
 */

class OpenHabServer {

    const ITEM_STATE_ON = 'ON';
    const ITEM_STATE_OFF = 'OFF';

    /**
     * @var string
     */
    private $serverBaseUrl;

    public function __construct($serverBaseUrl) {
        $this->serverBaseUrl = $serverBaseUrl;
    }

    /**
     * @param string $item
     * @param string $data
     * @return string
     */
    public function sendCommand($item, $data) {
        $url = $this->getBaseUrl()."/rest/items/" . $item;

        $options = array(
            'http' => array(
                'header'  => "Content-type: text/plain\r\n",
                'method'  => 'POST',
                'content' => $data,
            ),
        );

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        return $result;
    }

    /**
     * @param string $item
     * @param string $state
     * @return string
     */
    public function setItemState($item, $state) {

        $url = $this->getBaseUrl()."/rest/items/{$item}/state";

        $options = array(
            'http' => array(
                'header'  => "Content-type: text/plain\r\n",
                'method'  => 'PUT',
                'content' => $state,
            ),
        );

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        return $result;
    }

    /**
     * @return string
     */
    private function getBaseUrl()
    {
        return $this->serverBaseUrl;
    }

    /**
     * @param string $item
     * @return string
     */
    public function getItemState($item)
    {
        $url = $this->getBaseUrl()."/rest/items/{$item}/state";

        $options = array(
            'http' => array(
                'header'  => "Content-type: text/plain\r\n",
                'method'  => 'GET'
            ),
        );

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        return trim($result);
    }
} 