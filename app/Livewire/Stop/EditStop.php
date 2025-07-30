<?php

namespace App\Livewire\Stop;

use App\Factory\StopFactory;
use App\Models\Stop;
use App\Repositories\StopRepository;
use Livewire\Component;

class EditStop extends Component
{
    public $stopId;
    public $name;
    public $positionx;
    public $positiony;
    public $direction;
    private $transRepository;

    private $stopFactory;

    public function mount($id)
    {
        $this->stopId = $id;
        $stop = app(StopRepository::class)->findById($this->stopId);
        $this->name = $stop->name;
        $this->positionx = $stop->positionx;
        $this->positiony = $stop->positiony;
        $this->direction = $stop->direction;
    }

    public function boot(StopRepository $stopRepository, StopFactory $stopFactory) {
        $this->stopRepository = $stopRepository;
        $this->stopFactory = $stopFactory;
    }

    protected function rules() {
        return [
            'name' => 'required|string|max:255',
            'positionx' => 'required|string|max:255',
            'positiony' => 'required|string|max:255',
            'direction' => 'required|string|max:255'
        ];
    }

    public function save()
    {
        $this->validate();

        $stopDto = $this->stopFactory->fromArray($this->name, $this->positionx, $this->positiony, $this->direction);
        $this->stopRepository->update($stopDto, $this->stopId);

        session()->flash('message', 'Zaktualizowano poprawnie!');
        return redirect()->route('stop.list');
    }

    public function render()
    {
        return view('livewire.stop.edit-stop');
    }
}
