<?php

namespace App\Livewire\Stop;

use App\Models\Stop;
use App\Repositories\StopRepository;
use Livewire\Component;

class StopList extends Component
{
    protected $stopRepository;
    public function boot(StopRepository $stopRepository) {
        $this->stopRepository = $stopRepository;
    }
    public function render()
    {
        $stopList = $this->stopRepository->getAll();
        return view('livewire.stop.stop-list', [
            'stopList' => $stopList
        ]);
    }
}
