<?php

namespace App\Livewire\Line;

use App\Models\Line;
use App\Models\Trans;
use App\Repositories\LineRepository;
use Livewire\Component;

class CreateLine extends Component
{
    protected $lineRepository;
    public $name;
    public $trans;
    public $direction;
    public function boot(LineRepository $lineRepository) {
        $this->lineRepository = $lineRepository;
    }
    protected function rules() {
        return [
            'name' => 'required|string|max:255',
            'direction' => 'required|string|max:255'
        ];
    }
    public function save()
    {
        $this->validate();

        $this->lineRepository->create([
            'name' => $this->name,
            'trans' => $this->trans,
            'direction' => $this->direction
        ]);


        session()->flash('message', 'Dodano poprawnie!');
        return redirect()->route('line.list');
    }

    public function render()
    {
        
        $transList = $this->lineRepository->getAllTrans();
        return view('livewire.line.create-line', [
            'transList' => $transList
        ]);
    }
}
