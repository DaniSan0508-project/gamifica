<div>
    <x-slot name="header">
        <h2 class="font-display text-2xl font-bold text-on-surface tracking-tight">
            {{ __('Enviar Reconhecimento (Kudos)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-surface-lowest overflow-hidden rounded-3xl transition-shadow duration-300 hover:shadow-ambient">
                <div class="p-8 sm:p-12">
                    <form wire:submit="save">
                        <div class="mb-8">
                            <label for="receiver_id" class="block font-label text-sm font-bold text-on-surface uppercase tracking-widest mb-3">Para quem é o reconhecimento?</label>
                            <select wire:model="receiver_id" id="receiver_id" class="mt-1 block w-full rounded-2xl border-none shadow-sm focus:ring-2 focus:ring-primary-500 font-sans sm:text-base p-4 bg-surface-low transition-shadow" required>
                                <option value="">Selecione um colega...</option>
                                @foreach($colleagues as $colleague)
                                    <option value="{{ $colleague->id }}">{{ $colleague->name }} ({{ $colleague->role->value }})</option>
                                @endforeach
                            </select>
                            @error('receiver_id') <span class="font-sans text-sm text-red-600 mt-2 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-10">
                            <label for="message" class="block font-label text-sm font-bold text-on-surface uppercase tracking-widest mb-3">Sua Mensagem</label>
                            <textarea wire:model="message" id="message" rows="5" class="mt-1 block w-full rounded-2xl border-none shadow-sm focus:ring-2 focus:ring-primary-500 font-sans sm:text-base p-5 bg-surface-low transition-shadow resize-none" placeholder="Conte por que este colega merece um reconhecimento..."></textarea>
                            @error('message') <span class="font-sans text-sm text-red-600 mt-2 block">{{ $message }}</span> @enderror
                        </div>

                        @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                            <div class="mb-10 p-6 bg-gradient-to-r from-primary-500/5 to-secondary-500/5 rounded-3xl">
                                <label for="points_bonus" class="block font-label text-sm font-bold text-on-surface uppercase tracking-widest mb-3 flex items-center">
                                    <span class="mr-2">💰</span> Bônus em Pontos (Opcional)
                                </label>
                                <div class="relative mt-1">
                                    <input wire:model="points_bonus" type="number" id="points_bonus" min="0" class="block w-full rounded-2xl border-none shadow-sm focus:ring-2 focus:ring-primary-500 font-display text-lg font-bold p-4 bg-surface-lowest transition-shadow">
                                </div>
                                <p class="mt-3 font-sans text-xs text-gray-500">Apenas administradores podem enviar pontos via feedback.</p>
                                @error('points_bonus') <span class="font-sans text-sm text-red-600 mt-2 block">{{ $message }}</span> @enderror
                            </div>
                        @endif

                        <div class="flex justify-end gap-4 pt-4">
                            <a href="{{ route(auth()->user()->role === \App\Enums\UserRole::Admin ? 'admin.dashboard' : 'player.dashboard') }}" class="inline-flex items-center px-6 py-4 bg-transparent rounded-2xl font-label font-bold text-sm text-gray-500 uppercase tracking-widest hover:bg-surface-low transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                                Cancelar
                            </a>
                            <button type="submit" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-primary-500 to-primary-600 rounded-2xl font-label font-bold text-sm text-white uppercase tracking-widest hover:shadow-ambient active:scale-95 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all duration-300">
                                Enviar Kudos 🚀
                                <div wire:loading wire:target="save" class="ml-3 opacity-80">...</div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
