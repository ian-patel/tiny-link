<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'city', 'region', 'regionCode', 'country', 'countryCode',
        'latitude', 'longitude', 'timezone', 'postalCode'
    ];

    /**
     * Save the model to the database.
     *
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = []): bool
    {
        if (!$this->exists and null === $this->ip) {
            $this->ip = request()->ip();
        }

        if (!$this->uuid) {
            $this->uuid = uuid();
        }

        // Save
        return parent::save($options);
    }
}
