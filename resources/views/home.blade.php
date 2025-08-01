@extends('layout.main')

@section('content') 

<div x-data="stopsSearch()" x-init="fetchStops('begin')" class="">
<style>
    * {
    color: #000 !important;
    }
</style>
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
    <div class="p-5" x-show="lineData == null && queryEnd !== '' && queryBegin !== ''">Nie odnaleziono linii</div>

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
                <td class="border p-2">
                    <a 
                        class="text-blue-500 underline"
                        :href="`{{ route('bilet.kup') }}?odjazd=${encodeURIComponent(lineData.timeFrom)}&przyjazd=${encodeURIComponent(lineData.timeTo)}&z=${encodeURIComponent(lineData.locationFrom)}&do=${encodeURIComponent(lineData.locationTo)}&koszt=${encodeURIComponent(lineData.totalCost)}&linia=${encodeURIComponent(lineData.lineName)}`"
                    >
                        Kup bilet
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</div>

</div>


@include('partials.frontjs')


@endsection
