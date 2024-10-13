<?php

namespace App\Livewire\Supplier;

use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Livewire Component to show a list of suppliers with pagination.
 *
 * Functions:
 * - render(): \Illuminate\View\View - Renders the view with the list of suppliers, applying pagination.
 */
class ShowList extends Component
{
    /**
     * Use Bootstrap for pagination theme.
     *
     * @var string
     */
    protected $paginationTheme = 'bootstrap';

    use WithPagination;

    /**
     * Headers for the supplier table.
     *
     * @var array
     */
    public $table_headers = [
        '#',
        'Company Name',
        'Contact Name',
        'City',
        'Country',
        'Phone',
        'Fax',
    ];

    /**
     * Renders the Livewire component view.
     */
    public function render(): \Illuminate\View\View
    {
        return view('livewire.supplier.show-list')
            ->with('suppliers', Supplier::paginate(15))
            ->layout('layouts.app')
            ->title('Suppliers');
    }
}
