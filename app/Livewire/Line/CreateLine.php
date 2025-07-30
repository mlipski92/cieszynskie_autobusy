<?php

namespace App\Livewire\Line;

use App\Factory\LineDataFactory;
use App\Repositories\LineRepository;
use Livewire\Component;

class CreateLine extends Component
{
    protected $lineRepository;
    public $name;
    public $trans;
    public $direction;
    protected $lineDataFactory;
    public function boot(LineRepository $lineRepository, LineDataFactory $lineDataFactory) {
        $this->lineRepository = $lineRepository;
        $this->lineDataFactory = $lineDataFactory;
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
        $lineDto = $this->lineDataFactory->fromArray($this->name, $this->trans, $this->direction);

        $this->lineRepository->create($lineDto);

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
