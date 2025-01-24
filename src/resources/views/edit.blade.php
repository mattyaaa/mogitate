@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endsection

@section('content')
    <!-- 商品一覧へのリンクと選択した商品名の表示 -->
    <div>
        <a href="/products">商品一覧</a> > {{ $product->name }}
    </div>

    <form action="/products/{{ $product->id }}/update" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- 商品画像 -->
        <div>
            <div>
                <img id="image-preview" src="#" alt="選択した画像" style="max-width: 200px; display: none;">
            </div>
            <div class="file-upload-button">
                <input type="file" id="image" name="image" >
            </div>
            @error('image')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="name">商品名</label>
            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" placeholder="商品名を入力">
            @error('name')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="price">値段</label>
            <input type="text" id="price" name="price" value="{{ old('price', $product->price) }}" placeholder="値段を入力">
            @error('price')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="season">季節</label>
            <div>
            <input type="checkbox" id="spring" name="season[]" value="春" {{ in_array('春', old('season', explode(',', $product->season))) ? 'checked' : '' }}>
            <label for="spring">春</label>
        </div>
        <div>
            <input type="checkbox" id="summer" name="season[]" value="夏" {{ in_array('夏', old('season', explode(',', $product->season))) ? 'checked' : '' }}>
            <label for="summer">夏</label>
        </div>
        <div>
            <input type="checkbox" id="autumn" name="season[]" value="秋" {{ in_array('秋', old('season', explode(',', $product->season))) ? 'checked' : '' }}>
            <label for="autumn">秋</label>
        </div>
        <div>
            <input type="checkbox" id="winter" name="season[]" value="冬" {{ in_array('冬', old('season', explode(',', $product->season))) ? 'checked' : '' }}>
            <label for="winter">冬</label>
        </div>
            @error('season')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description">商品説明</label>
            <textarea id="description" name="description" placeholder="商品の説明を入力">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">変更を保存</button>
    </form>

    <a href="/products">戻る</a>

    <form action="{{ url('/products/' . $product->id . '/delete') }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('本当に削除しますか？')">ゴミ箱ボタン</button>
    </form>

    <script>
        // 画像プレビュー機能
        document.getElementById('image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('image-preview');
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection