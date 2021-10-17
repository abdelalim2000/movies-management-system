<?php

namespace App\Interfaces\Movies;

interface MovieRepositoryInterface
{
    public function index();

    public function show($movie);

    public function store($movieCreateRequest);

    public function update($movieUpdateRequest, $movie);

    public function delete($movie);
}
