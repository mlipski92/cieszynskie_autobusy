<?php

namespace App\Livewire\Trans;

use App\Repositories\TransRepositoryInterface;
use Livewire\Component;
use App\Models\Trans;

class TransList extends Component
{
    public function mount() {
        $this->allItems = app(TransRepositoryInterface::class)->getAll();
        $this->allRecords = $this;
    }
    public function render()
    {
        $transList = $this->allItems;
        return view('livewire.trans.trans-list', [
            'transList' => $transList
        ]);
    }
}
