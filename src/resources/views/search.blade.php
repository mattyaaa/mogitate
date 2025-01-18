@extends('layouts.app')

@section('content')
    <h1>"{{ $query }}"の商品一覧</h1>

    <!-- 検索フォーム -->
    <form action="/products/search" method="GET">
        <input type="text" name="query" placeholder="商品名で検索" value="{{ old('query', $query) }}">
        <button type="submit">検索</button>
    </form>

    <!-- 並び替え機能 -->
    <form action="/products/search" method="GET" style="margin-top: 10px;">
        <input type="hidden" name="query" value="{{ $query }}">
        <h2>価格順で表示</h2>
        <select name="sort" onchange="this.form.submit()">
            <option value="">価格で並び替え</option>
            <option value="high" {{ $sort == 'high' ? 'selected' : '' }}>高い順に表示</option>
            <option value="low" {{ $sort == 'low' ? 'selected' : '' }}>低い順に表示</option>
        </select>
    </form>

    @if(!$products->isEmpty())
        <!-- 検索結果の表示 -->
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
    @endif
@endsection