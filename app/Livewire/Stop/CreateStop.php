<?php

namespace App\Livewire\Stop;

use App\Models\Stop;
use App\Repositories\StopRepository;
use Livewire\Component;

class CreateStop extends Component
{
    public $name;
    public $positionx;
    public $positiony;
    public $direction;
    private $transRepository;

    protected function rules() {
        return [
            'name' => 'required|string|max:255',
            'positionx' => 'required|string|max:255',
            'positiony' => 'required|string|max:255',
            'direction' => 'required|string|max:255'
        ];
    }
    public function boot(StopRepository $stopRepository) {
        $this->stopRepository = $stopRepository;
    }
    public function save()
    {
        $this->validate();

        $this->stopRepository->create([
            'name' => $this->name,
            'positionx' => $this->positionx,
            'positiony' => $this->positiony,
            'direction' => $this->direction,
        ]);

        session()->flash('message', 'Dodano poprawnie!');
        return redirect()->route('stop.list');
    }
    public function render()
    {
        return view('livewire.stop.create-stop');
    }
}
