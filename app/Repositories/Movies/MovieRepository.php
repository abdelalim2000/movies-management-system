<?php

namespace App\Repositories\Movies;

use App\Http\Resources\Movies\MovieResource;
use App\Interfaces\Movies\MovieRepositoryInterface;
use App\Models\Movie;
use App\traits\UploadImageTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MovieRepository implements MovieRepositoryInterface
{
    use UploadImageTrait;

    protected $movieModel;

    /**
     * @param Movie $movieModel
     */
    public function __construct(Movie $movieModel)
    {
        $this->movieModel = $movieModel;
    }

    public function index()
    {
        $movies = $this->movieModel->query()->with('category')->latest()->get();
        return MovieResource::collection($movies)
            ->additional(['status' => 'Success'])
            ->response()
            ->setStatusCode(200);
    }

    public function show($movie): MovieResource
    {
        $movie->load('category');
        return MovieResource::make($movie);
    }

    public function store($movieCreateRequest)
    {
        DB::beginTransaction();
        try {
            $movie = $this->movieModel->query()->create([
                'title' => $movieCreateRequest->title,
                'slug' => Str::slug($movieCreateRequest->slug),
                'description' => $movieCreateRequest->description,
                'category_id' => $movieCreateRequest->category_id,
                'paid' => (bool)$movieCreateRequest->paid
            ]);

            $this->uploadImage($movieCreateRequest, 'image', 'movies', 'movie_', 'upload_image', $movie->id, 'App\Models\Movie');
            DB::commit();
            return MovieResource::make($movie)
                ->additional(['status' => 'Success'])
                ->response()
                ->setStatusCode(201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'failed', 'error' => $e->getMessage()], 416);
        }
    }

    public function update($movieUpdateRequest, $movie)
    {
        DB::beginTransaction();
        try {
            $movie->update([
                'title' => $movieUpdateRequest->title,
                'slug' => Str::slug($movieUpdateRequest->slug),
                'description' => $movieUpdateRequest->description,
                'category_id' => $movieUpdateRequest->category_id,
                'paid' => (bool)$movieUpdateRequest->paid
            ]);
            if ($movie->image) {
                $this->deleteImage($movieUpdateRequest, 'image', $movie->image->path, $movie->image->id);
            }
            $this->uploadImage($movieUpdateRequest, 'image', 'movies', 'movie_', 'upload_image', $movie->id, 'App\Models\Movie');
            DB::commit();
            return MovieResource::make($movie)
                ->additional(['status' => 'Success'])
                ->response()
                ->setStatusCode(201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'failed', 'error' => $e->getMessage()], 416);
        }
    }

    public function delete($movie)
    {
        DB::beginTransaction();
        try {
            $this->imageDelete($movie->image->path, $movie->image->id);
            $movie->delete();
            DB::commit();
            return response()->noContent();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'failed', 'error' => $e->getMessage()], 416);
        }
    }
}
