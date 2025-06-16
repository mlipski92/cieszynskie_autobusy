<?php

namespace App\Livewire\Trans;

use Livewire\Component;
use App\Models\Trans;

class TransList extends Component
{
    public function delete($id)
    {
        Trans::findOrFail($id)->delete();
        session()->flash('message', 'Rekord został usunięty.');
    }
    public function render()
    {
        $transList = Trans::all();
        return view('livewire.trans.trans-list', [
            'transList' => $transList
        ]);
    }
}
