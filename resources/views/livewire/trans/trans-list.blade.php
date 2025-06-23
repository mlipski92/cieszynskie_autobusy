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
                            <div class="flex gap-[10px] justify-center">
                                @livewire('delete-button', [
                                    'resource' => 'trans',
                                    'model' => App\Models\Trans::class,
                                    'id' => $trans->id,
                                    'returnRoute' => 'trans.list'
                                ])
                                <a href="{{ route('trans.edit', $trans->id) }}" class="text-blue-600 hover:underline block">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>
                            </div>
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

    <a href="{{  route("trans.create") }}" class="text-black">Dodaj nowego przewoźnika</a>
</div>
