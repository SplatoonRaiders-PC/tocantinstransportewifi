@extends('layouts.admin')

@section('title', 'MikroTik Remoto')

@section('breadcrumb')
    <span class="text-muted">›</span>
    <span class="text-green font-semibold">MikroTik Remoto</span>
@endsection

@section('page-title', 'MikroTik Remoto')

@section('content')
<div class="admin-page ui-modern">

    <!-- Hero Banner -->
    <div class="page-hero px-5 py-4 mb-5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-widest text-emerald-200/80 mb-0.5">Starlink · Controle de Acesso</p>
            <h1 class="text-xl font-bold text-white">MikroTik Remoto</h1>
            <p class="text-xs text-white/70 mt-0.5">Gerencie os MACs liberados. Sincronização a cada 15s via API.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <button onclick="refreshData()" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/15 border border-white/20 rounded-lg text-xs font-semibold text-white hover:bg-white/25 transition" id="btn-refresh">
                <svg class="w-3.5 h-3.5" id="refresh-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Atualizar
            </button>
            <button onclick="showPreviewAPI()" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/15 border border-white/20 rounded-lg text-xs font-semibold text-white hover:bg-white/25 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                API
            </button>
            <button onclick="showLogs()" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/15 border border-white/20 rounded-lg text-xs font-semibold text-white hover:bg-white/25 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Logs
            </button>
            <button onclick="switchTab('bypass')" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white text-gold font-bold text-xs rounded-lg hover:bg-gold-pale transition shadow-card">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Bypass
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-6">
        <div class="bg-white rounded-xl border border-green/30 shadow-card p-4 hover:shadow-hover transition-all">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-green-pale rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0"/></svg>
                </div>
                <div>
                    <p class="text-[10px] text-muted font-medium">Liberados (L:)</p>
                    <p class="text-2xl font-bold text-green" id="stat-liberados">-</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-red/30 shadow-card p-4 hover:shadow-hover transition-all">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-red-pale rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                </div>
                <div>
                    <p class="text-[10px] text-muted font-medium">Para Remover (R:)</p>
                    <p class="text-2xl font-bold text-red" id="stat-expirados">-</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-blue/30 shadow-card p-4 hover:shadow-hover transition-all">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-blue-pale rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] text-muted font-medium">Total Registrados</p>
                    <p class="text-2xl font-bold text-blue" id="stat-total">-</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Liberar MAC Manual -->
    <div class="bg-white rounded-xl border border-border shadow-card mb-6 overflow-hidden">
        <div class="px-5 py-3 border-b border-border flex items-center gap-2">
            <svg class="w-4 h-4 text-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            <h2 class="text-sm font-bold text-ink">Liberar MAC Manualmente</h2>
        </div>
        <div class="p-5">
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                <div>
                    <label class="block text-[11px] font-semibold text-ink2 uppercase tracking-wider mb-1.5">MAC Address *</label>
                    <input type="text" id="input-mac" placeholder="XX:XX:XX:XX:XX:XX" class="w-full px-3 py-2 text-sm text-ink bg-surface border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-green/30 focus:border-green transition-all uppercase" maxlength="17">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-ink2 uppercase tracking-wider mb-1.5">Telefone</label>
                    <input type="text" id="input-phone" placeholder="(63) 99999-9999" class="w-full px-3 py-2 text-sm text-ink bg-surface border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-green/30 focus:border-green transition-all">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-ink2 uppercase tracking-wider mb-1.5">Duração</label>
                    <select id="input-hours" class="w-full px-3 py-2 text-sm text-ink bg-surface border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-green/30 focus:border-green transition-all">
                        <option value="1">1 hora</option>
                        <option value="2">2 horas</option>
                        <option value="6">6 horas</option>
                        <option value="12">12 horas</option>
                        <option value="24" selected>24 horas</option>
                        <option value="48">48 horas</option>
                        <option value="72">72 horas</option>
                        <option value="168">7 dias</option>
                        <option value="720">30 dias</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button onclick="liberateMac()" class="w-full bg-green hover:bg-green-light text-white font-semibold py-2 px-4 rounded-lg text-sm transition-colors flex items-center justify-center gap-1.5 shadow-card">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Liberar
                    </button>
                </div>
            </div>
            <p class="text-[10px] text-muted mt-2">O MikroTik vai liberar esse MAC automaticamente na próxima sincronização (~15s).</p>
        </div>
    </div>

    <!-- Tabs -->
    <div class="bg-white rounded-xl border border-border shadow-card overflow-hidden">
        <div class="border-b border-border">
            <div class="flex">
                <button onclick="switchTab('liberados')" id="tab-liberados" class="tab-btn flex-1 sm:flex-none px-5 py-3 text-xs font-bold border-b-2 border-green text-green bg-green-pale transition">
                    Liberados <span id="badge-liberados" class="ml-1 text-[9px] font-bold bg-green/10 text-green px-1.5 py-0.5 rounded">0</span>
                </button>
                <button onclick="switchTab('expirados')" id="tab-expirados" class="tab-btn flex-1 sm:flex-none px-5 py-3 text-xs font-bold border-b-2 border-transparent text-muted hover:text-ink transition">
                    Expirados <span id="badge-expirados" class="ml-1 text-[9px] font-bold bg-surface text-muted px-1.5 py-0.5 rounded">0</span>
                </button>
                <button onclick="switchTab('todos')" id="tab-todos" class="tab-btn flex-1 sm:flex-none px-5 py-3 text-xs font-bold border-b-2 border-transparent text-muted hover:text-ink transition">
                    Todos <span id="badge-todos" class="ml-1 text-[9px] font-bold bg-surface text-muted px-1.5 py-0.5 rounded">0</span>
                </button>
                <button onclick="switchTab('bypass')" id="tab-bypass" class="tab-btn flex-1 sm:flex-none px-5 py-3 text-xs font-bold border-b-2 border-transparent text-muted hover:text-ink transition">
                    Bypass <span id="badge-bypass" class="ml-1 text-[9px] font-bold bg-gold/10 text-gold px-1.5 py-0.5 rounded">0</span>
                </button>
                <button onclick="switchTab('buses')" id="tab-buses" class="tab-btn flex-1 sm:flex-none px-5 py-3 text-xs font-bold border-b-2 border-transparent text-muted hover:text-ink transition">
                    Ônibus <span id="badge-buses" class="ml-1 text-[9px] font-bold bg-blue/10 text-blue px-1.5 py-0.5 rounded">0</span>
                </button>
            </div>
        </div>

        <!-- Busca -->
        <div class="px-5 py-3 bg-surface border-b border-border">
            <input type="text" id="search-input" placeholder="Buscar por MAC, telefone ou nome..." class="w-full sm:w-80 px-3 py-2 text-sm text-ink bg-white border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-green/30 focus:border-green transition-all" oninput="filterTable()">
        </div>

        <div id="content-liberados" class="tab-content">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead><tr class="border-b border-border bg-surface">
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-muted uppercase tracking-wider">Usuário</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-muted uppercase tracking-wider">Telefone</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-muted uppercase tracking-wider">MAC Address</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-muted uppercase tracking-wider">IP</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-muted uppercase tracking-wider">Expira em</th>
                        <th class="px-4 py-2.5 text-center text-[10px] font-bold text-muted uppercase tracking-wider">Ações</th>
                    </tr></thead>
                    <tbody id="table-liberados" class="divide-y divide-border">
                        <tr><td colspan="6" class="px-4 py-8 text-center text-muted text-sm">Carregando...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="content-expirados" class="tab-content hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead><tr class="border-b border-border bg-surface">
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-muted uppercase tracking-wider">Usuário</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-muted uppercase tracking-wider">Telefone</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-muted uppercase tracking-wider">MAC Address</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-muted uppercase tracking-wider">Expirou em</th>
                        <th class="px-4 py-2.5 text-center text-[10px] font-bold text-muted uppercase tracking-wider">Ações</th>
                    </tr></thead>
                    <tbody id="table-expirados" class="divide-y divide-border">
                        <tr><td colspan="5" class="px-4 py-8 text-center text-muted text-sm">Carregando...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="content-todos" class="tab-content hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead><tr class="border-b border-border bg-surface">
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-muted uppercase tracking-wider">Usuário</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-muted uppercase tracking-wider">Telefone</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-muted uppercase tracking-wider">MAC Address</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-muted uppercase tracking-wider">Status</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-muted uppercase tracking-wider">Expira/Expirou</th>
                        <th class="px-4 py-2.5 text-center text-[10px] font-bold text-muted uppercase tracking-wider">Ações</th>
                    </tr></thead>
                    <tbody id="table-todos" class="divide-y divide-border">
                        <tr><td colspan="6" class="px-4 py-8 text-center text-muted text-sm">Carregando...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab Bypass Logs -->
        <div id="content-bypass" class="tab-content hidden">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 p-4 bg-gold-pale border-b border-border">
                <div class="text-center p-2 bg-white rounded-xl shadow-card">
                    <p class="text-[10px] text-muted">Total Hoje</p>
                    <p class="text-lg font-bold text-gold" id="bypass-stat-total">-</p>
                </div>
                <div class="text-center p-2 bg-white rounded-xl shadow-card">
                    <p class="text-[10px] text-muted">Aprovados</p>
                    <p class="text-lg font-bold text-green" id="bypass-stat-aprovados">-</p>
                </div>
                <div class="text-center p-2 bg-white rounded-xl shadow-card">
                    <p class="text-[10px] text-muted">Negados</p>
                    <p class="text-lg font-bold text-red" id="bypass-stat-negados">-</p>
                </div>
                <div class="text-center p-2 bg-white rounded-xl shadow-card">
                    <p class="text-[10px] text-muted">Total Geral</p>
                    <p class="text-lg font-bold text-ink" id="bypass-stat-geral">-</p>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead><tr class="border-b border-border bg-surface">
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-muted uppercase tracking-wider">Data/Hora</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-muted uppercase tracking-wider">Telefone</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-muted uppercase tracking-wider">MAC</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-muted uppercase tracking-wider">IP</th>
                        <th class="px-4 py-2.5 text-center text-[10px] font-bold text-muted uppercase tracking-wider">Nº</th>
                        <th class="px-4 py-2.5 text-center text-[10px] font-bold text-muted uppercase tracking-wider">Status</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-muted uppercase tracking-wider">Motivo</th>
                        <th class="px-4 py-2.5 text-center text-[10px] font-bold text-muted uppercase tracking-wider">Ação</th>
                    </tr></thead>
                    <tbody id="table-bypass" class="divide-y divide-border">
                        <tr><td colspan="8" class="px-4 py-8 text-center text-muted text-sm">Clique em "Bypass" para carregar</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab Ônibus -->
        <div id="content-buses" class="tab-content hidden">
            <div class="p-5">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-sm font-bold text-ink">Ônibus Cadastrados</h3>
                        <p class="text-[10px] text-muted">Aparecem automaticamente quando o MikroTik sincroniza</p>
                    </div>
                    <button onclick="loadBuses()" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-surface border border-border text-ink2 font-semibold text-xs rounded-lg hover:bg-border transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        Atualizar
                    </button>
                </div>
                <div id="buses-list" class="space-y-3">
                    <p class="text-center text-muted text-sm py-8">Carregando...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Preview API -->
