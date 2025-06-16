<?php

namespace App\Livewire\Line;

use App\Models\Line;
use Livewire\Component;

class LineList extends Component
{
    public function delete($id)
    {
        Line::findOrFail($id)->delete();
        session()->flash('message', 'Rekord został usunięty.');
        return view('livewire.line.line-list');
    }
    
    public function render()
    {
        $lineList = Line::all();
        return view('livewire.line.line-list', [
            'lineList' => $lineList
        ]);
    }
}
