<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meus Resgates e Vouchers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($orders as $order)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-md transition-shadow">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-lg font-bold text-gray-900 leading-tight">{{ $order->reward->title ?? 'Prêmio Removido' }}</h4>
                                <span class="px-2 py-1 text-xs font-bold rounded-lg {{ $order->status === \App\Enums\OrderStatus::Delivered ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ $order->status === \App\Enums\OrderStatus::Delivered ? 'Entregue' : 'Pendente' }}
                                </span>
                            </div>

                            <div class="bg-indigo-50 border-2 border-dashed border-indigo-200 p-4 rounded-xl text-center mb-4">
                                <p class="text-xs text-indigo-400 uppercase font-bold tracking-widest mb-1">Código do Voucher</p>
                                <p class="text-2xl font-black text-indigo-600 tracking-wider">{{ $order->voucher_code }}</p>
                            </div>

                            <div class="flex justify-between text-sm text-gray-500">
                                <span>Custo: <strong>{{ $order->points_cost }} pts</strong></span>
                                <span>{{ $order->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        
                        @if($order->status === \App\Enums\OrderStatus::Pending)
                            <div class="bg-gray-50 px-6 py-3 border-t border-gray-100">
                                <p class="text-xs text-gray-400 italic text-center">Apresente este código no RH para retirar seu prêmio.</p>
                            </div>
                        @else
                            <div class="bg-green-50 px-6 py-3 border-t border-green-100">
                                <p class="text-xs text-green-600 font-bold text-center italic">Prêmio retirado em {{ $order->delivered_at->format('d/m/Y') }}</p>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="col-span-full bg-gray-50 border-2 border-dashed border-gray-200 p-20 rounded-3xl text-center">
                        <span class="text-6xl mb-4 block">🎟️</span>
                        <h4 class="text-xl font-bold text-gray-800">Nenhum resgate ainda</h4>
                        <p class="text-gray-500 mt-2">Você ainda não realizou nenhum resgate na loja. Que tal começar agora?</p>
                        <a href="{{ route('player.shop.index') }}" class="mt-6 inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-colors">
                            Ir para a Loja
                        </a>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
