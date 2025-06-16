<div>
    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1">
            <div class="flex items-center">
                <label for="name">Nazwa przewoźnika:</label>
            </div>
            <div>
                <input type="text" id="name" wire:model="name" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
            </div>
        </div>
        <br>
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-md shadow-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-400">Zapisz zmiany</button>
    </form>
</div>
