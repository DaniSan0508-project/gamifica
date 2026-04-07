<div>
    <x-slot name="header">
        <h2 class="font-display text-2xl font-bold text-on-surface tracking-tight">
            {{ __('Painel de Controle - ') }} <span class="text-primary-500">{{ auth()->user()->company->name }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Grid de KPIs -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Colaboradores -->
                <div class="bg-surface-lowest overflow-hidden rounded-3xl p-6 transition-all duration-300 hover:shadow-ambient group">
                    <div class="flex flex-col h-full justify-between">
                        <div class="flex justify-between items-start mb-4">
                            <p class="font-label text-xs font-bold text-gray-500 uppercase tracking-widest">Colaboradores</p>
                            <div class="p-2.5 rounded-xl bg-primary-500/10 text-primary-600 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                        </div>
                        <p class="font-display text-4xl font-bold text-on-surface">{{ $totalUsers }}</p>
                    </div>
                </div>

                <!-- Pontos Distribuídos -->
                <div class="bg-surface-lowest overflow-hidden rounded-3xl p-6 transition-all duration-300 hover:shadow-ambient group">
                    <div class="flex flex-col h-full justify-between">
                        <div class="flex justify-between items-start mb-4">
                            <p class="font-label text-xs font-bold text-gray-500 uppercase tracking-widest">Pontos Ganhos</p>
                            <div class="p-2.5 rounded-xl bg-tertiary-500/10 text-tertiary-500 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        <p class="font-display text-4xl font-bold text-on-surface">{{ number_format($totalPointsAwarded, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Pontos Resgatados -->
                <div class="bg-surface-lowest overflow-hidden rounded-3xl p-6 transition-all duration-300 hover:shadow-ambient group">
                    <div class="flex flex-col h-full justify-between">
                        <div class="flex justify-between items-start mb-4">
                            <p class="font-label text-xs font-bold text-gray-500 uppercase tracking-widest">Pontos Gastos</p>
                            <div class="p-2.5 rounded-xl bg-secondary-500/10 text-secondary-500 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            </div>
                        </div>
                        <p class="font-display text-4xl font-bold text-on-surface">{{ number_format($totalPointsRedeemed, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Pedidos Pendentes -->
                <div class="bg-surface-lowest overflow-hidden rounded-3xl p-6 transition-all duration-300 hover:shadow-ambient group">
                    <div class="flex flex-col h-full justify-between">
                        <div class="flex justify-between items-start mb-4">
                            <p class="font-label text-xs font-bold text-gray-500 uppercase tracking-widest">Pedidos Pendentes</p>
                            <div class="p-2.5 rounded-xl bg-orange-500/10 text-orange-500 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </div>
                        </div>
                        <p class="font-display text-4xl font-bold text-on-surface">{{ $pendingOrders }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Atividade da Empresa -->
                <div class="lg:col-span-2">
                    <div class="bg-surface-lowest overflow-hidden rounded-3xl h-full p-2">
                        <div class="p-6 flex justify-between items-center">
                            <h3 class="font-display text-xl font-bold text-on-surface">Atividade Recente</h3>
                            <span class="font-label text-xs font-bold text-primary-600 uppercase tracking-widest bg-primary-500/10 px-3 py-1.5 rounded-full">Tempo Real</span>
                        </div>
                        <div class="space-y-1 px-4 pb-4">
                            @forelse($recentActivity as $log)
                                <div class="p-4 flex items-center rounded-2xl hover:bg-surface transition-colors {{ $loop->index % 2 === 0 ? 'bg-surface-lowest' : 'bg-surface-low/30' }}">
                                    <div class="h-10 w-10 rounded-full bg-secondary-500/10 flex-shrink-0 flex items-center justify-center text-secondary-600 font-display font-bold uppercase mr-4">
                                        {{ substr($log->user->name ?? '?', 0, 1) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-sans text-sm text-on-surface leading-snug">
                                            <span class="font-bold">{{ $log->user->name ?? 'Usuário' }}</span> 
                                            {{ $log->message }}
                                        </p>
                                        <p class="font-label text-xs text-gray-400 mt-1 uppercase tracking-wider">{{ $log->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="p-12 text-center font-sans text-gray-400 text-sm">
                                    Nenhuma atividade registrada ainda na sua empresa.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Ações Rápidas -->
                <div class="space-y-6">
                    <div class="bg-surface-lowest overflow-hidden rounded-3xl p-6">
                        <h3 class="font-display text-xl font-bold text-on-surface mb-6">Ações Rápidas</h3>
                        
                        <div class="space-y-4">
                            <a href="{{ route('admin.missions.create') }}" class="flex items-center p-4 rounded-2xl bg-surface-low/50 hover:bg-primary-500/5 hover:shadow-ambient group transition-all duration-300">
                                <div class="p-2.5 rounded-xl bg-primary-500/10 text-primary-600 mr-4 group-hover:bg-primary-500 group-hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </div>
                                <span class="font-sans text-sm font-bold text-on-surface">Lançar Nova Missão</span>
                            </a>

                            <a href="{{ route('admin.rewards.create') }}" class="flex items-center p-4 rounded-2xl bg-surface-low/50 hover:bg-tertiary-500/5 hover:shadow-ambient group transition-all duration-300">
                                <div class="p-2.5 rounded-xl bg-tertiary-500/10 text-tertiary-600 mr-4 group-hover:bg-tertiary-500 group-hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <span class="font-sans text-sm font-bold text-on-surface">Adicionar Prêmio</span>
                            </a>

                            <a href="{{ route('admin.orders.index') }}" class="flex items-center p-4 rounded-2xl bg-surface-low/50 hover:bg-orange-500/5 hover:shadow-ambient group transition-all duration-300">
                                <div class="p-2.5 rounded-xl bg-orange-500/10 text-orange-600 mr-4 group-hover:bg-orange-500 group-hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                </div>
                                <span class="font-sans text-sm font-bold text-on-surface">Gerenciar Entregas</span>
                            </a>
                        </div>
                    </div>

                    <!-- Card de Saúde do Programa (Simulação) -->
                    <div class="bg-gradient-to-br from-primary-500 to-secondary-500 overflow-hidden shadow-ambient rounded-3xl p-8 text-white relative">
                        <div class="absolute -right-4 -top-4 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                        <h4 class="font-label text-xs font-bold uppercase tracking-widest opacity-80 mb-6">Engajamento</h4>
                        <div class="flex items-end justify-between relative z-10">
                            <div>
                                <p class="font-display text-5xl font-bold mb-2">84%</p>
                                <p class="font-sans text-sm opacity-90">Colaboradores ativos esta semana</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
