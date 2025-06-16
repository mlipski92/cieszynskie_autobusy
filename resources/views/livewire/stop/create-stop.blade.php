<div>
    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1">
            <div class="flex items-center">
                <label for="name">Nazwa przystanku:</label>
            </div>
            <div>
                <x-input id="name" wire:model="name" />
            </div>
        </div>
        <br>
        <div class="grid grid-cols-1">
            <div class="flex items-center">
                <label for="positionx">Pozycja X:</label>
            </div>
            <div>
                <x-input id="positionx" wire:model="positionx" />
            </div>
        </div>
        <br>
        <div class="grid grid-cols-1">
            <div class="flex items-center">
                <label for="positiony">Pozycja Y:</label>
            </div>
            <div>
                <x-input id="positiony" wire:model="positiony" />
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
        <x-form-button>Zapisz</x-form-button>
    </form>
</div>
