<div>
    @if(auth()->check() && auth()->id() !== $user->id)
        <button 
            wire:click="toggle"
            class="flex items-center gap-2 px-4 py-2 text-xs font-mono uppercase tracking-wider transition-all rounded-sm {{ $isSubscribed ? 'bg-zinc-800 text-zinc-400 border-zinc-700 hover:bg-zinc-900' : 'bg-red-700 hover:bg-red-600 text-white border-red-600 shadow-md shadow-red-950/50' }} border"
        >
            <span>{{ $isSubscribed ? '✓' : '+' }}</span>
            <span>{{ $isSubscribed ? 'Подписка' : 'Подписаться' }}</span>
            <span class="text-zinc-400">({{ $subscribersCount }})</span>
        </button>
    @endif
</div>
