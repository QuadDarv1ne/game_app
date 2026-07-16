<div>
    <!-- Кнопка уведомлений -->
    <button 
        wire:click="toggle"
        class="relative p-2 text-zinc-400 hover:text-red-500 transition-colors"
        title="Уведомления"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        
        @php
            $unreadCount = auth()->user()->unreadNotifications();
        @endphp
        
        @if($unreadCount > 0)
            <span class="absolute -top-1 -right-1 bg-red-600 text-white text-[10px] font-bold rounded-full w-5 h-5 flex items-center justify-center">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    <!-- Выпадающая панель уведомлений -->
    @if($showPanel)
        <div class="absolute right-0 top-full mt-2 w-80 bg-zinc-900 border border-zinc-800 rounded-sm shadow-xl z-50">
            <!-- Заголовок -->
            <div class="p-4 border-b border-zinc-800 flex items-center justify-between">
                <h3 class="text-sm font-bold font-mono uppercase text-zinc-100">Уведомления</h3>
                <button 
                    wire:click="markAllAsRead"
                    class="text-[10px] font-mono text-red-500 hover:text-red-400 uppercase"
                >
                    [ Все прочитано ]
                </button>
            </div>

            <!-- Фильтры -->
            <div class="p-3 border-b border-zinc-800 flex gap-2">
                <button 
                    wire:click="setFilter('all')"
                    class="px-3 py-1 text-[10px] font-mono uppercase {{ $filter === 'all' ? 'bg-red-950/40 text-red-400 border border-red-900/30' : 'bg-zinc-950 text-zinc-500 border border-zinc-800' }} rounded-xs transition-all"
                >
                    Все
                </button>
                <button 
                    wire:click="setFilter('unread')"
                    class="px-3 py-1 text-[10px] font-mono uppercase {{ $filter === 'unread' ? 'bg-red-950/40 text-red-400 border border-red-900/30' : 'bg-zinc-950 text-zinc-500 border border-zinc-800' }} rounded-xs transition-all"
                >
                    Непрочитанные
                </button>
            </div>

            <!-- Список уведомлений -->
            <div class="max-h-80 overflow-y-auto">
                @foreach($notifications as $notification)
                    <div class="p-3 border-b border-zinc-950 {{ !$notification->is_read ? 'bg-zinc-950/50' : '' }} group hover:bg-zinc-950 transition-all">
                        <div class="flex items-start gap-3">
                            <span class="text-lg">{{ $notification->icon }}</span>
                            
                            <div class="flex-1 space-y-1">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-xs font-bold font-mono text-zinc-100 uppercase">{{ $notification->title }}</h4>
                                    <button 
                                        wire:click="delete({{ $notification->id }})"
                                        class="opacity-0 group-hover:opacity-100 text-zinc-600 hover:text-red-500 transition-all text-[9px] font-mono"
                                    >
                                        [✕]
                                    </button>
                                </div>
                                
                                <p class="text-[10px] text-zinc-400 font-sans">{{ $notification->message }}</p>
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-[9px] font-mono text-zinc-600">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                    
                                    @if(!$notification->is_read)
                                        <button 
                                            wire:click="markAsRead({{ $notification->id }})"
                                            class="text-[9px] font-mono text-red-500 hover:text-red-400 uppercase"
                                        >
                                            [ Прочитать ]
                                        </button>
                                    @endif
                                </div>
                                
                                @if($notification->link)
                                    <a href="{{ $notification->link }}" class="block text-[9px] font-mono text-red-500 hover:text-red-400 uppercase mt-1">
                                        [ Перейти ]
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

                @if($notifications->isEmpty())
                    <div class="p-8 text-center">
                        <p class="text-xs font-mono text-zinc-500 uppercase">
                            Нет уведомлений
                        </p>
                    </div>
                @endif
            </div>

            <!-- Пагинация -->
            @if($notifications->hasPages())
                <div class="p-3 border-t border-zinc-800">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    @endif
</div>
