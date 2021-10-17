<?php

namespace App\Repositories\Categories;

use App\Http\Resources\Categories\CategoryResource;
use App\Interfaces\Categories\CategoryRepositoryInterface;
use App\Models\Category;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryRepository implements CategoryRepositoryInterface
{
    protected $categoryModel;

    /**
     * @param Category $categoryModel
     */
    public function __construct(Category $categoryModel)
    {
        $this->categoryModel = $categoryModel;
    }

    public function index()
    {
        $categories = $this->categoryModel->query()->whereNull('parent_id')->get();
        return CategoryResource::collection($categories)
            ->additional(['status' => 'Success'])
            ->response()
            ->setStatusCode(200);
    }

    public function show($category)
    {
        return (new CategoryResource($category))
            ->additional(['status' => 'Success'])
            ->response()
            ->setStatusCode(200);
    }

    public function create($categoryRequest)
    {
        DB::beginTransaction();
        try {
            $category = $this->categoryModel->query()->create([
                'name' => $categoryRequest->name,
                'slug' => Str::slug($categoryRequest->slug),
                'parent_id' => $categoryRequest->parent_id,
            ]);
            DB::commit();
            return (new CategoryResource($category))
                ->additional(['status' => 'Success'])
                ->response()
                ->setStatusCode(201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'Failed', 'error' => $e->getMessage()], 406);
        }
    }

    public function update($categoryRequest, $category)
    {
        DB::beginTransaction();
        try {
            $category->update([
                'name' => $categoryRequest->name,
                'slug' => Str::slug($categoryRequest->slug),
                'parent_id' => $categoryRequest->parent_id,
            ]);
            DB::commit();
            return (new CategoryResource($category))
                ->additional(['status' => 'Success'])
                ->response()
                ->setStatusCode(201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'Failed', 'error' => $e->getMessage()], 406);
        }
    }

    public function delete($category)
    {
        DB::beginTransaction();
        try {
            $category->delete();
            DB::commit();
            return response()->noContent();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'Failed', 'error' => $e->getMessage()], 406);
        }
    }
}
