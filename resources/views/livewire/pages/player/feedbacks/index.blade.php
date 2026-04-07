<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Meus Reconhecimentos (Kudos)') }}
            </h2>
            <a href="{{ route('feedbacks.send') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                Enviar Kudos 🚀
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('message'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                    {{ session('message') }}
                </div>
            @endif

            <div class="space-y-6">
                @forelse ($feedbacks as $feedback)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-indigo-50 p-6 flex items-start space-x-4 hover:shadow-md transition-shadow">
                        <div class="h-12 w-12 rounded-full bg-indigo-100 flex-shrink-0 flex items-center justify-center text-indigo-600 font-bold text-lg uppercase">
                            {{ substr($feedback->sender->name ?? '?', 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="text-lg font-bold text-gray-900">{{ $feedback->sender->name ?? 'Colega' }}</h4>
                                    <p class="text-xs text-gray-400 uppercase tracking-widest font-bold">{{ $feedback->created_at->diffForHumans() }}</p>
                                </div>
                                @if($feedback->points_bonus > 0)
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-black border border-green-200">
                                        + {{ $feedback->points_bonus }} PONTOS 🎁
                                    </span>
                                @endif
                            </div>
                            <div class="mt-4 text-gray-700 italic leading-relaxed italic">
                                "{{ $feedback->message }}"
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-gray-50 border-2 border-dashed border-gray-200 p-20 rounded-3xl text-center">
                        <span class="text-6xl mb-4 block">💝</span>
                        <h4 class="text-xl font-bold text-gray-800">Nenhum reconhecimento ainda</h4>
                        <p class="text-gray-500 mt-2">Que tal ser o primeiro a enviar um reconhecimento para um colega?</p>
                        <a href="{{ route('feedbacks.send') }}" class="mt-6 inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-colors">
                            Enviar Primeiro Kudos
                        </a>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $feedbacks->links() }}
            </div>
        </div>
    </div>
</div>
