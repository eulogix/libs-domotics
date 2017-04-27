<?php

/*
 * This file is part of the Eulogix\Lib package.
 *
 * (c) Eulogix <http://www.eulogix.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eulogix\Lib\HikTools\email;

/**
 * Parses and represents as an object an alert email message as sent by HikVision cameras
 *
 * Example:

Subject: ORTO: on Camera1: Intrusion Detection
X-Mailer: HIKMailer
X-Priority: 2
MIME-Version: 1.0
Content-type: multipart/alternative; boundary="#BOUNDARY#"

--#BOUNDARY#
Content-Type: text/plain; charset=gb2312
Content-Transfer-Encoding: 8bit

This is an automatically generated e-mail from your IPC.

EVENT TYPE: Intrusion Detection
EVENT TIME: 2015-05-22,14:52:18
IPC NAME: ORTO
CHANNEL NAME: Orto
CHANNEL NUMBER: 1
IPC S/N: DS-2CD2032-I20150107CCCH497875383

--#BOUNDARY#--

 *
 * @author Pietro Baricco <pietro@eulogix.com>
 *
 */

class Alert {

    const TYPE_INTRUSION = 'Intrusion Detection';

    /**
     * @var string[]
     */
    private $values = [];

    /**
     * @param string $body
     */
    public function __construct($body) {
        preg_match_all('/^([^\n\r:]+): (.+?)$/im', $body, $matches, PREG_SET_ORDER);
        $values = [];
        foreach($matches as $match) {
            $values[$match[1]] = $match[2];
        }
        $this->values = $values;
    }

    /**
     * @return string
     */
    public function getEventType()
    {
        return $this->getValue('EVENT TYPE');
    }

    /**
     * @return string
     */
    public function getIpcName() {
        return $this->getValue('IPC NAME');
    }

    /**
     * @return string
     */
    public function getIpcSerialNumber() {
        return $this->getValue('IPC S/N');
    }

    /**
     * @return string
     */
    public function getChannelName() {
        return $this->getValue('CHANNEL NAME');
    }

    /**
     * @param string $name
     * @return string
     */
    private function getValue($name) {
        return @$this->values[$name];
    }

} 