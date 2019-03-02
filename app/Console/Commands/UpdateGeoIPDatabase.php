<?php

namespace App\Console\Commands;

use App\Supports\GeoIPUpdater;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class UpdateGeoIPDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:geoip-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update GeoIP database from maxmind';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): bool
    {
        $config = config('services.geoip.maxmind');

        if ($config['autoupdate']) {
            $updater = new GeoIPUpdater(Storage::path($config['database']), $config['source']);
            return $updater->update();
        }

        return false;
    }
}
