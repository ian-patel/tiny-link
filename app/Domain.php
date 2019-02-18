<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Domain extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
	    'name', 'account_id'
	];

	/**
	 * The model's default values for attributes.
	 *
	 * @var array
	 */
	protected $attributes = [
	    'is_default' => false,
	];

	/**
	 * Get the account that owns the domain.
	 */
	public function account(): Relation
	{
	    return $this->belongsTo(Account::class);
	}

	/**
	 * Save the model to the database.
	 *
	 * @param  array  $options
	 * @return bool
	 */
	public function save(array $options = []): bool
	{
	    if ($this->isDirty('name')) {
	    	$elements = parse_url($this->name);

	    	$this->host = $elements['host'] ?? null;
	    	$this->scheme = $elements['scheme'] ?? null;
	    }

	    // Save
	    return parent::save($options);
	}
}
