<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\JsonResponse;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $categories = Category::latest()->paginate(5)->through(fn ($cat) => new CategoryResource($cat));
        // $categories = CategoryResource::collection($categories)->response()->getData(true);
        return response()->json([
            'message' => "Categories listed successfully",
            'data' => $categories,
            'status' => 200
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        $category = Category::create($request->validated());
        return response()->json([
            'message' => "Category Created successfully",
            'data' => $category,
            'status' => 200
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $category): JsonResponse
    {
        try {
            $category = Category::findorFail($category);
            // echo $category;
            return response()->json([
                'data' => new CategoryResource($category),
                'status' => 200
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Category was not found ",
                'status' => 404
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $category): JsonResponse
    {
        try {
            $category = Category::find($category);

            $category->update([
                'title' => $request->title,
            ]);

            return response()->json([
                'message' => "Category Updated successfully",
                'data' => $category,
                'status' => 200
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "No Category with this Id was found ",
                'status' => 404
            ]);
        };
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): JsonResponse
    {
        $category->delete();
        return response()->json([
            'message' => "Category delete successfully",
            'data' => $category,
            'status' => 200
        ]);
    }
}
