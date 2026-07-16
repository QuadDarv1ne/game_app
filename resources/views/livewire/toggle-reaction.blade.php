<div class="flex items-center gap-3">
    <!-- Like button -->
    <button 
        wire:click="toggleLike"
        class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-mono uppercase tracking-wider transition-all rounded-sm {{ $isLiked ? 'bg-green-950/40 text-green-400 border-green-900/60' : 'bg-zinc-950 text-zinc-500 border-zinc-800 hover:text-green-400 hover:border-green-900/40' }} border"
    >
        <span class="text-sm">{{ $isLiked ? '👍' : '👍' }}</span>
        <span class="text-zinc-600">{{ $likesCount }}</span>
    </button>

    <!-- Dislike button -->
    <button 
        wire:click="toggleDislike"
        class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-mono uppercase tracking-wider transition-all rounded-sm {{ $isDisliked ? 'bg-red-950/40 text-red-400 border-red-900/60' : 'bg-zinc-950 text-zinc-500 border-zinc-800 hover:text-red-400 hover:border-red-900/40' }} border"
    >
        <span class="text-sm">{{ $isDisliked ? '👎' : '👎' }}</span>
        <span class="text-zinc-600">{{ $dislikesCount }}</span>
    </button>
</div>
