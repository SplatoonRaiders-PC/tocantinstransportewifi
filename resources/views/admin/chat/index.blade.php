@extends('layouts.admin')

@section('title', 'Chat - Atendimento')
@section('page-title', '💬 Central de Atendimento')

@section('breadcrumb')
    <span class="mx-2">/</span>
    <span class="text-emerald-600 font-medium">Chat</span>
@endsection

@section('content')
<div class="admin-page ui-modern space-y-5">
    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
        <div class="bg-white rounded-2xl p-4 border border-gray-100 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total de Conversas</p>
                    <p class="text-2xl font-extrabold tracking-tight text-gray-800 mt-1">{{ $stats['total'] }}</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-50 rounded-2xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-gray-100 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Conversas Ativas</p>
                    <p class="text-2xl font-extrabold tracking-tight text-emerald-600 mt-1">{{ $stats['active'] }}</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-emerald-100 to-emerald-50 rounded-2xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-gray-100 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Aguardando Resposta</p>
                    <p class="text-2xl font-extrabold tracking-tight text-amber-600 mt-1">{{ $stats['pending'] }}</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-amber-100 to-amber-50 rounded-2xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-lg border border-gray-100 hover:shadow-xl transition-shadow relative overflow-hidden">
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Não Lidas</p>
                    <p class="text-2xl font-extrabold tracking-tight text-red-600 mt-1">{{ $stats['unread'] }}</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-red-100 to-red-50 rounded-2xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
            </div>
            @if($stats['unread'] > 0)
            <div class="absolute top-0 right-0 w-20 h-20 bg-red-500/10 rounded-full -translate-y-1/2 translate-x-1/2 animate-pulse"></div>
            @endif
        </div>
    </div>

    <!-- Conversations List -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="p-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Conversas</h3>
                    <p class="text-xs text-gray-500">Gerencie os atendimentos dos clientes</p>
                </div>
            </div>
            <div class="flex items-center space-x-2 text-sm text-gray-500">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                <span>Atualização automática</span>
            </div>
        </div>

        @if($conversations->count() > 0)
        <div class="divide-y divide-gray-50">
            @foreach($conversations as $conversation)
            <a href="{{ route('admin.chat.show', $conversation->id) }}" 
               class="block p-5 hover:bg-gradient-to-r hover:from-emerald-50/50 hover:to-transparent transition-all duration-200 {{ $conversation->unread_count > 0 ? 'bg-gradient-to-r from-blue-50/70 to-transparent border-l-4 border-l-blue-500' : '' }}">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white font-bold text-xl shadow-lg">
                                {{ strtoupper(substr($conversation->visitor_name, 0, 1)) }}
                            </div>
                            @if($conversation->status === 'active')
                            <span class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-2 border-white rounded-full"></span>
                            @elseif($conversation->status === 'pending')
                            <span class="absolute -bottom-1 -right-1 w-4 h-4 bg-amber-500 border-2 border-white rounded-full animate-pulse"></span>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center space-x-2">
                                <p class="font-bold text-gray-800 truncate">{{ $conversation->visitor_name }}</p>
                                @if($conversation->unread_count > 0)
                                <span class="bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs px-2.5 py-1 rounded-full font-bold shadow-sm animate-pulse">
                                    {{ $conversation->unread_count }} nova{{ $conversation->unread_count > 1 ? 's' : '' }}
                                </span>
                                @endif
                            </div>
                            <div class="flex items-center space-x-3 text-sm text-gray-500 mt-1">
                                <span class="flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span>{{ $conversation->visitor_phone }}</span>
                                </span>
                                <span class="text-gray-300">•</span>
                                <span class="truncate max-w-[200px]">{{ $conversation->visitor_email }}</span>
                            </div>
                            @if($conversation->visitor_mac || $conversation->visitor_ip)
                            <div class="flex items-center space-x-3 text-xs text-gray-400 mt-1 font-mono">
                                @if($conversation->visitor_mac)
                                <span class="flex items-center space-x-1" title="MAC Address">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                                    </svg>
                                    <span>{{ strtoupper($conversation->visitor_mac) }}</span>
                                </span>
                                @endif
                                @if($conversation->visitor_mac && $conversation->visitor_ip)
                                    <span class="text-gray-300">•</span>
                                @endif
                                @if($conversation->visitor_ip)
                                <span title="IP Address">{{ $conversation->visitor_ip }}</span>
                                @endif
                            </div>
                            @endif
                            @if($conversation->lastMessage)
                            <p class="text-sm text-gray-600 truncate max-w-md mt-2 flex items-center space-x-1">
                                @if($conversation->lastMessage->sender_type === 'admin')
                                <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-emerald-600 font-medium">Você:</span>
                                @endif
                                <span>{{ Str::limit($conversation->lastMessage->message, 60) }}</span>
                            </p>
                            @endif
                        </div>
                    </div>
                    <div class="text-right flex-shrink-0 ml-4">
                        <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold
                            {{ $conversation->status === 'active' ? 'bg-emerald-100 text-emerald-700' : '' }}
                            {{ $conversation->status === 'pending' ? 'bg-amber-100 text-amber-700' : '' }}
                            {{ $conversation->status === 'closed' ? 'bg-gray-100 text-gray-600' : '' }}">
                            <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $conversation->status === 'active' ? 'bg-emerald-500' : ($conversation->status === 'pending' ? 'bg-amber-500' : 'bg-gray-400') }}"></span>
                            {{ $conversation->status === 'active' ? 'Ativa' : '' }}
                            {{ $conversation->status === 'pending' ? 'Pendente' : '' }}
                            {{ $conversation->status === 'closed' ? 'Encerrada' : '' }}
                        </span>
                        <p class="text-xs text-gray-400 mt-2 flex items-center justify-end space-x-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ $conversation->last_message_at ? $conversation->last_message_at->diffForHumans() : $conversation->created_at->diffForHumans() }}</span>
                        </p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <div class="p-5 border-t border-gray-100 bg-gray-50">
            {{ $conversations->links() }}
        </div>
        @else
        <div class="p-16 text-center">
            <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-50 rounded-3xl flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
            </div>
            <h4 class="text-xl font-bold text-gray-800 mb-2">Nenhuma conversa ainda</h4>
            <p class="text-gray-500 max-w-sm mx-auto">Quando os visitantes iniciarem conversas pelo chat do portal, elas aparecerão aqui.</p>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
// Auto-refresh a cada 20 segundos (sem recarregar a página inteira)
let lastUpdate = Date.now();

setInterval(function() {
    // Só atualiza se a aba estiver ativa
    if (!document.hidden) {
        location.reload();
    }
}, 20000);

// Notificação sonora para novas mensagens (opcional)
document.addEventListener('visibilitychange', function() {
    if (!document.hidden) {
        // Quando a aba ficar ativa, atualizar
        if (Date.now() - lastUpdate > 10000) {
            location.reload();
        }
    }
});
</script>
@endpush
@endsection
