<?php

/*
 * This file is part of phplx Raffle.
 *
 * (c) 2013 phplx.net
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace phplx\Raffle;

use RuntimeException;

/**
 * @author  Samuel Gordalina <samuel.gordalina@gmail.com>
 */
class Attendees
{
    /**
     * @var Provider
     */
    private $provider;

    /**
     * @var array
     */
    private $attendees;

    /**
     * @param Provider $provider
     */
    public function setProvider(Provider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Delete and return a random attendee
     *
     * @param  string $randKey
     * @return object
     */
    public function popRandomAttendee($randKey)
    {
        if (!$this->attendees) {
            $this->getAttendees();
        }

        mt_srand(crc32($randKey . microtime(true)));
        $idx = mt_rand(0, count($this->attendees)-1);
        $attendee = $this->attendees[$idx]->attendee;

        unset($this->attendees[$idx]);

        // force array re-indexation
        $this->attendees = array_values($this->attendees);

        return $attendee;
    }

    public function persist()
    {
        $this->provider->persist($this->attendees);
    }

    /**
     * Get attendees from provider
     *
     * @return array
     */
    protected function getAttendees()
    {
        if ($this->attendees) {
            return $this->attendees;
        }

        $attendees = $this->provider->getAttendees();

        if (!$attendees) {
            throw new RuntimeException('Could not load attendees');
        }

        $this->attendees = $attendees;

        return $this->attendees;
    }
}
