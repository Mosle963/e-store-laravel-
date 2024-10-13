<?php

namespace App\Livewire\Order;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Livewire Component to show a list of orders with pagination.
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
     * Headers for the order table.
     *
     * @var array
     */
    public $table_headers = [
        '#',
        'Order Date',
        'Order Number',
        'Customer Id',
        'Customer Name',
        'Total Amount',
    ];

    /**
     * Deletes an order by ID.
     *
     * @param  int  $id
     */
    public function deleteOrder($id): void
    {
        Order::find($id)->delete();
    }

    /**
     * Renders the Livewire component view.
     */
    public function render(): \Illuminate\View\View
    {
        return view('livewire.order.show-list')
            ->with('orders', Order::with('customer')->orderBy('id', 'desc')->paginate(15))
            ->layout('layouts.app')
            ->title('Orders');
    }
}
