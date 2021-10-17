<?php

namespace App\Http\Controllers\Api\Plans;

use App\Http\Controllers\Controller;
use App\Http\Requests\Plans\PlanCreateRequest;
use App\Http\Requests\Plans\PlanUpdateRequest;
use App\Interfaces\Plans\PlanRepositoryInterface;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlanController extends Controller
{
    private $planInterface;


    public function __construct(PlanRepositoryInterface $planInterface)
    {
        $this->planInterface = $planInterface;
    }

    public function index()
    {
        return $this->planInterface->index();
    }

    public function store(PlanCreateRequest $planCreateRequest)
    {
        return $this->planInterface->store($planCreateRequest);
    }

    public function show(Plan $plan)
    {
        return $this->planInterface->show($plan);
    }

    public function update(PlanUpdateRequest $planUpdateRequest, Plan $plan)
    {
        return $this->planInterface->update($planUpdateRequest, $plan);
    }

    public function destroy(Plan $plan)
    {
        return $this->planInterface->delete($plan);
    }
}
