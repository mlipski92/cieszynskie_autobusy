<?php

namespace App\Livewire\Stop;

use App\Models\Stop;
use Livewire\Component;

class StopList extends Component
{
    public function delete($id)
    {
        Stop::findOrFail($id)->delete();
        session()->flash('message', 'Rekord został usunięty.');
        return view('livewire.stop.stop-list');
    }
    public function render()
    {
        $stopList = Stop::all();
        return view('livewire.stop.stop-list', [
            'stopList' => $stopList
        ]);
    }
}
