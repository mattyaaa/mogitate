<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Season;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    // 商品一覧表示
    public function index()
    {
        $products = Product::paginate(6);
        return view('index', compact('products'));
    }

    // 商品検索結果表示
    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'like', "%{$query}%")->paginate(6);
        return view('search', compact('products'));
    }

    // 商品登録画面表示
    public function create()
    {
        $seasons = Season::all();
        return view('register', compact('seasons'));
    }

    // 商品登録処理
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/images');
            $validated['image'] = basename($path);
        }

        $product = Product::create($validated);
        $product->seasons()->attach($request->season);

        return redirect('/products');
    }

    // 商品詳細表示（編集フォーム）
    public function edit($productId)
    {
        $product = Product::findOrFail($productId);
        $seasons = Season::all();
        return view('edit', compact('product', 'seasons'));
    }

    // 商品更新処理
    public function update(UpdateProductRequest $request, $productId)
    {
        $validated = $request->validated();
        $product = Product::findOrFail($productId);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/images');
            $validated['image'] = basename($path);
        }

        $product->update($validated);
        $product->seasons()->sync($request->season);

        return redirect('/products');
    }

    // 商品削除処理
    public function destroy($productId)
    {
        $product = Product::findOrFail($productId);
        $product->delete();

        return redirect('/products');
    }
}
