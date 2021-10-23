<?php

namespace App\Http\Controllers\Api\Reviews;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reviews\ReviewCreateRequest;
use App\Http\Requests\Reviews\ReviewUpdateRequest;
use App\Interfaces\Reviews\ReviewRepositoryInterface;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReviewController extends Controller
{
    private $reviewInterface;

    public function __construct(ReviewRepositoryInterface $reviewInterface)
    {
        $this->reviewInterface = $reviewInterface;
    }

    public function store(ReviewCreateRequest $reviewCreateRequest)
    {
        $this->reviewInterface->store($reviewCreateRequest);
    }

    public function show(Review $review)
    {
        $this->reviewInterface->show($review);
    }

    public function update(ReviewUpdateRequest $reviewUpdateRequest, Review $review)
    {
        $this->reviewInterface->update($reviewUpdateRequest, $review);
    }

    public function destroy(Review $review)
    {
        $this->reviewInterface->delete($review);
    }
}
