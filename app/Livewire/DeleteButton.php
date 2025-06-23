<?php

namespace App\Livewire;

use App\Repositories\StopRepositoryInterface;
use Livewire\Component;
use Illuminate\Support\Facades\App;
use App\Repositories\TransRepositoryInterface;

class DeleteButton extends Component
{
    public ?string $resource = null;
    public string $model;
    public int|string $id;
    public bool $showModal = false;
    public string $returnRoute;

    protected array $repositoryMap = [
        'trans' => TransRepositoryInterface::class,
        'stop' => StopRepositoryInterface::class,
    ];

    public function confirmDelete()
    {
        $this->showModal = true;
    }

    public function delete()
    {

        if (!array_key_exists($this->resource, $this->repositoryMap)) {
            abort(404, 'Nieprawidłowy zasób');
        }

        $repository = App::make($this->repositoryMap[$this->resource]);
        $repository->delete($this->id);

        session()->flash('message', 'Rekord usunięty.');
        return redirect()->route($this->returnRoute);
    }

    public function render()
    {
        return view('livewire.delete-button');
    }
}
