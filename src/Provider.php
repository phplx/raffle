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

use ReflectionClass;
use RuntimeException;

/**
 * @author  Samuel Gordalina <samuel.gordalina@gmail.com>
 */
class Provider
{
    /**
     * @var Eventbrite
     */
    private $provider;

    /**
     * @var Cache
     */
    private $cache;

    public function __construct()
    {
        $this->config = $this->getConfiguration();
        $this->cache = new Cache($this->getCacheKey());
    }

    /**
     * Get attendees from cache or provider
     *
     * @return array
     */
    public function getAttendees()
    {
        $attendees = $this->cache->getAttendees();

        if (!$attendees) {
            $attendees = $this->getService()->getAttendees();
        }

        return $attendees;
    }

    /**
     * Persist attendees to cache
     *
     * @return null
     */
    public function persist($attendees)
    {
        $this->cache->setAttendees($attendees);
        $this->cache->persist();
    }

    /**
     * Instantiate provider service
     *
     * @return object
     */
    protected function getService()
    {
        $className = $this->config->class;

        if (!class_exists($className, true)) {
            throw new RuntimeException(sprintf(
                'Could not load provider class: %s',
                $className
            ));
        }

        $class = new ReflectionClass($className);
        $instance = $class->newInstance($this->config->parameters);

        return $instance;
    }

    /**
     * Return a unique identification key
     *
     * @return string
     */
    protected function getCacheKey()
    {
        return dechex(crc32(json_encode($this->config)));
    }

    /**
     * Load provider configuration
     *
     * @return mixed
     */
    protected function getConfiguration()
    {
        $filename = sprintf('%s/../config/provider.json', __DIR__);

        if (!is_file($filename)) {
            throw new RuntimeException(sprintf("%s does not exist", $filename));
        }

        $contents = file_get_contents($filename);
        $data = json_decode($contents);

        if (json_last_error()) {
            throw new RuntimeException(sprintf("%s is corrupt", $filename));
        }

        return $data;
    }
}
