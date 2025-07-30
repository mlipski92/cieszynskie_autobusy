<?php

namespace App\Livewire\Stop;

use App\Factory\StopFactory;
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
    protected $stopFactory;

    protected function rules() {
        return [
            'name' => 'required|string|max:255',
            'positionx' => 'required|string|max:255',
            'positiony' => 'required|string|max:255',
            'direction' => 'required|string|max:255'
        ];
    }
    public function boot(StopRepository $stopRepository, StopFactory $stopFactory) {
        $this->stopRepository = $stopRepository;
        $this->stopFactory = $stopFactory;
    }
    public function save()
    {
        $this->validate();

        $stopDto = $this->stopFactory->fromArray($this->name,$this->positionx,$this->positiony, $this->direction );

        $this->stopRepository->create($stopDto);

        session()->flash('message', 'Dodano poprawnie!');
        return redirect()->route('stop.list');
    }
    public function render()
    {
        return view('livewire.stop.create-stop');
    }
}
