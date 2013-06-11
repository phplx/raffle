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

/**
 * @author  Samuel Gordalina <samuel.gordalina@gmail.com>
 */
class App
{
    /**
     * @var string
     */
    protected $prize;

    /**
     * @param string $prize
     */
    public function setPrize($prize)
    {
        $this->prize = $prize;
    }

    /**
     * Run the application
     *
     * @return null
     */
    public function run()
    {
        $attendees = new Attendees();
        $attendees->setProvider(new Provider());

        $attendee = $attendees->popRandomAttendee($this->prize);

        echo sprintf(
            "Congratulations %s %s (%s), You Won a %s!\n",
            $attendee->first_name,
            $attendee->last_name,
            $attendee->email,
            $this->prize
        );

        $attendees->persist();
    }
}
