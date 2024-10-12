<?php

namespace App\Livewire\Order;

use Livewire\Component;
use App\Models\Order;
use Livewire\WithPagination;

class ShowList extends Component
{
    protected $paginationTheme = 'bootstrap';
    use WithPagination;
    public $table_headers = [
        '#',
        'Order Date',
        'Order Number',
        'Customer Id',
        'Customer Name',
        'Total Amount',
    ];
    public function deleteOrder($id)
    {
        Order::find($id)->delete();
    }
    public function render()
    {
        return view('livewire.order.show-list')
        ->with('orders' , Order::with('customer')->orderBy('id', 'desc')->paginate(15))
        ->layout('layouts.app')
        ->title('Orders');
    }
}
