<?php

namespace App\Livewire\Trans;

use App\Models\Trans;
use Livewire\Component;

class EditTrans extends Component
{
    public $transId;
    public $name;

    public function mount($id)
    {
        $this->transId = $id;
        $trans = Trans::findOrFail($id);
        $this->name = $trans->name;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        $trans = Trans::findOrFail($this->transId);
        $trans->update(['name' => $this->name]);

        session()->flash('message', 'Zaktualizowano poprawnie!');
        return redirect()->route('trans.list');
    }

    public function render()
    {
        return view('livewire.trans.edit-trans');
    }
}
