@extends('layouts.admin')

@section('title', 'Dispositivos & Pagamentos')
@section('page-title', 'Dispositivos & Pagamentos')

@section('content')
<div class="admin-page ui-modern">

    <!-- Header -->
    <div class="page-hero px-5 py-4 mb-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-widest text-emerald-200/80 mb-0.5">Gestão · Rede</p>
            <h1 class="text-xl font-bold text-white">Dispositivos & Pagamentos</h1>
            <p class="text-xs text-white/70 mt-0.5">Monitore usuários que pagaram e dispositivos detectados na rede</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.mikrotik.remote.index') }}" class="inline-flex items-center gap-1.5 px-3 py-2 bg-white/15 border border-white/20 rounded-xl text-sm font-semibold text-white hover:bg-white/25 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2"/></svg>
                Painel MikroTik
            </a>
            <button onclick="location.reload()" class="inline-flex items-center gap-1.5 px-3 py-2 bg-white rounded-xl text-sm font-bold text-green-dark hover:bg-emerald-50 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Atualizar
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 mb-6">
        <div class="bg-white rounded-xl border border-emerald-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Total Pgtos</p>
                    <p class="text-xl font-bold text-emerald-600">{{ $paidStats['total'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-green-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Online</p>
                    <p class="text-xl font-bold text-green-600">{{ $paidStats['online'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-blue-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Ativos</p>
                    <p class="text-xl font-bold text-blue-600">{{ $paidStats['active'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-red-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Expirados</p>
                    <p class="text-xl font-bold text-red-600">{{ $paidStats['expired'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-purple-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Pgtos Hoje</p>
                    <p class="text-xl font-bold text-purple-600">{{ $paidStats['today_payments'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-amber-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Receita Hoje</p>
                    <p class="text-lg font-bold text-amber-600">R$ {{ number_format($paidStats['today_revenue'], 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-xl border shadow-sm mb-6 p-4">
        <form method="GET" action="{{ route('admin.devices') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input type="text" name="search" value="{{ $search }}" placeholder="Buscar por MAC, telefone ou nome..." class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div>
                <select name="status" class="w-full sm:w-auto border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">Todos os Status</option>
                    <option value="online" {{ $statusFilter === 'online' ? 'selected' : '' }}>Online / Ativos</option>
                    <option value="expired" {{ $statusFilter === 'expired' ? 'selected' : '' }}>Expirados</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Buscar
                </button>
                @if($search || $statusFilter)
                <a href="{{ route('admin.devices') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Limpar
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabs -->
    <div class="bg-white rounded-xl border shadow-sm overflow-hidden mb-6">
        <div class="border-b">
            <div class="flex">
                <button onclick="switchTab('paid')" id="tab-paid" class="tab-btn flex-1 sm:flex-none px-5 py-3 text-sm font-medium border-b-2 border-emerald-500 text-emerald-700 bg-emerald-50 transition">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    Pagamentos <span class="ml-1 bg-emerald-500 text-white text-xs px-1.5 py-0.5 rounded-full">{{ $paidUsers->total() }}</span>
                </button>
                <button onclick="switchTab('devices')" id="tab-devices" class="tab-btn flex-1 sm:flex-none px-5 py-3 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 transition">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    Dispositivos <span class="ml-1 bg-gray-300 text-gray-600 text-xs px-1.5 py-0.5 rounded-full">{{ $devices->total() }}</span>
                </button>
            </div>
        </div>

        <!-- Tab: Usuários que Pagaram -->
        <div id="content-paid" class="tab-content">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                        <tr>
                            <th class="px-4 py-3 text-left">Usuário</th>
                            <th class="px-4 py-3 text-left">Telefone</th>
                            <th class="px-4 py-3 text-left">MAC Address</th>
                            <th class="px-4 py-3 text-left">Pagamento</th>
                            <th class="px-4 py-3 text-left">Valor</th>
                            <th class="px-4 py-3 text-left">Expira em</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($paidUsers as $payment)
                        @php $user = $payment->user; @endphp
                        @if($user)
                        @php
                            $isActive = in_array($user->status, ['connected', 'active', 'temp_bypass']) && $user->expires_at && $user->expires_at > now();
                            $isExpired = $user->expires_at && $user->expires_at <= now();
                            $statusMap = [
                                'connected' => ['label' => 'Conectado', 'color' => 'bg-emerald-100 text-emerald-700'],
                                'active' => ['label' => 'Ativo', 'color' => 'bg-emerald-100 text-emerald-700'],
                                'temp_bypass' => ['label' => 'Bypass', 'color' => 'bg-amber-100 text-amber-700'],
                                'expired' => ['label' => 'Expirado', 'color' => 'bg-red-100 text-red-700'],
                            ];
                            $st = $statusMap[$user->status] ?? ['label' => ucfirst($user->status ?? 'Offline'), 'color' => 'bg-gray-100 text-gray-600'];
                            if ($isExpired && $user->status !== 'expired') {
                                $st = ['label' => 'Expirado', 'color' => 'bg-red-100 text-red-700'];
                            }
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br {{ $isActive ? 'from-emerald-400 to-emerald-500' : 'from-gray-300 to-gray-400' }} flex items-center justify-center flex-shrink-0">
                                        <span class="text-white text-xs font-bold">{{ strtoupper(substr($user->name ?? 'U', 0, 2)) }}</span>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-medium text-gray-800 text-sm truncate">{{ $user->name ?? 'Sem nome' }}</p>
                                        <p class="text-xs text-gray-400">ID: {{ $user->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm {{ $user->phone ? 'text-gray-700 font-medium' : 'text-gray-400' }}">{{ $user->phone ?? 'N/A' }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-1.5">
                                    <code class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded text-xs font-mono">{{ $user->mac_address }}</code>
                                    <button onclick="copyMAC('{{ $user->mac_address }}')" class="p-1 text-gray-400 hover:text-blue-600 rounded transition" title="Copiar MAC">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    </button>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                @if($payment->paid_at)
                                    <p class="text-sm text-gray-700">{{ \Carbon\Carbon::parse($payment->paid_at)->format('d/m/Y H:i') }}</p>
                                    <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($payment->paid_at)->diffForHumans() }}</p>
                                @else
                                    <span class="text-xs text-gray-400">N/A</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                    R$ {{ number_format($payment->amount, 2, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @if($user->expires_at)
                                    @php
                                        $expiresAt = \Carbon\Carbon::parse($user->expires_at);
                                        $expired = $expiresAt->isPast();
                                    @endphp
                                    <p class="text-sm {{ $expired ? 'text-red-600' : 'text-gray-700' }}">{{ $expiresAt->format('d/m H:i') }}</p>
                                    <p class="text-xs {{ $expired ? 'text-red-400' : 'text-gray-400' }}">{{ $expired ? 'Expirou ' : 'Expira ' }}{{ $expiresAt->diffForHumans() }}</p>
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $st['color'] }}">
                                    @if($isActive)
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1 animate-pulse"></span>
                                    @endif
                                    {{ $st['label'] }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    @if($isActive)
                                    <button onclick="disconnectUser('{{ $user->mac_address }}')" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition" title="Desconectar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                    </button>
                                    @else
                                    <button onclick="reLiberate('{{ $user->mac_address }}')" class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded-lg transition" title="Re-liberar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endif
                        @empty
                        <tr>
                            <td colspan="8" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                    </div>
                                    <p class="text-gray-500 text-sm font-medium">Nenhum pagamento encontrado</p>
                                    <p class="text-gray-400 text-xs mt-1">{{ $search ? 'Tente outra busca' : 'Aguarde pagamentos serem confirmados' }}</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($paidUsers->hasPages())
            <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
                {{ $paidUsers->links() }}
            </div>
            @endif
        </div>

        <!-- Tab: Dispositivos Detectados -->
        <div id="content-devices" class="tab-content hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                        <tr>
                            <th class="px-4 py-3 text-left">Dispositivo</th>
                            <th class="px-4 py-3 text-left">MAC Address</th>
                            <th class="px-4 py-3 text-left">Tipo</th>
                            <th class="px-4 py-3 text-left">Primeira Conexão</th>
                            <th class="px-4 py-3 text-left">Última Atividade</th>
                            <th class="px-4 py-3 text-center">Conexões</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($devices as $device)
                        @php
                            $lastSeen = $device->last_seen;
                            $recentMinutes = $lastSeen ? now()->diffInMinutes($lastSeen) : null;
                            $isRecent = $recentMinutes !== null && $recentMinutes < 60;

                            $typeIcon = match(strtolower($device->device_type ?? '')) {
                                'mobile', 'smartphone', 'android', 'iphone' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>',
                                'laptop', 'computer', 'pc' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
                                'tablet', 'ipad' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>',
                                default => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
                            };
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg {{ $isRecent ? 'bg-blue-100' : 'bg-gray-100' }} flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 {{ $isRecent ? 'text-blue-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $typeIcon !!}</svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-medium text-gray-800 text-sm truncate">{{ $device->device_name ?? 'Dispositivo Desconhecido' }}</p>
                                        @if($isRecent)
                                            <span class="inline-flex items-center text-xs text-emerald-600">
                                                <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full mr-1 animate-pulse"></span>
                                                Recente
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-1.5">
                                    <code class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded text-xs font-mono">{{ $device->mac_address }}</code>
                                    <button onclick="copyMAC('{{ $device->mac_address }}')" class="p-1 text-gray-400 hover:text-blue-600 rounded transition" title="Copiar MAC">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    </button>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                    {{ ucfirst($device->device_type ?? 'Desconhecido') }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                @if($device->first_seen)
                                    <p>{{ $device->first_seen->format('d/m/Y H:i') }}</p>
                                    <p class="text-xs text-gray-400">{{ $device->first_seen->diffForHumans() }}</p>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                @if($device->last_seen)
                                    <p>{{ $device->last_seen->format('d/m/Y H:i') }}</p>
                                    <p class="text-xs text-gray-400">{{ $device->last_seen->diffForHumans() }}</p>
                                @else
                                    <span class="text-gray-400">Nunca</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold {{ $device->total_connections > 10 ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $device->total_connections ?? 0 }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                    </div>
                                    <p class="text-gray-500 text-sm font-medium">Nenhum dispositivo encontrado</p>
                                    <p class="text-gray-400 text-xs mt-1">{{ $search ? 'Tente outra busca' : 'Aguarde dispositivos se conectarem' }}</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($devices->hasPages())
            <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
                {{ $devices->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<script>
const csrfToken = '{{ csrf_token() }}';

// ========== Tabs ==========
function switchTab(tab) {
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('border-emerald-500', 'text-emerald-700', 'bg-emerald-50');
        btn.classList.add('border-transparent', 'text-gray-500');
    });
    document.getElementById('tab-' + tab).classList.add('border-emerald-500', 'text-emerald-700', 'bg-emerald-50');
    document.getElementById('tab-' + tab).classList.remove('border-transparent', 'text-gray-500');

    document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
    document.getElementById('content-' + tab).classList.remove('hidden');
}

// ========== Actions ==========
async function disconnectUser(mac) {
    if (!confirm(`Desconectar MAC ${mac}?\n\nO MikroTik vai remover o acesso na próxima sincronização (~15s).`)) return;

    try {
        const res = await fetch('/admin/mikrotik/remote/block', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ mac })
        });
        const data = await res.json();
        if (data.success) {
            showToast(data.message, 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast(data.error || 'Erro ao desconectar', 'error');
        }
    } catch (e) {
        showToast('Erro de conexão', 'error');
    }
}

async function reLiberate(mac) {
    const hours = prompt('Liberar por quantas horas?', '24');
    if (!hours) return;

    try {
        const res = await fetch('/admin/mikrotik/remote/liberate', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ mac, hours: parseInt(hours) })
        });
        const data = await res.json();
        if (data.success) {
            showToast(data.message, 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast(data.error || 'Erro ao liberar', 'error');
        }
    } catch (e) {
        showToast('Erro de conexão', 'error');
    }
}

function copyMAC(mac) {
    navigator.clipboard.writeText(mac).then(() => {
        showToast('MAC copiado: ' + mac, 'success');
    }).catch(() => {
        const input = document.createElement('input');
        input.value = mac;
        document.body.appendChild(input);
        input.select();
        document.execCommand('copy');
        document.body.removeChild(input);
        showToast('MAC copiado: ' + mac, 'success');
    });
}

function showToast(message, type = 'info') {
    const colors = { success: 'bg-emerald-600', error: 'bg-red-600', info: 'bg-blue-600' };
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-[100] ${colors[type]} text-white px-5 py-3 rounded-xl shadow-lg text-sm font-medium transform transition-all duration-300`;
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>
@endsection
