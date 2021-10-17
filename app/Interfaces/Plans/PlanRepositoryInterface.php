<?php

namespace App\Interfaces\Plans;

interface PlanRepositoryInterface
{
    public function index();

    public function show($plan);

    public function store($planCreateRequest);

    public function update($planUpdateRequest, $plan);

    public function delete($plan);
}
