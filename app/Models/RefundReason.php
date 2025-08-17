<?php

namespace Modules\Refund\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Modules\Ecommerce\Traits\TranslationTrait;

class RefundReason extends Model
{
    use HasUuids;
    use Sluggable;
    use TranslationTrait;

    protected $table = 'refund_reasons';

    public $guarded = [];

    protected $appends = ['translated_languages'];

    /**
     * Return the sluggable configuration array for this model.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function scopeWithUniqueSlugConstraints(Builder $query, Model $model): Builder
    {
        return $query->where('language', $model->language);
    }
}
