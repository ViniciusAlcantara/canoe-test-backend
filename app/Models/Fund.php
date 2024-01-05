<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property string id
 * @property string name
 * @property int start_year
 * @property string fund_manager_id
 * @property datetime created_at
 * @property datetime updated_at
 */
class Fund extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'funds';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The type of the primary key associated with the table.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public function fundManager(): BelongsTo
    {
        return $this->belongsTo(FundManager::class);
    }

    public function alias(): HasMany
    {
        return $this->hasMany(Alias::class);
    }

    public function investors(): MorphToMany
    {
        return $this->morphToMany(Company::class, 'company_invested_funds');
    }
}