<div id="modal-api" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 hidden flex items-start justify-center pt-20 p-4 overflow-y-auto">
    <div class="bg-white rounded-xl shadow-modal max-w-lg w-full max-h-[80vh] flex flex-col border border-border">
        <div class="px-5 py-3 border-b border-border flex items-center justify-between">
            <h3 class="text-sm font-bold text-ink">Resposta da API para o MikroTik</h3>
            <button onclick="closeModal('modal-api')" class="text-muted hover:text-ink p-1 hover:bg-surface rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="p-5 overflow-y-auto flex-1">
            <p class="text-[10px] text-muted mb-3">Exatamente o que o MikroTik recebe ao consultar <code class="bg-surface px-1.5 py-0.5 rounded text-[10px] font-mono">/api/mikrotik/check-paid-users-lite</code></p>
            <pre id="api-preview-content" class="bg-ink text-green-light p-4 rounded-xl text-xs font-mono whitespace-pre overflow-x-auto"></pre>
            <div id="api-preview-stats" class="mt-3 text-[10px] text-muted"></div>
        </div>
    </div>
</div>

<!-- Modal Logs -->
<div id="modal-logs" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 hidden flex items-start justify-center pt-20 p-4 overflow-y-auto">
    <div class="bg-white rounded-xl shadow-modal max-w-2xl w-full max-h-[80vh] flex flex-col border border-border">
        <div class="px-5 py-3 border-b border-border flex items-center justify-between">
            <h3 class="text-sm font-bold text-ink">Logs do Sistema (MikroTik)</h3>
            <button onclick="closeModal('modal-logs')" class="text-muted hover:text-ink p-1 hover:bg-surface rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="p-5 overflow-y-auto flex-1">
            <pre id="logs-content" class="bg-ink text-gray-300 p-4 rounded-xl text-[10px] font-mono whitespace-pre-wrap max-h-96 overflow-y-auto"></pre>
        </div>
    </div>
