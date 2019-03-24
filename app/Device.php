<?php

namespace App;

use Jenssegers\Agent\Agent;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    /**
     * Save the model to the database.
     *
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = []): bool
    {
        if (!$this->exists) {
            $agent = new Agent();

            $this->device_name = $agent->device() ?? '-';

            $platform = $agent->platform();
            $this->platform = $platform ?? 'Other';
            $this->platform_version = $agent->version($platform) ?? 'Other';

            $browser = $agent->browser();
            $this->browser = $browser ?? 'Other';
            $this->browser_version = $agent->version($browser) ?? 'Other';

            $this->device = $agent->isPhone() ?
                'Phone' : $agent->isTablet() ?
                'Tablet' : $agent->isDesktop() ? 'Desktop' : 'Other';

            $this->ip = request()->ip();
        }

        if (!$this->uuid) {
            $this->uuid = uuid();
        }

        // Save
        return parent::save($options);
    }
}
