<?php

namespace App\Repositories\Plans;

use App\Http\Resources\Plans\PlanResource;
use App\Interfaces\Plans\PlanRepositoryInterface;
use App\Models\Plan;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PlanRepository implements PlanRepositoryInterface
{
    protected $planModel;

    public function __construct(Plan $planModel)
    {
        $this->planModel = $planModel;
    }

    public function index()
    {
        $plans = $this->planModel->query()->get();
        return PlanResource::collection($plans)
            ->additional(['status' => 'Success'])
            ->response()
            ->setStatusCode(200);
    }

    public function show($plan)
    {
        return (new PlanResource($plan))
            ->additional(['status' => 'Success'])
            ->response()
            ->setStatusCode(200);
    }

    public function store($planCreateRequest)
    {
        DB::beginTransaction();
        try {
            $plan = $this->planModel->query()->create([
                'name' => $planCreateRequest->name,
                'slug' => Str::slug($planCreateRequest->slug),
                'price' => $planCreateRequest->price,
                'duration_months' => $planCreateRequest->duration_months,
            ]);
            DB::commit();
            return PlanResource::make($plan)
                ->additional(['status' => 'Success'])
                ->response()
                ->setStatusCode(201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'Failed', 'error' => $e->getMessage()], $e->getCode());
        }
    }

    public function update($planUpdateRequest, $plan)
    {
        DB::beginTransaction();
        try {
            $plan->update([
                'name' => $planUpdateRequest->name,
                'slug' => Str::slug($planUpdateRequest->slug),
                'price' => $planUpdateRequest->price,
                'duration_months' => $planUpdateRequest->duration_months,
            ]);
            DB::commit();
            return PlanResource::make($plan)
                ->additional(['status' => 'Success'])
                ->response()
                ->setStatusCode(201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'Failed', 'error' => $e->getMessage()], $e->getCode());
        }
    }

    public function delete($plan)
    {
        DB::beginTransaction();
        try {
            $plan->delete();
            DB::commit();
            return response()->noContent();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'Failed', 'error' => $e->getMessage()], $e->getCode());
        }
    }
}
