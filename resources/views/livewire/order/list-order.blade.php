<div class="p-6 bg-white rounded-xl shadow-md">
    <h2 class="text-2xl font-bold mb-4 text-gray-800">Lista zamówień</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imię i nazwisko</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Linia</th>
                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Relacja</th>
                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Kwota</th>
                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($orderList as $order)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $order->id }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $order->name }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $order->line }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $order->relation }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $order->cost }}</td>
                        <td class="px-4 py-2 text-sm text-gray-600">{{ $order->created_at->format('Y-m-d H:i') }}</td>
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
