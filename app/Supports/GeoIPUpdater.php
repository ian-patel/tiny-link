<?php

namespace App\Supports;

use Exception;
use GuzzleHttp\Client as GuzzleClient;

class GeoIPUpdater
{
    /**
     * Local database path
     *
     * @var string
     */
    protected $databasePath;

    /**
     * Maxmind Database Url
     *
     * @var string
     */
    private $databaseUrl;

    /**
     * @param array $config
     */
    public function __construct(string $databasePath = null, string $databaseUrl = null)
    {
        $this->databasePath = $databasePath;
        $this->databaseUrl = $databaseUrl;
    }

    /**
     * Main update function.
     *
     * @return string|false
     */
    public function update()
    {
        if (null !== $this->databasePath and null !== $this->databaseUrl) {
            return $this->updateMaxmindDatabase();
        }

        return false;
    }

    /**
     * Update function for maxmind database.
     *
     * @return string
     */
    protected function updateMaxmindDatabase()
    {
        if (! file_exists($dir = pathinfo($this->databasePath, PATHINFO_DIRNAME))) {
            mkdir($dir, 0777, true);
        }

        try {
            $file = (new GuzzleClient())->get($this->databaseUrl)->getBody();

            file_put_contents($this->databasePath, gzdecode($file));
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
