<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Новая публикация - {{ config('app.name', 'GameApp') }}</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-zinc-950 text-zinc-100 min-h-screen flex flex-col justify-between selection:bg-red-600 selection:text-white">

@include('partials.header')

<main class="flex-grow max-w-4xl mx-auto px-6 py-12 w-full space-y-10 relative overflow-hidden">
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[500px] h-[500px] bg-red-600/5 blur-[120px] rounded-full pointer-events-none"></div>

    <div class="relative z-10 font-mono text-xs flex items-center justify-between">
        <a href="{{ route('posts.index') }}" class="text-zinc-500 hover:text-red-400 transition-colors uppercase tracking-wider">
            [ ← Вернуться к ленте ]
        </a>
        <span class="text-zinc-600 text-[10px] uppercase tracking-widest">// Режим создания</span>
    </div>

    <div class="relative z-10 border-b border-zinc-900 pb-6">
        <h1 class="text-2xl md:text-3xl font-extrabold font-mono text-zinc-100 uppercase tracking-wide">
            Создать материал
        </h1>
        <p class="text-xs text-zinc-500 font-mono mt-1 tracking-wider">
            // Заполните все обязательные поля для публикации
        </p>
    </div>

    @if($errors->any())
        <div class="relative z-10 p-4 bg-red-950/40 border border-red-900/50 text-red-400 rounded-sm font-mono text-xs space-y-1">
            <p class="font-bold uppercase tracking-wider">// Обнаружены ошибки:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST" class="relative z-10 space-y-8">
        @csrf

        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

        <div class="space-y-2">
            <label for="title" class="text-[10px] font-mono text-zinc-400 uppercase tracking-wider flex items-center gap-2">
                <span class="text-red-500">*</span> Заголовок материала
            </label>
            <input type="text"
                   name="title"
                   id="title"
                   value="{{ old('title') }}"
                   class="w-full bg-zinc-950 border border-zinc-800 rounded-sm p-3 text-sm text-zinc-100 placeholder-zinc-600 focus:outline-none focus:border-red-600 focus:ring-2 focus:ring-red-600/20 transition-all @error('title') border-red-600 @enderror"
                   placeholder="Введите заголовок поста..."
                   required
                   autofocus>
            @error('title')
            <span class="text-[10px] font-mono text-red-500">// Ошибка: {{ $message }}</span>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="category_id" class="text-[10px] font-mono text-zinc-400 uppercase tracking-wider flex items-center gap-2">
                <span class="text-red-500">*</span> Категория
            </label>
            <select name="category_id"
                    id="category_id"
                    class="w-full bg-zinc-950 border border-zinc-800 rounded-sm p-3 text-sm text-zinc-100 focus:outline-none focus:border-red-600 focus:ring-2 focus:ring-red-600/20 transition-all @error('category_id') border-red-600 @enderror"
                    required>
                <option value="" class="bg-zinc-950" disabled {{ old('category_id') ? '' : 'selected' }}>-- Выберите категорию --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" class="bg-zinc-950"
                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
            <span class="text-[10px] font-mono text-red-500">// Ошибка: {{ $message }}</span>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="description" class="text-[10px] font-mono text-zinc-400 uppercase tracking-wider flex items-center gap-2">
                Краткое описание
            </label>
            <textarea name="description"
                      id="description"
                      rows="3"
                      class="w-full bg-zinc-950 border border-zinc-800 rounded-sm p-3 text-sm text-zinc-100 placeholder-zinc-600 focus:outline-none focus:border-red-600 focus:ring-2 focus:ring-red-600/20 resize-none transition-all @error('description') border-red-600 @enderror"
                      placeholder="Краткое описание поста (до 255 символов)...">{{ old('description') }}</textarea>
            <div class="flex justify-between">
                <span class="text-[10px] font-mono text-zinc-600">// Макс. 255 символов</span>
                <span class="text-[10px] font-mono text-zinc-600" id="description-count">0/255</span>
            </div>
            @error('description')
            <span class="text-[10px] font-mono text-red-500">// Ошибка: {{ $message }}</span>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="body" class="text-[10px] font-mono text-zinc-400 uppercase tracking-wider flex items-center gap-2">
                <span class="text-red-500">*</span> Полный текст
            </label>
            <textarea name="body"
                      id="body"
                      rows="12"
                      class="w-full bg-zinc-950 border border-zinc-800 rounded-sm p-3 text-sm text-zinc-100 placeholder-zinc-600 focus:outline-none focus:border-red-600 focus:ring-2 focus:ring-red-600/20 resize-none transition-all font-sans leading-relaxed @error('body') border-red-600 @enderror"
                      placeholder="Напишите полный текст поста..."
                      required>{{ old('body') }}</textarea>
            @error('body')
            <span class="text-[10px] font-mono text-red-500">// Ошибка: {{ $message }}</span>
            @enderror
        </div>

        <div class="space-y-2">
            <label class="text-[10px] font-mono text-zinc-400 uppercase tracking-wider">
                Теги публикации
            </label>
            <div class="p-4 bg-zinc-950 border border-zinc-800 rounded-sm">
                <div class="flex flex-wrap gap-3">
                    @foreach($tags as $tag)
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox"
                                   name="tags[]"
                                   value="{{ $tag->id }}"
                                   class="w-4 h-4 rounded border-zinc-700 bg-zinc-900 text-red-600 focus:ring-red-600 focus:ring-offset-0 focus:ring-2 transition-all"
                                {{ is_array(old('tags')) && in_array($tag->id, old('tags')) ? 'checked' : '' }}>
                            <span class="text-xs font-mono text-zinc-400 group-hover:text-zinc-200 transition-colors">
                                #{{ $tag->name }}
                            </span>
                        </label>
                    @endforeach
                </div>
                @if($tags->isEmpty())
                    <p class="text-xs text-zinc-600 font-mono">// Теги не созданы. Создайте их в админ-панели.</p>
                @endif
            </div>
            @error('tags')
            <span class="text-[10px] font-mono text-red-500">// Ошибка: {{ $message }}</span>
            @enderror
            @error('tags.*')
            <span class="text-[10px] font-mono text-red-500">// Ошибка: {{ $message }}</span>
            @enderror
        </div>

        <div class="border-t border-zinc-900 pt-6 flex flex-wrap items-center justify-between gap-4">
            <a href="{{ route('posts.index') }}"
               class="text-xs font-mono text-zinc-500 hover:text-zinc-300 transition-colors uppercase tracking-wider">
                [ Отмена ]
            </a>

            <button type="submit"
                    class="px-6 py-2.5 bg-red-700 hover:bg-red-600 text-white font-mono uppercase font-bold text-xs tracking-wider rounded-sm shadow-md shadow-red-950/60 transition-all active:scale-[0.98]">
                [ Опубликовать ]
            </button>
        </div>
    </form>

</main>

@include('partials.footer')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const descriptionInput = document.getElementById('description');
        const descriptionCount = document.getElementById('description-count');

        if (descriptionInput && descriptionCount) {
            descriptionInput.addEventListener('input', function() {
                const length = this.value.length;
                descriptionCount.textContent = length + '/255';
                descriptionCount.style.color = length > 255 ? '#ef4444' : '#52525b';
            });
        }
    });
</script>

</body>
</html>
