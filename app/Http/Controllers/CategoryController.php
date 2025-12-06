<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Membuat kategori baru milik user.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:160'],
            'color' => ['nullable', 'string', 'max:20'],
        ]);

        $description = ($data['description'] ?? null) === 'Short description...' ? null : ($data['description'] ?? null);

        Category::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'name' => $data['name'],
            ],
            [
                'description' => $description,
                'color' => $data['color'] ?: '#4f46e5',
                'is_system' => false,
            ]
        );

        return back()->with('success', 'Category added.');
    }

    /**
     * Update kategori milik user tanpa pindah halaman.
     */
    public function update(Request $request, Category $category)
    {
        if ($category->user_id !== Auth::id() || $category->is_system) {
            abort(403);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:160'],
            'color' => ['nullable', 'string', 'max:20'],
        ]);

        $description = ($data['description'] ?? null) === 'Short description...' ? null : ($data['description'] ?? null);

        $category->update([
            'name' => $data['name'],
            'description' => $description,
            'color' => $data['color'] ?: $category->color,
        ]);

        return back()->with('success', 'Category updated.');
    }

    /**
     * Menghapus kategori buatan user (bukan bawaan sistem).
     */
    public function destroy(Category $category)
    {
        if ($category->is_system || $category->user_id !== Auth::id()) {
            abort(403);
        }

        $category->delete();

        return back()->with('success', 'Category deleted.');
    }
}
