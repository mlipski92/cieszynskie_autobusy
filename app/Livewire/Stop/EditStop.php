<?php

namespace App\Livewire\Stop;

use App\Models\Stop;
use Livewire\Component;

class EditStop extends Component
{
    public $stopId;
    public $name;
    public $positionx;
    public $positiony;
    public $direction;

    public function mount($id)
    {
        $this->stopId = $id;
        $stop = Stop::findOrFail($id);
        $this->name = $stop->name;
        $this->positionx = $stop->positionx;
        $this->positiony = $stop->positiony;
        $this->direction = $stop->direction;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'positionx' => 'required|string|max:255',
            'positiony' => 'required|string|max:255',
            'direction' => 'required|string|max:255'
        ]);

        $stop = Stop::findOrFail($this->stopId);
        $stop->update([
            'name' => $this->name, 
            'positionx' => $this->positionx,
            'positiony' => $this->positiony,
            'direction' => $this->direction,
        ]);

        session()->flash('message', 'Zaktualizowano poprawnie!');
        return redirect()->route('stop.list');
    }

    public function render()
    {
        return view('livewire.stop.edit-stop');
    }
}
