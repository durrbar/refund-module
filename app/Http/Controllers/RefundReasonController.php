<?php

namespace Modules\Refund\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Core\Exceptions\DurrbarException;
use Modules\Core\Http\Controllers\CoreController;
use Modules\Refund\Http\Requests\RefundReasonCreateRequest;
use Modules\Refund\Http\Requests\RefundReasonUpdateRequest;
use Modules\Refund\Repositories\RefundReasonRepository;
use Prettus\Validator\Exceptions\ValidatorException;

class RefundReasonController extends CoreController
{
    public $repository;

    public function __construct(RefundReasonRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection|Tag[]
     */
    public function index(Request $request)
    {
        $limit = $request->limit ? $request->limit : 15;

        return $this->fetchRefundReasons($request)->paginate($limit);
    }

    public function fetchRefundReasons(Request $request)
    {
        $language = $request->language ?? DEFAULT_LANGUAGE;

        return $this->repository->where('language', $language);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return mixed
     *
     * @throws ValidatorException
     */
    public function store(RefundReasonCreateRequest $request)
    {
        try {
            if ($this->repository->hasPermission($request->user(), $request->shop_id)) {
                return $this->repository->storeRefundReason($request);
            }
            throw new AuthorizationException(NOT_AUTHORIZED);
        } catch (DurrbarException $e) {
            throw new DurrbarException(COULD_NOT_CREATE_THE_RESOURCE);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(Request $request, $params)
    {

        try {
            $language = $request->language ?? DEFAULT_LANGUAGE;
            if (is_numeric($params)) {
                $params = (int) $params;

                return $this->repository->where('id', $params)->firstOrFail();
            }

            return $this->repository->where('slug', $params)->firstOrFail();
        } catch (DurrbarException $th) {
            throw new DurrbarException(COULD_NOT_CREATE_THE_RESOURCE);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(RefundReasonUpdateRequest $request, $id)
    {
        try {
            $request['id'] = $id;

            return $this->refundReasonUpdate($request);
        } catch (DurrbarException $th) {
            throw new DurrbarException(COULD_NOT_CREATE_THE_RESOURCE);
        }
    }

    public function refundReasonUpdate(Request $request)
    {
        try {
            $item = $this->repository->findOrFail($request->id);

            return $this->repository->updateRefundReason($request, $item);
        } catch (DurrbarException $th) {
            throw new DurrbarException(COULD_NOT_CREATE_THE_RESOURCE);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $request->merge(['id' => $id]);

        return $this->deleteRefundReason($request);
    }

    public function deleteRefundReason(Request $request)
    {
        try {
            $refundReason = $this->repository->findOrFail($request->id);
            $refundReason->delete();

            return $refundReason;
        } catch (DurrbarException $th) {
            throw new DurrbarException(COULD_NOT_CREATE_THE_RESOURCE);
        }
    }
}
