<div>
    <button 
        wire:click="toggle"
        class="flex items-center gap-2 px-3 py-1.5 text-xs font-mono uppercase tracking-wider transition-all rounded-sm {{ $isBookmarked ? 'bg-amber-950/40 text-amber-400 border-amber-900/60' : 'bg-zinc-950 text-zinc-500 border-zinc-800 hover:text-amber-400 hover:border-amber-900/40' }} border"
    >
        <span class="text-sm">{{ $isBookmarked ? '★' : '☆' }}</span>
        <span>
            {{ $isBookmarked ? 'В избранном' : 'В избранное' }}
            <span class="text-zinc-600">({{ $bookmarksCount }})</span>
        </span>
    </button>
</div>