</div>

<script>
const csrfToken = '{{ csrf_token() }}';
let cachedData = null;
let currentTab = 'liberados';

// Carregar ao iniciar
document.addEventListener('DOMContentLoaded', () => {
    refreshData();
    // Auto-refresh a cada 15s (mesmo intervalo do MikroTik)
    setInterval(refreshData, 15000);
});

async function refreshData() {
    const icon = document.getElementById('refresh-icon');
    icon?.classList.add('animate-spin');

    try {
        const response = await fetch('/admin/mikrotik/remote/status');
        const data = await response.json();

        if (data.error) {
            showToast('Erro: ' + data.error, 'error');
            return;
        }

        cachedData = data;

        // Atualizar stats
        document.getElementById('stat-liberados').textContent = data.stats.total_liberados;
        document.getElementById('stat-expirados').textContent = data.stats.total_expirados;
        document.getElementById('stat-total').textContent = data.stats.total_registrados;

        // Atualizar badges
        document.getElementById('badge-liberados').textContent = data.stats.total_liberados;
        document.getElementById('badge-expirados').textContent = data.stats.total_expirados;
        document.getElementById('badge-todos').textContent = data.stats.total_registrados;

        // Atualizar tabelas
        renderLiberados(data.liberados);
        renderExpirados(data.expirados);
        renderTodos(data.todos);

    } catch (error) {
        console.error('Erro ao carregar dados:', error);
    } finally {
        icon?.classList.remove('animate-spin');
    }
}

