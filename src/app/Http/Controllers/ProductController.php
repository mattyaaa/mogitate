<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Season;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // 商品一覧表示
    public function index(Request $request)
    {
        $sort = $request->input('sort');

        $products = Product::when($sort, function($queryBuilder) use ($sort) {
            if ($sort == 'high') {
                return $queryBuilder->orderBy('price', 'desc');
            } elseif ($sort == 'low') {
                return $queryBuilder->orderBy('price', 'asc');
            }
        })->paginate(6);

        return view('index', compact('products', 'sort'));
    }

    // 商品検索結果表示
    public function search(Request $request)
    {
        $query = $request->input('query');
        $sort = $request->input('sort');

        $products = Product::when($query, function($queryBuilder) use ($query) {
            return $queryBuilder->where('name', 'like', '%' . $query . '%');
        })
        ->when($sort, function($queryBuilder) use ($sort) {
            if ($sort == 'high') {
                return $queryBuilder->orderBy('price', 'desc');
            } elseif ($sort == 'low') {
                return $queryBuilder->orderBy('price', 'asc');
            }
        })
        ->paginate(6);

        return view('search', compact('products', 'query', 'sort'));
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

        // シーズンのIDを取得して関連付け
        $seasonIds = Season::whereIn('name', $request->season)->pluck('id');
        $product->seasons()->attach($seasonIds);

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
        $product = Product::findOrFail($productId);

        // バリデーション済みのデータを取得
        $validated = $request->validated();

        // 画像の更新処理
        if ($request->hasFile('image')) {
            // 古い画像を削除（必要に応じて）
            if ($product->image) {
                Storage::delete('public/images/' . $product->image);
            }

            // 新しい画像を保存
            $path = $request->file('image')->store('public/images');
            $validated['image'] = basename($path);
        } else {
            // 画像がアップロードされていない場合、既存の画像を使用
            $validated['image'] = $product->image;
        }

        // 商品情報の更新
        $product->update($validated);

        // シーズンのIDを取得して関連付け
        $seasonIds = Season::whereIn('name', $validated['season'])->pluck('id');
        $product->seasons()->sync($seasonIds);

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
