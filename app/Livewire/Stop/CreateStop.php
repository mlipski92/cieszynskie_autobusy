<?php

namespace App\Livewire\Stop;

use App\Models\Stop;
use Livewire\Component;

class CreateStop extends Component
{
    public $name;
    public $positionx;
    public $positiony;
    public $direction;
    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'positionx' => 'required|string|max:255',
            'positiony' => 'required|string|max:255',
            'direction' => 'required|string|max:255'
        ]);

        Stop::create([
            'name' => $this->name,
            'positionx' => $this->positionx,
            'positiony' => $this->positiony,
            'direction' => $this->direction,
        ]);

        session()->flash('message', 'Dodano poprawnie!');
        return redirect()->route('stop.list');
    }
    public function render()
    {
        return view('livewire.stop.create-stop');
    }
}
