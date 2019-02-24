<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Relation;

class Domain extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_by', 'account_id', 'deleted_at',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_default' => 'bool',
        'is_active' => 'bool',
    ];

    /**
     * Get the account that owns the domain.
     */
    public function account(): Relation
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the links for the domain.
     */
    public function links(): Relation
    {
        return $this->hasMany(Link::class);
    }

    /**
     * Save the model to the database.
     *
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = []): bool
    {
        if ($this->account->domains()->doesntExist()) {
            $this->is_default = true;
        }

        // Save
        return parent::save($options);
    }
}
