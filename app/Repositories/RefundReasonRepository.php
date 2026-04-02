<?php

declare(strict_types=1);

namespace Modules\Refund\Repositories;

use Illuminate\Http\Request;
use Modules\Core\Repositories\BaseRepository;
use Modules\Refund\Models\RefundReason;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

class RefundReasonRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name' => 'like',
    ];

    protected $dataArray = [
        'name',
        'slug',
        'language',
    ];

    public function boot(): void
    {
        try {
            $this->pushCriteria(app(RequestCriteria::class));
        } catch (RepositoryException $e) {
            //
        }
    }

    /**
     * Configure the Model
     **/
    public function model(): string
    {
        return RefundReason::class;
    }

    public function storeRefundReason(Request $request): RefundReason
    {
        $data = $request->only($this->dataArray);
        $data['slug'] = $this->makeSlug($request);
        $refundReason = $this->create($data);

        return $refundReason;
    }

    public function updateRefundReason(Request $request, RefundReason $item): RefundReason
    {
        $data = $request->only($this->dataArray);
        if (! empty($request->slug) && $request->slug !== $item['slug']) {
            $data['slug'] = $this->makeSlug($request);
        }
        $item->update($data);

        return $this->findOrFail($item->id);
    }
}
