<?php

namespace Modules\Productos\app\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Productos\app\Models\Producto;

class ProductTable extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'nombre';
    public $sortDirection = 'asc';
    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'nombre'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function render()
    {
        $productos = Producto::query()
            ->when($this->search, function ($query) {
                $query->search($this->search);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('productos::livewire.product-table', [
            'productos' => $productos
        ]);
    }
}
