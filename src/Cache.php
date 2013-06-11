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
class Cache
{
    /**
     * @var array
     */
    private $attendees;

    /**
     * @var string
     */
    private $key;

    /**
     * @param string $key cache key identifier
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * @return null|array
     */
    public function getAttendees()
    {
        if ($this->attendees) {
            return $this->attendees;
        }

        $file = $this->getCacheFilename();

        if (!is_file($file)) {
            return;
        }

        $data = file_get_contents($file);
        $attendees = json_decode($data);

        if (json_last_error()) {
            return;
        }

        $this->attendees = $attendees;

        return $attendees;
    }

    /**
     * @param array $attendees
     */
    public function setAttendees($attendees)
    {
        $this->attendees = $attendees;
    }

    /**
     * Persist attendees to file system
     *
     * @return null
     */
    public function persist()
    {
        $filename = $this->getCacheFilename();
        $data = json_encode($this->attendees);

        file_put_contents($filename, $data);
    }

    /**
     * Generate a unique cache filename from cache key
     *
     * @return string
     */
    protected function getCacheFilename()
    {
        $dir = sprintf('%s/../cache', __DIR__);

        if (!is_dir($dir)) {
            mkdir($dir, 0755);
        }

        return sprintf('%s/%s.json', $dir, $this->key);
    }
}
