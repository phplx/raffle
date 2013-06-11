<?php

/*
 * This file is part of phplx Raffle.
 *
 * (c) 2013 phplx.net
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace phplx\Raffle\Provider;

/**
 * @author  Samuel Gordalina <samuel.gordalina@gmail.com>
 */
class Eventbrite
{
    /**
     * @var \EventBrite
     */
    protected $service;

    /**
     * @var object
     */
    protected $config;

    /**
     * @param mixed $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @return \Eventbrite
     */
    public function getService()
    {
        if (!$this->service instanceof \Eventbrite) {
            $this->service = new \Eventbrite((array) $this->config->authorization);
        }

        return $this->service;
    }

    /**
     * Return array of attendees
     *
     * @param  integer $eventId
     * @return array
     */
    public function getAttendees()
    {
        $response = $this->getService()->event_list_attendees(array(
            'id' => $this->config->event_id
        ));

        return $response->attendees;
    }
}
