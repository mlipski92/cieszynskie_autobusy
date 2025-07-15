@extends('layout.main')

@section('content') 

<div x-data="stopsSearch()" x-init="fetchStops('begin')" class="">

    <div class="grid grid-cols-2">
        <div class="p-5">
            <label>Z: </label>
            <div class="relative w-100">
                <input 
                    type="text" 
                    x-model="queryBegin" 
                    @input="filterStops('begin')"
                    placeholder="Wpisz nazwę przystanku..."
                    class="w-full border rounded p-2"
                    name="stopbegin"
                >
                <div 
                    x-show="filteredStopsBegin.length > 0" 
                    class="absolute bg-white border w-full mt-1 max-h-48 overflow-auto z-10"
                >
                    <template x-for="stop in filteredStopsBegin" :key="stop.id">
                        <div 
                            class="p-2 hover:bg-gray-100 cursor-pointer" 
                            @click="selectStopBegin(stop)"
                            x-text="stop.name"
                        ></div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Pole Do -->
        <div class="p-5">
            <label>Do: </label>
            <div class="relative w-100">
                <input 
                    type="text" 
                    x-model="queryEnd" 
                    @input="filterStops('end')"
                    placeholder="Wpisz nazwę przystanku..."
                    class="w-full border rounded p-2"
                    name="stopend"
                >
                <div 
                    x-show="filteredStopsEnd.length > 0" 
                    class="absolute bg-white border w-full mt-1 max-h-48 overflow-auto z-10"
                >
                    <template x-for="stop in filteredStopsEnd" :key="stop.id">
                        <div 
                            class="p-2 hover:bg-gray-100 cursor-pointer" 
                            @click="selectStopEnd(stop)"
                            x-text="stop.name"
                        ></div>
                    </template>
                </div>
            </div>
        </div>
    </div>


    <div class="p-5" x-show="lineData">
    <table class="table-auto border w-full">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">Odjazd</th>
                <th class="border p-2">Przyjazd</th>
                <th class="border p-2">Z</th>
                <th class="border p-2">Do</th>
                <th class="border p-2">Koszt</th>
                <th class="border p-2">Linia</th>
                <th class="border p-2"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border p-2" x-text="lineData.timeFrom"></td>
                <td class="border p-2" x-text="lineData.timeTo"></td>
                <td class="border p-2" x-text="lineData.locationFrom"></td>
                <td class="border p-2" x-text="lineData.locationTo"></td>
                <td class="border p-2" x-text="lineData.totalCost"></td>
                <td class="border p-2" x-text="lineData.lineName"></td>
                <td class="border p-2"><a href="">Kup bilet</a></td>
            </tr>
        </tbody>
    </table>
</div>

</div>



<script src="https://unpkg.com/alpinejs@3.13.0/dist/cdn.min.js" defer></script>

<script>
function stopsSearch() {
    return {
        stopsBegin: [],
        stopsEnd: [],
        filteredStopsBegin: [],
        filteredStopsEnd: [],
        selectedBeginId: null,
        queryBegin: '',
        queryEnd: '',
        lineData: null,

        fetchStops(option, selectedId = null) {
            let url = '';

            if (option === 'begin') {
                url = '{{ config('app.url') }}/api/stops';
            } else if (option === 'end' && selectedId) {
                url = `{{ config('app.url') }}/api/stopsbyselectedstop/${selectedId}`;
            } else {
                console.error('Niepoprawne wywołanie fetchStops');
                return;
            }

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    if (option === 'begin') {
                        this.stopsBegin = data;
                    } else if (option === 'end') {
                        this.stopsEnd = data;
                    }
                })
                .catch(err => console.error('Błąd pobierania przystanków:', err));
        },

        filterStops(option) {
            if (option === 'begin') {
                if (this.queryBegin.length === 0) {
                    this.filteredStopsBegin = [];
                    return;
                }

                this.filteredStopsBegin = this.stopsBegin.filter(stop => 
                    stop.name.toLowerCase().includes(this.queryBegin.toLowerCase())
                );

            } else if (option === 'end') {
                if (this.queryEnd.length === 0) {
                    this.filteredStopsEnd = [];
                    return;
                }

                this.filteredStopsEnd = this.stopsEnd.filter(stop => 
                    stop.name.toLowerCase().includes(this.queryEnd.toLowerCase())
                );
            }
        },

        selectStopBegin(stop) {
            this.queryBegin = stop.name;
            this.filteredStopsBegin = [];
            this.selectedBeginId = stop.id;

            this.fetchStops('end', this.selectedBeginId);
        },

        selectStopEnd(stop) {
            this.queryEnd = stop.name;
            this.filteredStopsEnd = [];
            console.log(234);

            if (this.selectedBeginId && stop.id) {
                const url = `{{ config('app.url') }}/api/getline/${this.selectedBeginId}/${stop.id}`;
                
                fetch(url)
                    .then(res => res.json())
                    .then(data => {
                       
                        this.lineData = data;
                         console.log(this.lineData);
                    })
                    .catch(err => console.error('Błąd pobierania danych linii:', err));
            }
        },
    }
}
</script>

@endsection
