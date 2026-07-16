<div class="flex items-center gap-2">
    <button 
        wire:click="toggle"
        class="flex items-center gap-1 text-[10px] font-mono text-zinc-500 hover:text-pink-500 transition-colors"
    >
        <span>{{ $isLiked ? '❤️' : '🤍' }}</span>
        <span>{{ $likesCount }}</span>
    </button>
</div>
