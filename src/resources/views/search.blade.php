@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/search.css') }}">
@endsection

@section('content')
    <h1>"{{ $query }}" の検索結果</h1>

    <!-- 検索フォーム -->
    <form action="/products/search" method="GET" class="search-form">
    @csrf
        <input type="text" name="query" placeholder="商品名で検索" value="{{ request('query') }}">
        <button type="submit">検索</button>
    </form>

    <!-- 並び替え機能 -->
        <input type="hidden" name="query" value="{{ request('query') }}">
        <h2>価格順で表示</h2>
        <select name="sort" onchange="this.form.submit()">
            <option value="">価格で並び替え</option>
            <option value="high" {{ request('sort') == 'high' ? 'selected' : '' }}>高い順に表示</option>
            <option value="low" {{ request('sort') == 'low' ? 'selected' : '' }}>低い順に表示</option>
        </select>

    <!-- 商品カードリスト -->
    <div class="product-list">
        @foreach ($products as $product)
            <div class="product-card">
                @if ($product->image)
                    <img src="{{ asset('storage/images/' . $product->image) }}" alt="商品画像">
                @endif
                <a href="{{ url('/products', $product->id) }}">
                    <h2>{{ $product->name }}</h2>
                    <p>¥{{ number_format($product->price) }}</p>
                </a>
            </div>
        @endforeach
    </div>

    <!-- ページネーション -->
    <div class="pagination-container">
        {{ $products->appends(request()->input())->links() }}
    </div>
@endsection