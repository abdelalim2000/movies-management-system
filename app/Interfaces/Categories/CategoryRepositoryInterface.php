<?php

namespace App\Interfaces\Categories;

interface CategoryRepositoryInterface
{
    public function index();

    public function show($category);

    public function create($categoryRequest);

    public function update($categoryRequest, $category);

    public function delete($category);
}