function renderLiberados(users) {
    const tbody = document.getElementById('table-liberados');
    if (!users || users.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Nenhum MAC liberado no momento</td></tr>';
        return;
    }

    tbody.innerHTML = users.map(user => {
        const expiresAt = new Date(user.expires_at);
        const now = new Date();
        const diffMs = expiresAt - now;
        const diffH = Math.floor(diffMs / 3600000);
        const diffM = Math.floor((diffMs % 3600000) / 60000);
        const timeLeft = diffH > 0 ? `${diffH}h ${diffM}m` : `${diffM}m`;

        return `<tr class="hover:bg-surface user-row" data-search="${(user.mac_address + ' ' + (user.phone || '') + ' ' + (user.name || '')).toLowerCase()}">
            <td class="px-4 py-3">
                <p class="font-semibold text-ink text-sm">${user.name || '-'}</p>
                <p class="text-[10px] text-muted">${user.device_name || ''}</p>
            </td>
            <td class="px-4 py-3">
                <span class="text-xs ${user.phone ? 'text-ink2 font-medium' : 'text-muted'}">${user.phone || 'Não informado'}</span>
            </td>
            <td class="px-4 py-3">
                <code class="bg-green-pale text-green px-2 py-1 rounded text-[10px] font-mono font-bold">${user.mac_address}</code>
            </td>
            <td class="px-4 py-3 text-xs text-muted">${user.ip_address || '-'}</td>
            <td class="px-4 py-3">
                <div class="flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 bg-green rounded-full animate-pulse"></span>
                    <span class="text-xs text-green font-semibold">${timeLeft}</span>
                </div>
                <p class="text-[10px] text-muted mt-0.5">${formatDate(user.expires_at)}</p>
            </td>
            <td class="px-4 py-3 text-center">
                <div class="flex items-center justify-center gap-1">
                    <button onclick="editExpiration(${user.id}, '${user.mac_address}')" class="p-1.5 text-blue hover:bg-blue-pale rounded-lg transition" title="Editar tempo">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </button>
                    <button onclick="blockMac('${user.mac_address}')" class="p-1.5 text-red hover:bg-red-pale rounded-lg transition" title="Bloquear">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                    </button>
                </div>
            </td>
        </tr>`;
    }).join('');
}

function renderExpirados(users) {
    const tbody = document.getElementById('table-expirados');
    if (!users || users.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">Nenhum MAC expirado recente</td></tr>';
        return;
    }

    tbody.innerHTML = users.map(user => {
        return `<tr class="hover:bg-surface user-row" data-search="${(user.mac_address + ' ' + (user.phone || '') + ' ' + (user.name || '')).toLowerCase()}">
            <td class="px-4 py-3">
                <p class="font-semibold text-ink text-sm">${user.name || '-'}</p>
            </td>
            <td class="px-4 py-3">
                <span class="text-xs ${user.phone ? 'text-ink2 font-medium' : 'text-muted'}">${user.phone || 'Não informado'}</span>
            </td>
            <td class="px-4 py-3">
                <code class="bg-red-pale text-red px-2 py-1 rounded text-[10px] font-mono font-bold">${user.mac_address}</code>
            </td>
            <td class="px-4 py-3">
                <span class="text-xs text-red">${formatDate(user.expires_at)}</span>
            </td>
            <td class="px-4 py-3 text-center">
                <button onclick="reLiberate(${user.id}, '${user.mac_address}')" class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-pale text-green rounded-lg text-[10px] font-bold hover:bg-green/10 transition" title="Re-liberar">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Re-liberar
                </button>
            </td>
        </tr>`;
    }).join('');
}

