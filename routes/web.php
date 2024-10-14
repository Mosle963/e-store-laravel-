<?php

use App\Http\Controllers\API\ProductController;
use App\Livewire\Customer\ShowList as CustomerShowList;
use App\Livewire\Order\CreateNew as OrderCreateNew;
use App\Livewire\Order\Edit as OrderEdit;
use App\Livewire\Order\ShowList as OrderShowList;
use App\Livewire\Product\CreateNew as ProductCreateNew;
use App\Livewire\Product\ShowList as ProductShowList;
use App\Livewire\Supplier\ShowList as SupplierShowList;
use Illuminate\Support\Facades\Route;

// Home route
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Supplier routes
Route::get('/supplier/list', SupplierShowList::class)
    ->name('supplier_list');

// Customer routes
Route::get('/customer/list', CustomerShowList::class)
    ->name('customer_list');

// Product routes
Route::get('/product/list', ProductShowList::class)
    ->name('product_list');
Route::get('/product/create', ProductCreateNew::class)
    ->name('product_create');
Route::get('/product/edit/{id}', ProductCreateNew::class)
    ->name('product_edit');

// Order routes
Route::get('/order/list', OrderShowList::class)
    ->name('order_list');
Route::get('/order/create', OrderCreateNew::class)
    ->name('order_create');
Route::get('/order/edit/{id}', OrderEdit::class)
    ->name('order_edit');


//product api routes
Route::prefix('api')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
});


//documentation route
Route::get('/doc', function () {
    return redirect('/docs/index.html');
});
