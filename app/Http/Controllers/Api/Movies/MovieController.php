<?php

namespace App\Http\Controllers\Api\Movies;

use App\Http\Controllers\Controller;
use App\Http\Requests\Movies\MovieCreateRequest;
use App\Http\Requests\Movies\MovieUpdateRequest;
use App\Interfaces\Movies\MovieRepositoryInterface;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MovieController extends Controller
{
    private $movieInterface;

    public function __construct(MovieRepositoryInterface $movieInterface)
    {
        $this->movieInterface = $movieInterface;
    }

    public function index()
    {
        return $this->movieInterface->index();
    }

    public function store(MovieCreateRequest $movieCreateRequest)
    {
        return $this->movieInterface->store($movieCreateRequest);
    }

    public function show(Movie $movie)
    {
        return $this->movieInterface->show($movie);
    }

    public function update(MovieUpdateRequest $movieUpdateRequest, Movie $movie)
    {
        return $this->movieInterface->update($movieUpdateRequest, $movie);
    }

    public function destroy(Movie $movie)
    {
        return $this->movieInterface->delete($movie);
    }
}
