<?php

namespace App\Http\Controllers\Api\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\CategoryCreateRequest;
use App\Http\Requests\Categories\CategoryUpdateRequest;
use App\Interfaces\Categories\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    private $categoryInterface;

    /**
     * @param CategoryRepositoryInterface $categoryInterface
     */
    public function __construct(CategoryRepositoryInterface $categoryInterface)
    {
        $this->categoryInterface = $categoryInterface;
    }

    public function index()
    {
        return $this->categoryInterface->index();
    }

    public function store(CategoryCreateRequest $categoryCreateRequest)
    {
        return $this->categoryInterface->create($categoryCreateRequest);
    }

    public function show(Category $category)
    {
        return $this->categoryInterface->show($category);
    }

    public function update(CategoryUpdateRequest $categoryUpdateRequest, Category $category)
    {
        return $this->categoryInterface->update($categoryUpdateRequest, $category);
    }

    public function destroy(Category $category)
    {
        return $this->categoryInterface->delete($category);
    }
}
