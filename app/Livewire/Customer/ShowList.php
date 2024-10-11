<?php

namespace App\Livewire\Customer;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Customer;


class ShowList extends Component
{
    protected $paginationTheme = 'bootstrap';
    public $table_headers = [
        '#',
        'First Name',
        'Last Name',
        'City',
        'Country',
        'Phone'
    ];

    use WithPagination;
    public function render()
    {
        return view('livewire.customer.show-list')
        ->with('customers' , Customer::paginate(15))
        ->layout('layouts.app')
        ->title('Customers');
    }
}
