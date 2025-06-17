<div>
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1">
            <div class="flex items-center">
                <label for="name">Nazwa linii:</label>
            </div>
            <div>
                <x-input id="name" wire:model="name" />
            </div>
        </div>
        <br>
        <div class="grid grid-cols-1">
            <div class="flex items-center">
                <label for="direction">Kierunek:</label>
            </div>
            <div>
                <x-input id="direction" wire:model="direction" />
            </div>
        </div>
        <br>
        <div class="grid grid-cols-1">
            <div class="flex items-center">
                <label for="trans">Przewoźnik:</label>
            </div>
            <div>
                <select class="w-full" name="trans"  wire:model="trans">
                    <option value="null">-- WYBIERZ --</option>
                    @foreach($transList as $trans)
                        <option value="{{ $trans->id }}">{{  $trans->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <br>
        <x-form-button>Zapisz</x-form-button>
    </form>
    <br />
    <div class="p-5 bg-[#f4f2f2]">
        <h2 class="text-xl">Lista przystanków</h2>
        <div class="p-3">
            <span>Dodaj przystanek</span>
            <x-input id="searchstop" wire:model.live.debounce="searchstop" />
            <div>
                <ul>
                    @foreach($stopList as $stop)
                        <li class="flex items-center gap-4 py-2 border-b bg-[#ece1ce] px-4 mb-1">
                            <span class="flex-1 font-medium">
                                {{ $stop->name }} <span class="text-sm text-gray-500">(kier.: {{ $stop->direction }})</span>
                            </span>

                            <div class="w-[100px]">
                                <x-input wire:model.live.debounce="times.{{ $stop->id }}" placeholder="HH:MM" />
                            </div>
                            @if ($errors->has("times.$stop->id"))
                                <p class="text-sm text-red-600 mt-1">{{ $errors->first("times.$stop->id") }}</p>
                            @endif
                            @if(($times[$stop->id] ?? '') !== '')
                            <span
                                wire:click="addStopToLine({{ $stop->id }}, {{ $lineId }}, @js($times[$stop->id] ?? ''), {{ $loop->index }})"
                                class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded cursor-pointer transition"
                            >
                                Dodaj (+)
                            </span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
        <div class="bg-[#eee]">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Przystanek</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kierunek</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Godzina</th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Akcje</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="sortable-list" x-data x-init="initSortable($el, $wire)">
                    @foreach($stopsList as $stop)
                    <tr class="hover:bg-gray-50 transition sortable-item" data-id="{{ $stop->id }}">
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $stop->id }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $stop->stop->name }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $stop->stop->direction }}</td>
                        <td class="px-4 py-2 text-sm text-gray-600">{{ $stop->time }}</td>
                        <td class="px-4 py-2 text-center">
                            <div class="flex gap-[10px] justify-center">
                                <button
                                    wire:click="removeStopFromLine({{ $stop->id }})"
                                    class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded transition"
                                >
                                    Usuń
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
 <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    window.initSortable = (el, wire) => {
    const readPositions = () => {
        const stopElements = document.querySelectorAll("#sortable-list .sortable-item");
        const stopElementsContainer = document.querySelectorAll("#sortable-list");

        let stopPositions = [];
        let numeration = 0;
        // console.log(stopElements);
        stopElements.forEach( el => {
            // console.log(el.dataset.id,numeration++);
            // const newPosition = [stopId: el.dataset.id, order: numeration++];
            const newPosition = { stopId: el.dataset.id, order: numeration++ };
            stopPositions.push(newPosition);
        });
        return stopPositions;

    }
    const sortable = new Sortable(document.getElementById('sortable-list'), {
        animation: 150,
        onEnd: function (evt) {
            // console.log(readPositions());
            // readPositions();
            wire.updateOrder(readPositions());
        }
    });
    }

 
</script>
</div>
