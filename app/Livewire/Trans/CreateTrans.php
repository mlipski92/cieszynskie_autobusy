<?php

namespace App\Livewire\Trans;

use Livewire\Component;
use App\Models\Trans;

class CreateTrans extends Component
{
    public $name;
    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        Trans::create([
            'name' => $this->name,
        ]);

        $this->reset('name');

        session()->flash('message', 'Dodano poprawnie!');
        return redirect()->route('trans.list');
    }
    public function render()
    {
        return view('livewire.trans.create-trans');
    }
}
