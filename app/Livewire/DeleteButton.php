<?php

namespace App\Livewire;

use Livewire\Component;

class DeleteButton extends Component
{
    public string $model;
    public int|string $id;
    public bool $showModal = false;

    public function confirmDelete()
    {
        $this->showModal = true;
    }

    public function delete()
    {
        
        $class = $this->model;

        if (!class_exists($class)) {
            abort(404, 'Nieprawidłowy model');
        }

        $record = $class::findOrFail($this->id);
        $record->delete();

        session()->flash('message', 'Rekord usunięty.');
        return redirect()->route('trans.list');
    }

    public function render()
    {
        return view('livewire.delete-button');
    }
}
