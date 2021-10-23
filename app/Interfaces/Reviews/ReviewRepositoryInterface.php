<?php

namespace App\Interfaces\Reviews;

interface ReviewRepositoryInterface
{
    public function store($reviewCreateRequest);

    public function update($reviewUpdateRequest, $review);

    public function delete($review);

    public function show($review);
}
