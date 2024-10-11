<?php

namespace App\Livewire\Supplier;

use Livewire\Component;
use App\Models\Supplier;
use Livewire\WithPagination;
class ShowList extends Component
{
    protected $paginationTheme = 'bootstrap';
    use WithPagination;
    public $table_headers = [
        '#',
        'Company Name',
        'Contact Name',
        'City',
        'Country',
        'Phone',
        'Fax'
    ];

    public function render()
    {

        return view('livewire.supplier.show-list')
            ->with('suppliers',Supplier::paginate(15))
            ->layout('layouts.app')
            ->title('Suppliers');
    }
}
