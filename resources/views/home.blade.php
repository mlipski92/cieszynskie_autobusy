@extends('layout.main')

@section('content') 
    <div class="p-5">
        <label>Wpisz nazwę przystanku:</label>
        <x-input id="stopname" wire:model="stopname" />
        <ul>
            <li>Nazwa przystanku</li>
        </ul>
    </div>

@endsection