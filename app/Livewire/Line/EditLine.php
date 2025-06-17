<?php

namespace App\Livewire\Line;

use App\Models\Line;
use App\Models\LineStopRelation;
use App\Models\Stop;
use App\Models\Trans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class EditLine extends Component
{
    public $lineId;
    public $name;
    public $trans;
    public $stopList = [];
    public $searchstop = '';
    public $direction;
    public $times = [];
    protected $listeners = ['updateOrder'];
    public function mount($id)
    {
        $this->lineId = $id;
        $line = Line::findOrFail($id);
        $this->name = $line->name;
        $this->trans = $line->trans;
        $this->direction = $line->direction;
    }

public function updateOrder($newOrder)
{
    foreach ($newOrder as $item) {
        LineStopRelation::where('id_stop', $item['stopId'])
            ->where('id_line', $this->lineId)
            ->update(['order' => $item['order']]);
    }

    Log::info('Zaktualizowano kolejność przystanków dla linii ' . $this->lineId);
}
    public function addStopToLine($id_stop, $id_line, $time, $order) {
        $this->resetErrorBag(); // wyczyść wcześniejsze błędy

        $validator = Validator::make(
            ['time' => $time],
            ['time' => ['required', 'regex:/^([01]\d|2[0-3]):[0-5]\d$/']]
        );

        if ($validator->fails()) {
            $this->addError("times.{$id_stop}", 'Niepoprawny format (HH:MM)');
            return;
        }

        LineStopRelation::create([
            'id_stop' => $id_stop,
            'id_line' => $id_line,
            'time' => $time,
            'order' => $order,
        ]);
        session()->flash('success', 'Przystanek został dodany do linii.');
        return redirect()->route('line.edit', ['id' => $id_line]);
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'direction' => 'required|string|max:255'
        ]);

        $line = Line::findOrFail($this->lineId);
        $line->update([
            'name' => $this->name, 
            'trans' => $this->trans,
            'direction' => $this->direction,
        ]);

        session()->flash('message', 'Zaktualizowano poprawnie!');
        return redirect()->route('line.list');
    }

    public function updatedSearchstop() {
        if ($this->searchstop === '') {
            $this->stopList = [];
        } else {
            $this->stopList = Stop::where('name', 'like', '%' . $this->searchstop . '%')
                ->orderBy('name')
                ->limit(10)
                ->get();
        }
    }

    public function getStopList() {
        $relations = LineStopRelation::with('stop')
        ->where('id_line', $this->lineId)
        ->orderBy('order')
        ->get();

        return $relations;
    }

    public function render()
    {
        $transList = Trans::all();
        return view('livewire.line.edit-line', [
            'transList' => $transList,
            'stopList' => $this->stopList,
            'stopsList' => $this->getStopList()
        ]);
    }
}
