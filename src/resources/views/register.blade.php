@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">

@section('content')
    <!-- 商品登録フォーム -->
    <h2>商品登録</h2>

    <form action="/products" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- 商品名 -->
        <div>
            <label for="name">商品名 <span>必須</span></label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="商品名を入力">
            @error('name')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <!-- 値段 -->
        <div>
            <label for="price">値段 <span>必須</span></label>
            <input type="text" id="price" name="price" value="{{ old('price') }}" placeholder="値段を入力">
            @error('price')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <!-- 商品画像 -->
        <div>
            <img id="image-preview" src="#" alt="選択した画像のプレビュー">
            <label for="image" class="file-upload-button">ファイルを選択 <span>必須</span></label>
            <input type="file" id="image" name="image">
            @error('image')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <!-- 季節 -->
        <div>
            <label for="season">季節 <span>必須</span> <span>複数選択可</span></label>
            <div>
                <input type="checkbox" id="spring" name="season[]" value="春" {{ in_array('春', old('season', [])) ? 'checked' : '' }}>
                <label for="spring">春</label>
            </div>
            <div>
                <input type="checkbox" id="summer" name="season[]" value="夏" {{ in_array('夏', old('season', [])) ? 'checked' : '' }}>
                <label for="summer">夏</label>
            </div>
            <div>
                <input type="checkbox" id="autumn" name="season[]" value="秋" {{ in_array('秋', old('season', [])) ? 'checked' : '' }}>
                <label for="autumn">秋</label>
            </div>
            <div>
                <input type="checkbox" id="winter" name="season[]" value="冬" {{ in_array('冬', old('season', [])) ? 'checked' : '' }}>
                <label for="winter">冬</label>
            </div>
            @error('season')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <!-- 商品説明 -->
        <div>
            <label for="description">商品説明 <span>必須</span></label>
            <textarea id="description" name="description" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
            @error('description')
                <p class="error-message">{{ $message }}</p>
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