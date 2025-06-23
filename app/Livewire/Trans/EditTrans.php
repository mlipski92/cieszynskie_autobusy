<?php

namespace App\Livewire\Trans;

use App\Models\Trans;
use App\Repositories\TransRepositoryInterface;
use Livewire\Component;

class EditTrans extends Component
{
    public $transId;
    public $name;
    private $transRepository;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }

    public function mount($id)
    {
        $this->transId = $id;
        $this->editElement = app(TransRepositoryInterface::class)->findById($id);
        $this->name = $this->editElement->name;
    }
    public function boot(TransRepositoryInterface $transRepository)
    {
        $this->transRepository = $transRepository;
    }

    public function save()
    {
        $this->validate();

        $this->transRepository->update([
            'name' => $this->name,
        ], $this->transId);

        session()->flash('message', 'Zaktualizowano poprawnie!');
        return redirect()->route('trans.list');
    }

    public function render()
    {
        return view('livewire.trans.edit-trans');
    }
}
