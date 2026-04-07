<div>
    <x-slot name="header">
        <h2 class="font-display text-2xl font-bold text-on-surface tracking-tight">
            {{ __('Meu Perfil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            @if (session()->has('message'))
                <div class="mb-8 bg-surface-lowest shadow-ambient border-l-4 border-tertiary-500 p-5 rounded-2xl flex items-center" role="alert">
                    <span class="mr-4 text-2xl">✨</span>
                    <p class="font-sans font-medium text-on-surface">{{ session('message') }}</p>
                </div>
            @endif

            <div class="bg-surface-lowest overflow-hidden rounded-3xl transition-shadow duration-300 hover:shadow-ambient">
                <div class="p-8 sm:p-12">
                    <form wire:submit="save">
                        
                        <!-- Avatar Upload Area -->
                        <div class="mb-10 flex flex-col items-center sm:flex-row sm:items-start gap-8">
                            <div class="relative group">
                                <div class="h-32 w-32 rounded-full overflow-hidden bg-surface-low border-4 border-white shadow-md flex items-center justify-center">
                                    @if ($form->avatar)
                                        <img src="{{ $form->avatar->temporaryUrl() }}" class="w-full h-full object-cover">
                                    @elseif (auth()->user()->avatar_path)
                                        <img src="{{ asset('storage/' . auth()->user()->avatar_path) }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="font-display font-bold text-4xl text-primary-300 uppercase">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </span>
                                    @endif
                                </div>
                                <div class="absolute inset-0 rounded-full bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer" onclick="document.getElementById('avatar_upload').click()">
                                    <span class="text-white font-label text-xs font-bold tracking-widest uppercase">Alterar</span>
                                </div>
                                <input wire:model="form.avatar" type="file" id="avatar_upload" class="hidden" accept="image/*">
                            </div>
                            <div class="flex-1 text-center sm:text-left mt-2">
                                <h3 class="font-display text-xl font-bold text-on-surface">Sua Foto</h3>
                                <p class="font-sans text-sm text-gray-500 mt-2 max-w-sm">Esta imagem será exibida no feed, nos rankings da empresa e ao enviar Kudos. Escolha uma foto legal!</p>
                                @error('form.avatar') <span class="font-sans text-sm text-red-600 mt-2 block">{{ $message }}</span> @enderror
                                <div wire:loading wire:target="form.avatar" class="mt-2 text-primary-500 font-label font-bold text-xs uppercase tracking-widest">Enviando...</div>
                            </div>
                        </div>

                        <!-- Basic Information -->
                        <div class="space-y-8">
                            <div>
                                <label for="name" class="block font-label text-sm font-bold text-on-surface uppercase tracking-widest mb-3">Nome</label>
                                <input wire:model="form.name" id="name" type="text" class="block w-full rounded-2xl border-none shadow-sm focus:ring-2 focus:ring-primary-500 font-sans sm:text-base p-4 bg-surface-low transition-shadow" required>
                                @error('form.name') <span class="font-sans text-sm text-red-600 mt-2 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="email" class="block font-label text-sm font-bold text-on-surface uppercase tracking-widest mb-3">Email</label>
                                <input wire:model="form.email" id="email" type="email" class="block w-full rounded-2xl border-none shadow-sm focus:ring-2 focus:ring-primary-500 font-sans sm:text-base p-4 bg-surface-low transition-shadow" required>
                                @error('form.email') <span class="font-sans text-sm text-red-600 mt-2 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex justify-end gap-4 pt-10 mt-6 border-t border-surface-low">
                            <button type="submit" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-primary-500 to-primary-600 rounded-2xl font-label font-bold text-sm text-white uppercase tracking-widest hover:shadow-ambient active:scale-95 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all duration-300">
                                Salvar Alterações
                                <div wire:loading wire:target="save" class="ml-3 opacity-80">...</div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
