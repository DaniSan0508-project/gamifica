<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-display text-2xl font-bold text-on-surface tracking-tight">
                {{ __('Loja de Prêmios') }}
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
                    <span class="mr-4 text-2xl">🎁</span>
                    <p class="font-sans font-medium text-on-surface">{{ session('message') }}</p>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-8 bg-surface-lowest shadow-ambient border-l-4 border-red-500 p-5 rounded-2xl flex items-center" role="alert">
                    <span class="mr-4 text-2xl">⚠️</span>
                    <p class="font-sans font-medium text-on-surface">{{ session('error') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse ($rewards as $reward)
                    <div class="bg-surface-lowest rounded-3xl overflow-hidden flex flex-col hover:shadow-ambient transition-all duration-500 group relative">
                        
                        <!-- Imagem do Prêmio (Starfield / Noise Effect Simul) -->
                        <div class="h-56 bg-secondary-600 relative overflow-hidden group">
                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-secondary-400 to-secondary-600 opacity-80 mix-blend-overlay"></div>
                            @if($reward->image_path)
                                <img src="{{ asset('storage/' . $reward->image_path) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out relative z-10 mix-blend-luminosity opacity-90">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-7xl group-hover:scale-110 transition-transform duration-700 ease-out relative z-10 drop-shadow-2xl">
                                    🎁
                                </div>
                            @endif
                            
                            <!-- Glassmorphic Tag -->
                            <div class="absolute top-4 right-4 bg-surface-lowest/80 backdrop-blur-xl px-4 py-1.5 rounded-full shadow-sm z-20">
                                <span class="font-label text-xs font-bold text-on-surface tracking-widest uppercase">{{ $reward->stock_quantity }} em estoque</span>
                            </div>
                        </div>

                        <!-- Detalhes do Prêmio -->
                        <div class="p-6 flex-1 flex flex-col">
                            <h4 class="font-display text-xl font-bold text-on-surface leading-tight mb-4">{{ $reward->title }}</h4>
                            
                            <div class="mt-auto pt-4 flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="font-label text-xs text-gray-400 uppercase font-bold tracking-widest">Custo</span>
                                    <span class="font-display text-2xl font-black text-primary-500">{{ $reward->cost }} <span class="font-label text-xs uppercase opacity-70">pts</span></span>
                                </div>

                                <button 
                                    wire:click="redeem('{{ $reward->id }}')"
                                    wire:loading.attr="disabled"
                                    {{ auth()->user()->points_balance < $reward->cost ? 'disabled' : '' }}
                                    class="px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-label font-bold text-sm hover:shadow-ambient transition-all disabled:from-surface-high disabled:to-surface-high disabled:text-gray-400 disabled:shadow-none"
                                >
                                    Resgatar
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-surface-low p-20 rounded-3xl text-center">
                        <span class="text-6xl mb-6 block drop-shadow-md">📦</span>
                        <h4 class="font-display text-2xl font-bold text-on-surface">Loja Vazia</h4>
                        <p class="font-sans text-gray-500 mt-3">Nenhum prêmio disponível para resgate no momento.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
