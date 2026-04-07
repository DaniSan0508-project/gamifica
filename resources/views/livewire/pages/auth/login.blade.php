<div>
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Sign in to your account</h2>

    <form wire:submit="save">
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
            <input wire:model="form.email" id="email" type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required autofocus autocomplete="username" />
            @error('form.email') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input wire:model="form.password" id="password" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required autocomplete="current-password" />
            @error('form.password') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label for="remember" class="ml-2 block text-sm text-gray-900">Remember me</label>
            </div>
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Sign in
                <div wire:loading wire:target="save" class="ml-2">...</div>
            </button>
        </div>
    </form>
</div>
