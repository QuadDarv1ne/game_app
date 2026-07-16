<div class="w-full max-w-2xl mx-auto px-4 py-8 flex flex-col gap-6">
    <div class="space-y-1.5 border-b border-zinc-800/80 pb-5">
        <h1 class="text-xl font-extrabold font-mono uppercase tracking-wide text-zinc-100">
            {{ $heading ?? 'Настройки системы' }}
        </h1>
        <p class="text-xs font-sans text-zinc-400 font-medium">
            {{ $subheading ?? 'Управление параметрами вашей учетной записи и безопасности' }}
        </p>
    </div>

    <div class="w-full p-6 bg-zinc-900 border border-red-900/20 rounded-sm shadow-xl relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-24 h-24 bg-red-600/5 blur-xl rounded-full pointer-events-none"></div>

        <div class="relative z-10">
            {{ $slot }}
        </div>
    </div>
</div>
