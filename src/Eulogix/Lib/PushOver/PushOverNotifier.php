<?php

/*
 * This file is part of the Eulogix\Lib package.
 *
 * (c) Eulogix <http://www.eulogix.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eulogix\Lib\PushOver;

/**
 * sends PushOver Notifications
 *
    AVAILABLE SOUNDS:

    pushover - Pushover (default)
    bike - Bike
    bugle - Bugle
    cashregister - Cash Register
    classical - Classical
    cosmic - Cosmic
    falling - Falling
    gamelan - Gamelan
    incoming - Incoming
    intermission - Intermission
    magic - Magic
    mechanical - Mechanical
    pianobar - Piano Bar
    siren - Siren
    spacealarm - Space Alarm
    tugboat - Tug Boat
    alien - Alien Alarm (long)
    climb - Climb (long)
    persistent - Persistent (long)
    echo - Pushover Echo (long)
    updown - Up Down (long)
    none - None (silent)

 * @author Pietro Baricco <pietro@eulogix.com>
 */

class PushOverNotifier
{

    /**
     * @var string
     */
    private $token, $user;

    /**
     * @param string $token
     * @param string $user
     */
    public function __construct($token, $user) {
        $this->token = $token;
        $this->user = $user;
    }

    /**
     * @param string $message
     * @param string $title
     * @param int $priority
     */
    public function pushNotification($message, $title, $priority) {
        curl_setopt_array($ch = curl_init(), array(
            CURLOPT_URL => "https://api.pushover.net/1/messages.json",
            CURLOPT_POSTFIELDS => array(
                "token" => $this->token,
                "user" => $this->user,
                "message" => $message,
                "html" => 1,
                "title" => $title,
                "priority" => $priority,
                "retry" => 30, // in seconds, 30 to 300
                "expire" => 3600*2, // in seconds, up to 86400 (24h)
                "sound" => "updown"
            ),
            CURLOPT_SAFE_UPLOAD => true,
        ));
        curl_exec($ch);
        curl_close($ch);
    }

}