function renderTodos(users) {
    const tbody = document.getElementById('table-todos');
    if (!users || users.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Nenhum registro</td></tr>';
        return;
    }

    tbody.innerHTML = users.map(user => {
        const statusMap = {
            'connected': { label: 'Liberado', color: 'bg-green/10 text-green' },
            'active': { label: 'Ativo', color: 'bg-green/10 text-green' },
            'expired': { label: 'Expirado', color: 'bg-red/10 text-red' },
            'cleaned': { label: 'Limpo', color: 'bg-surface text-muted' },
            'pending': { label: 'Pendente', color: 'bg-gold/10 text-gold' },
        };
        const st = statusMap[user.status] || { label: user.status, color: 'bg-surface text-muted' };
        const isActive = ['connected', 'active'].includes(user.status) && user.expires_at && new Date(user.expires_at) > new Date();

        return `<tr class="hover:bg-surface user-row" data-search="${(user.mac_address + ' ' + (user.phone || '') + ' ' + (user.name || '')).toLowerCase()}">
            <td class="px-4 py-3">
                <p class="font-semibold text-ink text-sm">${user.name || '-'}</p>
                <p class="text-[10px] text-muted">${user.device_name || ''}</p>
            </td>
            <td class="px-4 py-3">
                <span class="text-xs ${user.phone ? 'text-ink2 font-medium' : 'text-muted'}">${user.phone || '-'}</span>
            </td>
            <td class="px-4 py-3">
                <code class="bg-surface text-ink2 px-2 py-1 rounded text-[10px] font-mono font-bold">${user.mac_address}</code>
            </td>
            <td class="px-4 py-3">
                <span class="text-[9px] font-bold uppercase tracking-wider px-1.5 py-0.5 rounded ${st.color}">${st.label}</span>
            </td>
            <td class="px-4 py-3 text-xs text-muted">${user.expires_at ? formatDate(user.expires_at) : '-'}</td>
            <td class="px-4 py-3 text-center">
                ${isActive ? `
                    <button onclick="blockMac('${user.mac_address}')" class="inline-flex items-center gap-1 px-2.5 py-1 bg-red-pale text-red rounded-lg text-[10px] font-bold hover:bg-red/10 transition">Bloquear</button>
                ` : `
                    <button onclick="reLiberate(${user.id}, '${user.mac_address}')" class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-pale text-green rounded-lg text-[10px] font-bold hover:bg-green/10 transition">Liberar</button>
                `}
            </td>
        </tr>`;
    }).join('');
}

// ========== Ações ==========

async function liberateMac() {
    const mac = document.getElementById('input-mac').value.trim();
    const phone = document.getElementById('input-phone').value.trim();
    const hours = document.getElementById('input-hours').value;

    if (!mac) return showToast('Digite um MAC address', 'error');
    if (!/^([0-9A-Fa-f]{2}:){5}[0-9A-Fa-f]{2}$/.test(mac)) return showToast('MAC inválido. Use formato XX:XX:XX:XX:XX:XX', 'error');

    try {
        const res = await fetch('/admin/mikrotik/remote/liberate', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ mac, phone, hours: parseInt(hours) })
        });
        const data = await res.json();

        if (data.success) {
            showToast(data.message, 'success');
            document.getElementById('input-mac').value = '';
            document.getElementById('input-phone').value = '';
            refreshData();
        } else {
            showToast(data.error || 'Erro ao liberar', 'error');
        }
    } catch (e) {
        showToast('Erro de conexão', 'error');
    }
}

async function blockMac(mac) {
    if (!confirm(`Bloquear MAC ${mac}?\n\nO MikroTik vai remover o acesso na próxima sincronização (~15s).`)) return;

    try {
        const res = await fetch('/admin/mikrotik/remote/block', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ mac })
        });
        const data = await res.json();

        if (data.success) {
            showToast(data.message, 'success');
            refreshData();
        } else {
            showToast(data.error || 'Erro ao bloquear', 'error');
        }
    } catch (e) {
        showToast('Erro de conexão', 'error');
    }
}

async function reLiberate(userId, mac) {
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
            refreshData();
        } else {
            showToast(data.error || 'Erro', 'error');
        }
    } catch (e) {
        showToast('Erro de conexão', 'error');
    }
}

async function editExpiration(userId, mac) {
    const hours = prompt(`Editar tempo de ${mac}.\nQuantas horas a partir de agora?`, '24');
    if (!hours) return;

    try {
        const res = await fetch('/admin/mikrotik/remote/edit-expiration', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ user_id: userId, hours: parseInt(hours) })
        });
        const data = await res.json();

        if (data.success) {
            showToast(data.message, 'success');
            refreshData();
        } else {
            showToast(data.error || 'Erro', 'error');
        }
    } catch (e) {
        showToast('Erro de conexão', 'error');
    }
}

// ========== Preview API ==========

