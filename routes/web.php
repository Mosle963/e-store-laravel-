<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Supplier\ShowList as SupplierShowList;
use App\Livewire\Customer\ShowList as CustomerShowList;
use App\Livewire\Product\ShowList as ProductShowList;
use App\Livewire\Product\CreateNew as ProductCreateNew;
use App\Livewire\Order\ShowList as OrderShowList;


Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::get('/supplier/list', SupplierShowList::class)
    ->name('supplier_list');

Route::get('/customer/list', CustomerShowList::class)
    ->name('customer_list');

Route::get('/product/list', ProductShowList::class)
    ->name('product_list');

Route::get('/product/create', ProductCreateNew::class)
    ->name('product_create');

Route::get('/product/edit/{id}', ProductCreateNew::class)
    ->name('product_edit');


Route::get('/order/list', OrderShowList::class)
    ->name('order_list');

Route::get('/order/list', OrderShowList::class)
    ->name('order_create');

Route::get('/order/list/{id}', OrderShowList::class)
    ->name('order_edit');
