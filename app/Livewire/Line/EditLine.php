<?php

namespace App\Livewire\Line;

use App\Factory\LineDataFactory;
use App\Factory\LineStopRelationFactory;
use App\Repositories\LineRepository;
use App\Repositories\LineStopRelationRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class EditLine extends Component
{
    protected $lineRepository;
    protected $lineStopRelationRepository;
    protected LineDataFactory $lineDataFactory;
    protected LineStopRelationFactory $lineStopRelationFactory;
    public $lineId;
    public $name;
    public $trans;
    public $stopList = [];
    public $searchstop = '';
    public $direction;
    public $times = [];
    protected $listeners = ['updateOrder'];
    public function boot(LineRepository $lineRepository, LineStopRelationRepository $lineStopRelationRepository, LineDataFactory $lineDataFactory, LineStopRelationFactory $lineStopRelationFactory) {
        $this->lineRepository = $lineRepository;
        $this->lineStopRelationRepository = $lineStopRelationRepository;
        $this->lineDataFactory = $lineDataFactory;
        $this->lineStopRelationFactory = $lineStopRelationFactory;
    }
    public function mount($id)
    {
        $this->lineId = $id;
        $line = $this->lineRepository->findById($id);
        $this->name = $line->name;
        $this->trans = $line->trans;
        $this->direction = $line->direction;
    }

public function updateOrder($newOrder)
{
    foreach ($newOrder as $item) {
        $this->lineStopRelationRepository->updateRelationOrder($item['stopId'], $item['order']);
    }

    session()->flash('success', 'Zmieniono kolejność.');
}
    public function addStopToLine($id_stop, $id_line, $time, $order, $stopcost) {
        $this->resetErrorBag();

        $validator = Validator::make(
            ['time' => $time],
            ['time' => ['required', 'regex:/^([01]\d|2[0-3]):[0-5]\d$/']]
        );

        if ($validator->fails()) {
            $this->addError("times.{$id_stop}", 'Niepoprawny format (HH:MM)');
            return;
        }

        $stopLineDto = $this->lineStopRelationFactory->fromArray($id_stop, $id_line, $time, $stopcost, $order);
        $this->lineStopRelationRepository->createStopLineRelation($stopLineDto);

        session()->flash('success', 'Przystanek został dodany do linii.');
        return redirect()->route('line.edit', ['id' => $id_line]);
    }
    public function rules() {
        return [
            'name' => 'required|string|max:255',
            'direction' => 'required|string|max:255'
        ];
    }

    public function save()
    {
        $this->validate();

        $lineDto = $this->lineDataFactory->fromArray($this->name, $this->trans, $this->direction);
        $line = $this->lineRepository->findById($this->lineId);
        $line->update($lineDto->toArray());

        session()->flash('message', 'Zaktualizowano poprawnie!');
        return redirect()->route('line.list');
    }

    public function removeStopFromLine($stopId)
    {
        $this->lineStopRelationRepository->removeStopLineRelation($stopId, $this->lineId);
        session()->flash('success', 'Przystanek został usunięty z linii.');
    }

    public function updatedSearchstop()
    {
        if ($this->searchstop === '') {
            $this->stopList = [];
        } else {
            $assignedStopIds = $this->lineStopRelationRepository->getAssignedStops($this->lineId);

            $this->stopList = $this->lineStopRelationRepository->getAvailableStopList($this->searchstop, $assignedStopIds);
        }
    }

    public function getStopList() {
        $relations = $this->lineStopRelationRepository->getStopRelations($this->lineId);
        return $relations;
    }

    public function render()
    {
        $transList = $this->lineRepository->getAll();
        return view('livewire.line.edit-line', [
            'transList' => $transList,
            'stopList' => $this->stopList,
            'stopsList' => $this->getStopList()
        ]);
    }
}
