<?php

namespace App\Livewire\Customer;

use App\Models\Customer;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Livewire Component to display a list of customers with pagination.
 */
class ShowList extends Component
{
    /**
     * Use Bootstrap for pagination theme.
     *
     * @var string
     */
    protected $paginationTheme = 'bootstrap';

    /**
     * Headers for the customer table.
     *
     * @var array
     */
    public $table_headers = [
        '#',
        'First Name',
        'Last Name',
        'City',
        'Country',
        'Phone',
    ];

    use WithPagination;

    /**
     * Render the Livewire component view.
     *
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        return view('livewire.customer.show-list')
            ->with('customers', Customer::paginate(15)) // Paginate customers with 15 per page
            ->layout('layouts.app') // Use the 'layouts.app' Blade layout
            ->title('Customers'); // Set the page title
    }
}
