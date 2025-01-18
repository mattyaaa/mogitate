@extends('layouts.app')

@section('content')
    <!-- 商品登録フォーム -->
    <h2>商品登録</h2>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- 商品名 -->
        <div>
            <label for="name">商品名 <span>必須</span></label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="商品名を入力">
            @error('name')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <!-- 値段 -->
        <div>
            <label for="price">値段 <span>必須</span></label>
            <input type="text" id="price" name="price" value="{{ old('price') }}" placeholder="値段を入力">
            @error('price')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <!-- 商品画像 -->
        <div>
            <label for="image" class="file-upload-button">ファイルを選択 <span>必須</span></label>
            <input type="file" id="image" name="image">
            @error('image')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <!-- 季節 -->
        <div>
            <label for="season">季節 <span>必須</span> <span>複数選択可</span></label>
            <select id="season" name="season[]" multiple>
                <option value="春" {{ in_array('春', old('season', [])) ? 'selected' : '' }}>春</option>
                <option value="夏" {{ in_array('夏', old('season', [])) ? 'selected' : '' }}>夏</option>
                <option value="秋" {{ in_array('秋', old('season', [])) ? 'selected' : '' }}>秋</option>
                <option value="冬" {{ in_array('冬', old('season', [])) ? 'selected' : '' }}>冬</option>
            </select>
            @error('season')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <!-- 商品説明 -->
        <div>
            <label for="description">商品説明 <span>必須</span></label>
            <textarea id="description" name="description" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
            @error('description')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <!-- ボタンの配置 -->
        <div>
            <a href="/products">戻る</a>
            <button type="submit">登録</button>
        </div>
    </form>

    <script>
        document.querySelector('.file-upload-button').addEventListener('click', function() {
            document.querySelector('#image').click();
        });
    </script>
@endsection