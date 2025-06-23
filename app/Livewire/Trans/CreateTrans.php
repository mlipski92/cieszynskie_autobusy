<?php

namespace App\Livewire\Trans;

use App\Repositories\TransRepositoryInterface;
use Livewire\Component;
use App\Models\Trans;

class CreateTrans extends Component
{
    public $name;

    private $transRepository;
    public function boot(TransRepositoryInterface $transRepository)
    {
        $this->transRepository = $transRepository;
    }
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }
    public function save()
    {
        $this->validate();

        $this->transRepository->create([
            'name' => $this->name,
        ]);

        $this->reset('name');

        session()->flash('message', 'Dodano poprawnie!');
        return redirect()->route('trans.list');
    }
    public function render()
    {
        return view('livewire.trans.create-trans');
    }
}
