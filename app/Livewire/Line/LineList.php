<?php

namespace App\Livewire\Line;

use App\Repositories\LineRepository;
use Livewire\Component;

class LineList extends Component
{
    protected $lineRepository;

    public function boot(LineRepository $lineRepository) {
        $this->lineRepository = $lineRepository;
    }
    public function delete($id)
    {
        $this->lineRepository->delete($id);
        session()->flash('message', 'Rekord został usunięty.');
        return view('livewire.line.line-list');
    }
    
    public function render()
    {
        $lineList = $this->lineRepository->getAll();
        return view('livewire.line.line-list', [
            'lineList' => $lineList
        ]);
    }
}
