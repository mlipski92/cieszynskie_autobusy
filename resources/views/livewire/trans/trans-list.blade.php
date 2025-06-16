<div class="p-6 bg-white rounded-xl shadow-md">
    <h2 class="text-2xl font-bold mb-4 text-gray-800">Lista przewoźników</h2>

    @if (session()->has('message'))
        <div class="mb-4 text-green-700 bg-green-100 p-3 rounded">
            {{ session('message') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nazwa</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utworzono</th>
                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Akcje</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($transList as $trans)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $trans->id }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $trans->name }}</td>
                        <td class="px-4 py-2 text-sm text-gray-600">{{ $trans->created_at->format('Y-m-d H:i') }}</td>
                        <td class="px-4 py-2 text-center">
                            <button wire:click="delete({{ $trans->id }})" class="text-red-600 hover:text-red-800">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-sm text-gray-500">Brak danych</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