async function showPreviewAPI() {
    document.getElementById('modal-api').classList.remove('hidden');

    try {
        const res = await fetch('/admin/mikrotik/remote/sync', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken }
        });
        const data = await res.json();

        document.getElementById('api-preview-content').textContent = data.api_response || 'Erro';
        document.getElementById('api-preview-stats').innerHTML = data.stats
            ? `<span class="text-emerald-600 font-medium">L: ${data.stats.liberar} para liberar</span> &bull; <span class="text-red-600 font-medium">R: ${data.stats.remover} para remover</span>`
            : '';
    } catch (e) {
        document.getElementById('api-preview-content').textContent = 'Erro ao consultar API';
    }
}

async function showLogs() {
    document.getElementById('modal-logs').classList.remove('hidden');

    try {
        const res = await fetch('/admin/mikrotik/remote/logs');
        const data = await res.json();

        if (data.logs && data.logs.length > 0) {
            document.getElementById('logs-content').textContent = data.logs.join('\n');
        } else {
            document.getElementById('logs-content').textContent = 'Nenhum log do MikroTik encontrado.';
        }
    } catch (e) {
        document.getElementById('logs-content').textContent = 'Erro ao carregar logs.';
    }
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
}

// Fechar modais ao clicar fora
document.addEventListener('click', (e) => {
    ['modal-api', 'modal-logs'].forEach(id => {
        const modal = document.getElementById(id);
        if (e.target === modal) modal.classList.add('hidden');
    });
});

// ========== Tabs ==========

function switchTab(tab) {
    currentTab = tab;
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('border-green', 'text-green', 'bg-green-pale');
        btn.classList.add('border-transparent', 'text-muted');
    });
    const activeBtn = document.getElementById('tab-' + tab);
    activeBtn.classList.add('border-green', 'text-green', 'bg-green-pale');
    activeBtn.classList.remove('border-transparent', 'text-muted');

    document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
    document.getElementById('content-' + tab).classList.remove('hidden');

    if (tab === 'bypass') loadBypassLogs();
    if (tab === 'buses') loadBuses();
}

async function loadBypassLogs() {
    const tbody = document.getElementById('table-bypass');
    tbody.innerHTML = '<tr><td colspan="8" class="px-4 py-8 text-center text-gray-400"><svg class="animate-spin h-5 w-5 mx-auto text-amber-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg></td></tr>';

    try {
        const resp = await fetch('{{ route("admin.mikrotik.remote.bypass-logs") }}');
        const data = await resp.json();

        if (!data.success) throw new Error(data.error || 'Erro');

        // Stats
        document.getElementById('bypass-stat-total').textContent = data.stats.total_hoje;
        document.getElementById('bypass-stat-aprovados').textContent = data.stats.aprovados_hoje;
        document.getElementById('bypass-stat-negados').textContent = data.stats.negados_hoje;
        document.getElementById('bypass-stat-geral').textContent = data.stats.total_geral;
        document.getElementById('badge-bypass').textContent = data.stats.total_hoje;

        if (data.logs.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" class="px-4 py-8 text-center text-gray-400">Nenhum registro de bypass ainda</td></tr>';
            return;
        }

        tbody.innerHTML = data.logs.map(log => {
            const date = formatDate(log.created_at);
            const statusBadge = log.was_denied
                ? '<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">❌ Negado</span>'
                : '<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">✅ Aprovado</span>';

            const blockedBadge = log.is_blocked
                ? '<span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-full text-[9px] font-bold bg-red-600 text-white ml-1">🚫 BLOQUEADO</span>'
                : '';

            return `<tr class="hover:bg-gray-50 user-row ${log.is_blocked ? 'bg-red-50/50' : ''}" data-search="${(log.phone || '').toLowerCase()} ${(log.mac_address || '').toLowerCase()} ${(log.ip_address || '').toLowerCase()}">
                <td class="px-4 py-3 text-xs text-gray-600">${date}</td>
                <td class="px-4 py-3 text-sm">${log.phone || '-'}</td>
                <td class="px-4 py-3 font-mono text-xs text-gray-600">${log.mac_address || '-'}${blockedBadge}</td>
                <td class="px-4 py-3 text-xs text-gray-500">${log.ip_address || '-'}</td>
                <td class="px-4 py-3 text-center"><span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-bold ${log.bypass_number > 2 ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700'}">${log.bypass_number}</span></td>
                <td class="px-4 py-3 text-center">${statusBadge}</td>
                <td class="px-4 py-3 text-xs text-gray-500">${log.deny_reason || '-'}</td>
                <td class="px-4 py-3 text-center">
                    <div class="flex items-center justify-center gap-1">
                    ${log.was_denied && log.bypass_number > 2 ? `
                        <button onclick="resetBypass('${log.mac_address || ''}', '${log.phone || ''}')" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-amber-50 text-amber-700 border border-amber-300 rounded-lg text-xs font-medium hover:bg-amber-100 transition" title="Resetar contador de bypass">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Resetar
                        </button>
                    ` : ''}
                    ${log.mac_address ? (log.is_blocked ? `
                        <button onclick="unblockBypass('${log.mac_address || ''}', '${log.phone || ''}')" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-green-50 text-green-700 border border-green-300 rounded-lg text-xs font-medium hover:bg-green-100 transition" title="Desbloquear bypass">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>
                            Desbloquear
                        </button>
                    ` : `
                        <button onclick="blockBypass('${log.mac_address || ''}', '${log.phone || ''}')" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-red-50 text-red-700 border border-red-300 rounded-lg text-xs font-medium hover:bg-red-100 transition" title="Bloquear bypass por 12h">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                            Bloquear 12h
                        </button>
                    `) : ''}
                    </div>
                </td>
            </tr>`;
        }).join('');

    } catch (err) {
        tbody.innerHTML = `<tr><td colspan="8" class="px-4 py-8 text-center text-red-500">Erro: ${err.message}</td></tr>`;
    }
}

