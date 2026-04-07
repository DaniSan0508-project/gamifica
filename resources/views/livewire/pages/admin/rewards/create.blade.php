<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Novo Prêmio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form wire:submit="save">
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Título do Prêmio</label>
                            <input wire:model="form.title" id="title" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required />
                            @error('form.title') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="cost" class="block text-sm font-medium text-gray-700">Custo (Pontos)</label>
                                <input wire:model="form.cost" id="cost" type="number" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required />
                                @error('form.cost') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="stock_quantity" class="block text-sm font-medium text-gray-700">Quantidade em Estoque</label>
                                <input wire:model="form.stock_quantity" id="stock_quantity" type="number" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required />
                                @error('form.stock_quantity') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="image" class="block text-sm font-medium text-gray-700">Imagem do Prêmio</label>
                            <input wire:model="form.image" id="image" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                            
                            <div wire:loading wire:target="form.image" class="mt-2 text-sm text-gray-500 italic">Enviando imagem...</div>
                            
                            @if ($form->image)
                                <div class="mt-4">
                                    <p class="text-xs text-gray-500 mb-2">Pré-visualização:</p>
                                    <img src="{{ $form->image->temporaryUrl() }}" class="h-32 w-32 object-cover rounded-lg shadow-md">
                                </div>
                            @endif
                            @error('form.image') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end gap-4">
                            <a href="{{ route('admin.rewards.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                Cancelar
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Salvar Prêmio
                                <div wire:loading wire:target="save" class="ml-2">...</div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
