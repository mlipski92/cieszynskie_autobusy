<div>
    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1">
            <div class="flex items-center">
                <label for="name">Nazwa przewoźnika:</label>
            </div>
            <div>
                <x-input id="name" wire:model="name" />
            </div>
        </div>
        <br>
        <x-form-button>Zapisz</x-form-button>
    </form>
</div>
