@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <h1>商品一覧</h1>

    <!-- 検索フォーム -->
    <form action="/products/search" method="GET" class="search-form">
        <input type="text" name="query" placeholder="商品名で検索" value="{{ request('query') }}">
        <button type="submit">検索</button>
    </form>

    <!-- 並び替え機能 -->
    <form action="/products" method="GET" style="margin-top: 10px;">
        <input type="hidden" name="query" value="{{ request('query') }}">
        <h2>価格順で表示</h2>
        <select name="sort" onchange="this.form.submit()">
            <option value="">価格で並び替え</option>
            <option value="high" {{ request('sort') == 'high' ? 'selected' : '' }}>高い順に表示</option>
            <option value="low" {{ request('sort') == 'low' ? 'selected' : '' }}>低い順に表示</option>
        </select>
    </form>

    <!-- 並び替えタグ -->
    @if (request('sort'))
        <div>
            <span>{{ request('sort') == 'high' ? '高い順' : '低い順' }}</span>
            <a href="/products?query={{ request('query') }}">×</a>
        </div>
    @endif

    <!-- 商品カードリスト -->
    <div class="product-list">
        @foreach ($products as $product)
            <div class="product-card">
                <a href="{{ url('/products', $product->id) }}">
                    <h2>{{ $product->name }}</h2>
                    <p>¥{{ $product->price }}</p>
                </a>
            </div>
        @endforeach
    </div>

    <!-- ページネーション -->
    <div class="pagination-container">
        {{ $products->appends(request()->input())->links() }}
    </div>

    <!-- 商品登録ページへのリンク -->
    <a href="/products/register" class="register-link">+商品を追加</a>
@endsection
