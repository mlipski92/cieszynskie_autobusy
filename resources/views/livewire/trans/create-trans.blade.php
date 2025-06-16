@if (session()->has('message'))
    <div style="color: green;">
        {{ session('message') }}
    </div>
@endif
<div>
    <form wire:submit="save"> 
        <label for="name">Nazwa przewoźnika:</label>
        <input type="text" id="name" wire:model="name">
    
        <button type="submit">Save</button>
    </form>
</div>
