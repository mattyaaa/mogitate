@extends('layouts.app')

@section('content')
    <!-- 商品一覧へのリンクと選択した商品名の表示 -->
    <div>
        <a href="/products">商品一覧</a> ＞ {{ $product->name }}
    </div>

    <form action="/products/{{ $product->id }}/update" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- 商品画像 -->
        <div>
            @if ($product->image)
                <div>
                    <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像" style="max-width: 200px;">
                </div>
            @endif
            <div>
                <label for="image" class="file-upload-button">ファイルを選択</label>
                <input type="file" id="image" name="image" style="display: none;">
            </div>
            @error('image')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="name">商品名</label>
            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" placeholder="商品名を入力">
            @error('name')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="price">値段</label>
            <input type="text" id="price" name="price" value="{{ old('price', $product->price) }}" placeholder="値段を入力">
            @error('price')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="season">季節</label>
            <select id="season" name="season[]" multiple>
                <option value="春" {{ in_array('春', old('season', explode(',', $product->season))) ? 'selected' : '' }}>春</option>
                <option value="夏" {{ in_array('夏', old('season', explode(',', $product->season))) ? 'selected' : '' }}>夏</option>
                <option value="秋" {{ in_array('秋', old('season', explode(',', $product->season))) ? 'selected' : '' }}>秋</option>
                <option value="冬" {{ in_array('冬', old('season', explode(',', $product->season))) ? 'selected' : '' }}>冬</option>
            </select>
            @error('season')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description">商品説明</label>
            <textarea id="description" name="description" placeholder="商品の説明を入力">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">変更を保存</button>
    </form>

    <a href="/products">戻る</a>

    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('本当に削除しますか？')">ゴミ箱ボタン</button>
    </form>

    <script>
        document.querySelector('.file-upload-button').addEventListener('click', function() {
            document.querySelector('#image').click();
        });
    </script>
@endsection