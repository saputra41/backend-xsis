<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Movies;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MoviesController extends Controller
{

    public function index()
    {
        $movies = Movies::all();

        if ($movies->isEmpty()) {
            $response = [
                "response" => false,
                "message" => "Movie not found"
            ];
            return response()->json($response, 204);
        }

        $response = [
            "response" => true,
            "message" => "Movies found",
            "details" => $movies
        ];

        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => "required|string",
            "description" => "nullable|string",
            "rating" => "required|numeric",
            "image" => "nullable|string",
        ]);

        if ($validator->fails()) {
            $response =  [
                "response" => false,
                "message" => "Invalid request data",
                "details" => $validator->errors()
            ];
            return response()->json($response, 400);
        }

        $validatedData = $request->only(["title", "description", "rating"]);
        $validatedData["image"] = null;

        if ($request->has("image")) {
            $imageData = $request->input("image");

            $image = ImageHelper::saveBase64Image($imageData, "upload/images");

            if (!$image["response"]) {
                $response = [
                    "response" => false,
                    "message" => "Image cannot be created",
                    "details" => $image["message"]
                ];
                return response()->json($response, 400);
            }

            $validatedData["image"] = $image["message"];
        }

        try {
            DB::beginTransaction();

            $movie = Movies::create($validatedData);

            DB::commit();

            $response = [
                "response" => true,
                "message" => "Movie created successfully",
                "details" => $movie
            ];

            return response()->json($response, 201);
        } catch (Throwable $e) {
            DB::rollback();

            if (isset($validatedData["image"])) {
                ImageHelper::deleteImage("upload/images/" . $image);
            }

            $response = [
                "response" => true,
                "message" => $e->getMessage(),
            ];

            return response()->json($response, 500);
        }
    }

    public function show($id)
    {
        $movies = Movies::find($id);

        if (empty($movies)) {
            $response = [
                "response" => false,
                "message" => "Movie not found"
            ];
            return response()->json($response, 404);
        }

        $response = [
            "response" => true,
            "message" => "Movie found",
            "details" => $movies
        ];

        return response()->json($response, 200);
    }

    public function update(Request $request, $id = null)
    {
        $validator = Validator::make($request->all(), [
            "title" => "nullable|string",
            "description" => "nullable|string",
            "rating" => "nullable|numeric",
            "image" => "nullable|string",
        ]);

        if ($validator->fails()) {
            $response =  [
                "response" => false,
                "message" => "Invalid request data",
                "details" => $validator->errors()
            ];
            return response()->json($response, 400);
        }

        $validatedData = $request->only(["title", "description", "rating"]);
        $existingMovie = Movies::find($id);
        $oldMovie = $existingMovie;
        $validatedData["image"] = $existingMovie->image;


        if ($id && !$existingMovie) {
            $response = [
                "response" => false,
                "message" => "Movie not found",
            ];
            return response()->json($response, 404);
        }

        if ($request->has("image")) {
            $imageData = $request->input("image");

            $image = ImageHelper::saveBase64Image($imageData, "upload/images");

            if (!$image["response"]) {
                $response = [
                    "response" => false,
                    "message" => "Image cannot be created",
                    "details" => $image["message"]
                ];
                return response()->json($response, 400);
            }

            $validatedData["image"] = $image["message"];

            if (isset($oldMovie->image)) {
                ImageHelper::deleteImage("upload/images/" . $oldMovie->image);
            }
        }

        try {
            DB::beginTransaction();

            $existingMovie->update($validatedData);

            DB::commit();

            $response = [
                "response" => true,
                "message" =>  "Movie updated successfully",
                "details" => $existingMovie
            ];

            return response()->json($response,  200);
        } catch (Throwable $e) {
            DB::rollback();

            if ($validatedData["image"]) {
                ImageHelper::deleteImage("upload/images/" . $image);
            }

            $response = [
                "response" => false,
                "message" => $e->getMessage(),
            ];

            return response()->json($response, 500);
        }
    }

    public function destroy($id)
    {
        $movie = Movies::find($id);
        $oldMovie = $movie;

        if (empty($movie)) {
            $response = [
                "response" => false,
                "message" => "Movie not found"
            ];
            return response()->json($response, 404);
        }

        try {
            DB::beginTransaction();

            if (isset($movie->image)) {
                ImageHelper::deleteImage("upload/images/" . $movie->image);
            }

            $movie->delete();

            DB::commit();

            $response = [
                "response" => true,
                "message" => "Movie deleted successfully",
                "details" => $oldMovie
            ];

            return response()->json($response, 200);
        } catch (Throwable $e) {
            DB::rollback();

            $response = [
                "response" => true,
                "message" => "Movie deleted successfully",
                "details" => $e->getMessage(),
            ];

            return response()->json($response, 500);
        }
    }
}
