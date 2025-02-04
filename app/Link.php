<?php
namespace App;

use App\Supports\Bijective;
use App\Events\LinkUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Relation;

class Link extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'link',
        'source',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'domain_id',
        'account_id',
        'deleted_at',
        'created_by_id',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'short_link',
    ];

    /**
     * Get the domain that belongs to the link.
     */
    public function domain(): Relation
    {
        return $this->belongsTo(Domain::class);
    }

    /**
     * Get the account that owns the link.
     */
    public function account(): Relation
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the account that owns the link.
     */
    public function createdBy(): Relation
    {
        return $this->belongsTo(User::class);
    }

    /**
     * New instance from long link
     *
     * @param string $longLink
     * @param string $source
     * @return self
     */
    public static function newInstanceFromLongLink(string $longLink, $source): self
    {
        return (new static)->newInstance(['link' => $longLink, 'source' => $source]);
    }

    /**
     * Scope a query to only include link of a given hash.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $hash
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHash($query, $hash)
    {
        return $query->where('hash', $hash);
    }

    /**
     * Scope a query to only include link of a given hash.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $hash
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDomain($query, Domain $domain)
    {
        return $query->where('domain_id', $domain->id);
    }

    /**
     * Save the model to the database.
     *
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = []): bool
    {
        if ($this->isDirty('link')) {
            $this->hash = md5($this->link);
            $this->title = getTitle($this->link);
            $this->hostname = getHost($this->link);
        }

        if (!$this->uuid) {
            $this->uuid = uuid();
        }

        // Save
        $save = parent::save($options);

        if ($this->wasRecentlyCreated and null === $this->slug) {
            $this->slug = Bijective::encode($this->id);
            $this->save();
        }

        return $save;
    }

    /**
     * Get short link
     *
     * @return array
     */
    public function getShortLinkAttribute(): ? array
    {
        return [
            "full" => "{$this->domain->fullDomainName}{$this->slug}",
            'link' => "{$this->domain->name}/{$this->slug}",
        ];
    }
}
