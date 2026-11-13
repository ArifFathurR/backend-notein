<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $category = $request->user()
            ->categories()
            ->get();

        return response()->json([
            'message' => 'Berhasil menampilkan data',
            'data' => $category,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        $category = Category::create([
            'name' => $request->validated()['name'],
            'id_user' => $request->user()->id,
        ]);

        return response()->json([
            'message' => "Berhasil tambah kategori",
            'data' => $category
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, string $id)
    {
        $category = Category::where('id_user', $request->user()->id)
            ->findOrFail($id);

        $category->update($request->validated());

        return response()->json([
            'message' => 'Berhasil edit data kategori',
            'data' => $category->fresh(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        $category = Category::destroy($id);

        $data = $request->user()
            ->categories()
            ->get();

        return response()->json([
            'message' => "Berhasil Hapus data",
            'data' => $data
        ]);
    }
}
