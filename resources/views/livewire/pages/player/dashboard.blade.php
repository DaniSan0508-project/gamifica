<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-display text-2xl font-bold text-on-surface tracking-tight">
                {{ __('Minha Jornada') }}
            </h2>
            <div class="flex items-center bg-primary-500 text-white px-5 py-2.5 rounded-full shadow-ambient transition-transform hover:scale-105">
                <span class="font-display font-bold text-xl">{{ auth()->user()->points_balance }}</span>
                <span class="ml-1.5 font-label text-xs uppercase tracking-widest opacity-80">pts</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('message'))
                <div class="mb-8 bg-surface-lowest shadow-ambient border-l-4 border-tertiary-500 p-5 rounded-2xl flex items-center" role="alert">
                    <span class="mr-4 text-2xl">✨</span>
                    <p class="font-sans font-medium text-on-surface">{{ session('message') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Coluna Principal -->
                <div class="lg:col-span-8 space-y-10">
                    
                    <!-- Missões Disponíveis -->
                    <section>
                        <h3 class="font-display text-xl font-bold text-on-surface mb-6 flex items-center">
                            <span class="text-primary-500 mr-2">⚡</span> Missões Ativas
                        </h3>

                        <div class="space-y-5">
                            @forelse ($availableMissions as $mission)
                                <div class="bg-surface-lowest p-6 rounded-3xl transition-all duration-300 hover:shadow-ambient group relative overflow-hidden">
                                    <div class="absolute top-0 left-0 w-1.5 h-full bg-gradient-to-b from-primary-400 to-primary-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                        <div class="flex-1">
                                            <h4 class="font-display text-xl font-bold text-on-surface">{{ $mission->title }}</h4>
                                            <p class="font-sans text-gray-500 mt-2 text-sm leading-relaxed">{{ $mission->description }}</p>
                                            
                                            <div class="mt-4 flex items-center">
                                                <div class="bg-surface text-primary-600 px-3 py-1 rounded-full font-label text-xs font-bold tracking-widest">
                                                    +{{ $mission->points_reward }} PTS
                                                </div>
                                            </div>
                                        </div>
                                        <button 
                                            wire:click="completeMission('{{ $mission->id }}')" 
                                            wire:loading.attr="disabled"
                                            class="shrink-0 px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-label font-bold text-sm tracking-wide hover:shadow-ambient transition-all disabled:opacity-50"
                                        >
                                            Completar
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="bg-surface-low p-12 rounded-3xl text-center">
                                    <p class="font-sans text-gray-500">Nenhuma missão no radar. Descanse! 🧘</p>
                                </div>
                            @endforelse
                        </div>
                    </section>

                    <!-- Feed da Empresa -->
                    <section>
                        <h3 class="font-display text-xl font-bold text-on-surface mb-6 flex items-center">
                            <span class="text-secondary-500 mr-2">📡</span> Feed da Empresa
                        </h3>
                        <div class="bg-surface-lowest rounded-3xl p-2">
                            @forelse ($activityFeed as $log)
                                <div class="p-4 flex items-start space-x-4 rounded-2xl hover:bg-surface transition-colors {{ $loop->index % 2 === 0 ? 'bg-surface-lowest' : 'bg-surface-low/30' }}">
                                    <div class="h-10 w-10 rounded-full bg-secondary-500/10 flex-shrink-0 flex items-center justify-center text-secondary-600 font-display font-bold uppercase">
                                        {{ substr($log->user->name ?? '?', 0, 1) }}
                                    </div>
                                    <div class="flex-1 min-w-0 pt-0.5">
                                        <p class="font-sans text-sm text-on-surface leading-snug">
                                            <span class="font-bold">{{ (optional($log->user)->id === auth()->id()) ? 'Você' : ($log->user->name ?? 'Usuário') }}</span> 
                                            {{ $log->message }}
                                        </p>
                                        <p class="font-label text-xs text-gray-400 mt-1.5 uppercase tracking-wider">{{ $log->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="p-8 text-center font-sans text-gray-400 text-sm">
                                    O feed está silencioso...
                                </div>
                            @endforelse
                        </div>
                    </section>

                </div>

                <!-- Colunas Laterais -->
                <div class="lg:col-span-4 space-y-10">
                    
                    <!-- Leaderboard -->
                    <section>
                        <h3 class="font-display text-xl font-bold text-on-surface mb-6 flex items-center">
                            <span class="text-secondary-500 mr-2">🏆</span> Top Rank
                        </h3>
                        <div class="bg-surface-lowest rounded-3xl overflow-visible relative pt-8 px-2 pb-2">
                            
                            @foreach ($leaderboard as $rankUser)
                                @php 
                                    $isCurrentUser = $rankUser->id === auth()->id();
                                @endphp

                                @if($loop->first)
                                    <!-- Campeão -->
                                    <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-11/12 bg-gradient-to-br from-secondary-500 to-primary-500 p-5 rounded-2xl shadow-ambient z-10 flex items-center {{ $isCurrentUser ? 'ring-2 ring-white' : '' }}">
                                        <div class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center font-display font-bold text-white shadow-sm">1</div>
                                        <div class="ml-4 flex-1">
                                            <p class="font-display text-lg font-bold text-white truncate">{{ $rankUser->name }}</p>
                                            <p class="font-label text-xs text-white/80 uppercase tracking-widest">{{ $rankUser->points_balance }} pts</p>
                                        </div>
                                        <span class="text-2xl drop-shadow-md">👑</span>
                                    </div>
                                    <div class="h-12"></div> <!-- Spacer under absolute element -->
                                @else
                                    <div class="p-4 flex items-center rounded-2xl transition-colors {{ $isCurrentUser ? 'bg-primary-500/5' : ($loop->index % 2 === 0 ? 'bg-surface-lowest' : 'bg-surface-low/30') }}">
                                        <div class="w-8 h-8 flex items-center justify-center rounded-full font-display font-bold text-sm {{ $loop->index === 1 ? 'bg-surface-high text-gray-700' : ($loop->index === 2 ? 'bg-orange-100 text-orange-700' : 'text-gray-400') }}">
                                            {{ $loop->iteration }}
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <p class="font-sans text-sm font-bold {{ $isCurrentUser ? 'text-primary-600' : 'text-on-surface' }} truncate">{{ $rankUser->name }}</p>
                                            <p class="font-label text-xs text-gray-500">{{ $rankUser->points_balance }} pts</p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            
                            @if($leaderboard->isEmpty())
                                <div class="p-8 text-center text-gray-400 text-sm font-sans">Sem posições ainda.</div>
                            @endif
                        </div>
                    </section>

                    <!-- Extrato Simplificado -->
                    <section>
                        <h3 class="font-display text-xl font-bold text-on-surface mb-6 flex items-center">
                            <span class="text-primary-500 mr-2">📜</span> Meu Extrato
                        </h3>

                        <div class="bg-surface-lowest rounded-3xl p-2">
                            @forelse ($recentTransactions as $transaction)
                                <div class="p-4 flex justify-between items-center rounded-2xl {{ $loop->index % 2 === 0 ? 'bg-surface-lowest' : 'bg-surface-low/30' }}">
                                    <div class="flex-1 pr-4">
                                        <p class="font-sans text-sm font-semibold text-on-surface truncate">{{ $transaction->description }}</p>
                                        <p class="font-label text-xs text-gray-400 mt-1">{{ $transaction->created_at->format('d/m') }}</p>
                                    </div>
                                    <div class="font-display font-bold {{ $transaction->amount > 0 ? 'text-tertiary-500' : 'text-red-500' }}">
                                        {{ $transaction->amount > 0 ? '+' : '' }}{{ $transaction->amount }}
                                    </div>
                                </div>
                            @empty
                                <div class="p-8 text-center font-sans text-gray-400 text-sm">
                                    Nenhuma transação.
                                </div>
                            @endforelse
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>
</div>