function filterTable() {
    const query = document.getElementById('search-input').value.toLowerCase();
    const activeContent = document.getElementById('content-' + currentTab);
    activeContent.querySelectorAll('.user-row').forEach(row => {
        const match = row.dataset.search.includes(query);
        row.style.display = match ? '' : 'none';
    });
}

async function resetBypass(mac, phone) {
    if (!confirm(`Resetar contador de bypass para:\nMAC: ${mac || 'N/A'}\nTelefone: ${phone || 'N/A'}\n\nO usuário poderá usar mais 2 liberações temporárias.`)) return;

    try {
        const res = await fetch('/admin/mikrotik/remote/reset-bypass', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ mac: mac || null, phone: phone || null })
        });
        const data = await res.json();

        if (data.success) {
            showToast(data.message, 'success');
            loadBypassLogs();
        } else {
            showToast(data.error || 'Erro ao resetar', 'error');
        }
    } catch (e) {
        showToast('Erro de conexão', 'error');
    }
}

async function blockBypass(mac, phone) {
    if (!confirm(`🚫 Bloquear bypass por 12 HORAS para:\nMAC: ${mac || 'N/A'}\nTelefone: ${phone || 'N/A'}\n\nO usuário NÃO poderá usar liberação temporária durante esse período.`)) return;

    try {
        const res = await fetch('/admin/mikrotik/remote/block-bypass', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ mac: mac || null, phone: phone || null })
        });
        const data = await res.json();

        if (data.success) {
            showToast(data.message, 'success');
            loadBypassLogs();
        } else {
            showToast(data.error || 'Erro ao bloquear', 'error');
        }
    } catch (e) {
        showToast('Erro de conexão', 'error');
    }
}

async function unblockBypass(mac, phone) {
    if (!confirm(`✅ Desbloquear bypass para:\nMAC: ${mac || 'N/A'}\n\nO usuário poderá usar liberação temporária novamente.`)) return;

    try {
        const res = await fetch('/admin/mikrotik/remote/unblock-bypass', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ mac: mac || null, phone: phone || null })
        });
        const data = await res.json();

        if (data.success) {
            showToast(data.message, 'success');
            loadBypassLogs();
        } else {
            showToast(data.error || 'Erro ao desbloquear', 'error');
        }
    } catch (e) {
        showToast('Erro de conexão', 'error');
    }
}

// ========== Utils ==========

function formatDate(dateString) {
    if (!dateString) return '-';
    const d = new Date(dateString);
    return d.toLocaleDateString('pt-BR') + ' ' + d.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
}

function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    const colors = {
        success: 'bg-emerald-600',
        error: 'bg-red-600',
        info: 'bg-blue-600'
    };
    toast.className = `fixed top-4 right-4 z-[100] ${colors[type] || colors.info} text-white px-5 py-3 rounded-xl shadow-lg text-sm font-medium flex items-center gap-2 transform transition-all duration-300`;

    const icon = type === 'success' ? '✅' : type === 'error' ? '❌' : 'ℹ️';
    toast.innerHTML = `<span>${icon}</span> ${message}`;

    document.body.appendChild(toast);
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// ========== Ônibus ==========

