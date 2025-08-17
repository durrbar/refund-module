<?php

namespace Modules\Refund\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Ecommerce\Traits\TranslationTrait;
use Modules\Vendor\Models\Shop;

class RefundPolicy extends Model
{
    use HasUuids;
    use Sluggable;
    use SoftDeletes;
    use TranslationTrait;

    protected $table = 'refund_policies';

    public $guarded = [];

    protected $appends = ['translated_languages'];

    /**
     * Return the sluggable configuration array for this model.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    public function scopeWithUniqueSlugConstraints(Builder $query, Model $model): Builder
    {
        return $query->where('language', $model->language);
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    /**
     * @return BelongsTo
     */
    public function refunds(): HasMany
    {
        return $this->hasMany(Refund::class);
    }
}
