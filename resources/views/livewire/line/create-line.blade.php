<div>
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
</div>