async function loadBuses() {
    const container = document.getElementById('buses-list');
    container.innerHTML = '<p class="text-center text-muted text-sm py-8">Carregando...</p>';

    try {
        const resp = await fetch('/admin/mikrotik/remote/buses');
        const data = await resp.json();

        if (!data.success) throw new Error(data.error || 'Erro');

        const buses = data.buses;
        document.getElementById('badge-buses').textContent = buses.length;

        if (buses.length === 0) {
            container.innerHTML = `
                <div class="text-center py-10">
                    <div class="w-12 h-12 bg-surface rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    </div>
                    <p class="text-sm font-medium text-ink2">Nenhum ônibus cadastrado</p>
                    <p class="text-[10px] text-muted mt-1">Os ônibus aparecem automaticamente quando o MikroTik sincroniza pela primeira vez</p>
                </div>`;
            return;
        }

        container.innerHTML = buses.map(bus => {
            const isOnline = bus.last_sync_at && (new Date() - new Date(bus.last_sync_at)) < 600000;
            const syncAgo = bus.last_sync_at ? timeAgo(new Date(bus.last_sync_at)) : 'Nunca';

            return `
            <div class="bg-surface border border-border rounded-xl p-4 hover:shadow-hover transition-all" id="bus-${bus.id}">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br ${isOnline ? 'from-green-dark to-green' : 'from-gray-400 to-gray-500'} rounded-xl flex items-center justify-center flex-shrink-0 shadow-card">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-2">
                            <input type="text" value="${bus.name}" id="bus-name-${bus.id}"
                                   class="flex-1 px-3 py-1.5 text-sm font-bold text-ink bg-white border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-green/30 focus:border-green transition-all">
                            <span class="text-[9px] font-bold uppercase tracking-wider px-2 py-0.5 rounded ${isOnline ? 'bg-green/10 text-green' : 'bg-surface text-muted border border-border'}">${isOnline ? 'Online' : 'Offline'}</span>
                            <button onclick="saveBus(${bus.id})" class="px-3 py-1.5 bg-green hover:bg-green-light text-white font-semibold text-[10px] rounded-lg transition-colors shadow-card">
                                Salvar
                            </button>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="text-[9px] font-bold text-muted uppercase tracking-wider">Serial MikroTik</label>
                                <p class="text-xs font-mono text-ink2 bg-white border border-border rounded-lg px-2.5 py-1.5 mt-0.5">${bus.mikrotik_serial}</p>
                            </div>
                            <div>
                                <label class="text-[9px] font-bold text-muted uppercase tracking-wider">Placa</label>
                                <input type="text" value="${bus.plate || ''}" id="bus-plate-${bus.id}" placeholder="ABC-1234"
                                       class="w-full text-xs text-ink bg-white border border-border rounded-lg px-2.5 py-1.5 mt-0.5 focus:outline-none focus:ring-2 focus:ring-green/30 focus:border-green transition-all">
                            </div>
                        </div>
                        <div class="mt-2">
                            <label class="text-[9px] font-bold text-muted uppercase tracking-wider">Rota</label>
                            <input type="text" value="${bus.route_description || ''}" id="bus-route-${bus.id}" placeholder="Ex: Palmas → Araguaína"
                                   class="w-full text-xs text-ink bg-white border border-border rounded-lg px-2.5 py-1.5 mt-0.5 focus:outline-none focus:ring-2 focus:ring-green/30 focus:border-green transition-all">
                        </div>
                        <p class="text-[9px] text-muted mt-2">Último sync: ${syncAgo} · IP: ${bus.last_public_ip || '—'}</p>
                    </div>
                </div>
            </div>`;
        }).join('');

    } catch (e) {
        container.innerHTML = '<p class="text-center text-red text-sm py-8">Erro ao carregar ônibus</p>';
        console.error(e);
    }
}

function timeAgo(date) {
    const seconds = Math.floor((new Date() - date) / 1000);
    if (seconds < 60) return 'agora';
    if (seconds < 3600) return Math.floor(seconds / 60) + 'min atrás';
    if (seconds < 86400) return Math.floor(seconds / 3600) + 'h atrás';
    return Math.floor(seconds / 86400) + 'd atrás';
}

async function saveBus(id) {
    const name = document.getElementById(`bus-name-${id}`).value.trim();
    const plate = document.getElementById(`bus-plate-${id}`).value.trim();
    const route = document.getElementById(`bus-route-${id}`).value.trim();

    if (!name) return showToast('Nome é obrigatório', 'error');

    try {
        const resp = await fetch('/admin/mikrotik/remote/buses/update', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ id, name, plate: plate || null, route_description: route || null })
        });
        const data = await resp.json();

        if (data.success) {
            showToast(data.message, 'success');
        } else {
            showToast(data.error || 'Erro ao salvar', 'error');
        }
    } catch (e) {
        showToast('Erro de conexão', 'error');
    }
}
</script>
@endsection
