<?php

namespace App\Repositories\Reviews;

use App\Http\Resources\Reviews\ReviewResource;
use App\Interfaces\Reviews\ReviewRepositoryInterface;
use App\Models\Review;
use Exception;
use Illuminate\Support\Facades\DB;

class ReviewRepository implements ReviewRepositoryInterface
{
    protected $reviewModel;

    public function __construct(Review $reviewModel)
    {
        $this->reviewModel = $reviewModel;
    }

    public function store($reviewCreateRequest)
    {
        DB::beginTransaction();
        try {
            $review = $this->reviewModel->query()->create([
                'review' => $reviewCreateRequest->review,
                'rate' => (int)$reviewCreateRequest->rate,
                'movie_id' => $reviewCreateRequest->movie_id,
                'user_id' => $reviewCreateRequest->user_id,
                'approved' => (bool)$reviewCreateRequest->approved
            ]);
            DB::commit();
            return ReviewResource::make($review)
                ->additional(['status' => 'Success'])
                ->response()
                ->setStatusCode(201);
        } catch (Exception $e) {
            return response()->json(['status' => 'Failed', 'error' => $e->getMessage()], 416);
        }
    }

    public function update($reviewUpdateRequest, $review)
    {
        DB::beginTransaction();
        try {
            if (auth()->id() !== $review->user_id) {
                return response()->json(['status' => 'Failed', 'message' => 'Unauthorized'], 403);
            }
            $review->update([
                'review' => $reviewUpdateRequest->review,
                'rate' => (int)$reviewUpdateRequest->rate,
                'movie_id' => $reviewUpdateRequest->movie_id,
                'user_id' => $reviewUpdateRequest->user_id,
                'approved' => (bool)$reviewUpdateRequest->approved
            ]);
            DB::commit();
            return ReviewResource::make($review)
                ->additional(['status' => 'Success'])
                ->response()
                ->setStatusCode(201);
        } catch (Exception $e) {
            return response()->json(['status' => 'Failed', 'error' => $e->getMessage()], 416);
        }
    }

    public function delete($review)
    {
        if (auth()->id() !== $review->user_id) {
            return response()->json(['status' => 'Failed', 'message' => 'Unauthorized'], 403);
        }
        $review->delete();
        return response()->noContent();
    }

    public function show($review)
    {
        return ReviewResource::make($review)
            ->additional(['status' => 'Success'])
            ->response()
            ->setStatusCode(200);
    }
}
