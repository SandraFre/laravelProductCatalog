<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        //SELECT * FROM categories LIMITS 0, 15
        /** @var Collection $categories */
        $categories = Category::query()->paginate();

        return view('category.category-list', [
            'list' => $categories,
        ]);
    }

    public function create(): View
    {
        return view('category.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->only('title');

        Category::query()->create($data);

        return redirect()->route('categories.index');
    }

    public function edit(int $id): View
    {
        //SELECT * FROM categories WHERE id = ?
        $category = Category::query()->find($id);

        return view('category.edit', ['category' => $category]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $data = $request->only('title');

        Category::query()
            ->where('id', '=', $id)
            ->update($data);

        return redirect()->route('categories.index');
    }

    public function destroy(int $id): RedirectResponse
    {
        //DELETE FROM categories WHERE id = ?
        Category::query()
            ->where('id', '=', $id)
            ->delete();

        return redirect()->route('categories.index');
    }
}
