<?php

namespace App\Livewire\Order;

use App\Facades\Cart;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Product;
use Livewire\Component;

/**
 * Livewire Component to create a new order.
 *
 * Functions:
 * - mount(): void - Initializes the component, clears the session, loads products and customers, and updates the cart.
 * - closeOrder(): Livewire\Features\SupportRedirects\Redirector - Clears the cart and redirects to the order list.
 * - save(): Livewire\Features\SupportRedirects\Redirector - Validates and saves the order and its items, clears the cart, and redirects to the order list.
 * - render(): \Illuminate\View\View - Renders the view with the cart content and total, and sets the page layout and title.
 * - addToCart(): void - Validates and adds a product to the cart, then updates the cart.
 * - remove_from_cart(string $id): void - Removes a specified item from the cart and updates the cart.
 * - clear_cart(): void - Clears all items from the cart and updates the cart.
 * - clearsession(): void - Delete the current session key.
 * - update_cart_item(string $id, string $action): void - Updates a specified cart item based on an action (plus or minus)and updates the cart.
 * - update_cart(): void - Updates the cart content and total price for rendering.
 */
class CreateNew extends Component
{

    public $edit_mode=False;
    
    /**
     * Customer ID.
     */
    public int $customer_id;

    /**
     * Order Date.
     */
    public string $order_date;

    /**
     * List of avalible products to choose from.
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $products;

    /**
     * Total price of the order.
     */
    protected int $total;

    /**
     * Content of the cart.
     *
     * @var array
     */
    protected $content;

    /**
     * List of customers to choose from.
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $customers;

    /**
     * Selected product ID (Product being added to cart).
     */
    public ?int $product_id = null;

    /**
     * Quantity of the Selected product (Product being added to cart).
     *
     * The default and minimum value is set to 1.
     */
    public int $quantity = 1;

    /**
     * Use Bootstrap for pagination theme.
     *
     * @var string
     */
    protected $paginationTheme = 'bootstrap';

    /**
     * Mounts the component on the template.
     */
    public function mount(): void
    {
        $this->clear_session();
        $this->products = Product::all();
        $this->customers = Customer::all();
        $this->update_cart();
    }

    /**
     * Abort creating the order and redirects to the order list.
     *
     * @return Livewire\Features\SupportRedirects\Redirector
     */
    public function cancel(): \Illuminate\Http\RedirectResponse
    {
        Cart::clear();

        return redirect()->route('order_list');
    }

    /**
     * Saves the order and order items to the database.
     *
     * @return Livewire\Features\SupportRedirects\Redirector
     */
    public function save()
    {
        $this->update_cart();
        $validated = $this->validate([
            'customer_id' => 'required|numeric',
            'order_date' => 'required',
        ], [
            'customer_id.required' => 'A customer name is required.',
            'customer_id.numeric' => 'A customer name is required.',
            'order_date.required' => 'The Order Date field is required.',
        ]);

        //Creating a new order and using the instance to link it with order items
        $new_order = Order::create($validated);

        //Iterating on cart item and creating order items
        foreach ($this->content as $key => $value) {
            Order_item::create([
                'product_id' => intval($key),
                'product_name' => $value['name'],
                'order_id' => $new_order->id,
                'unit_price' => intval($value['price']),
                'quantity' => intval($value['quantity']),
            ]);
        }

        Cart::clear();

        return redirect()->route('order_list');
    }

    /**
     * Renders the Livewire component view.
     */
    public function render(): \Illuminate\View\View
    {
        return view('livewire.order.create-new', [
            'total' => $this->total,
            'content' => $this->content,
        ])->layout('layouts.app')
            ->title('Create Order');
    }

    /**
     * Adds an item to the cart.
     *
     * @param  int  $id
     * @param  int  $quantity
     */
    public function addToCart(): void
    {
        $validated = $this->validate([
            'product_id' => 'required|numeric',
            'quantity' => 'required|numeric|min:1|max:2000',
        ], [
            'product_id.required' => 'A product name is required.',
            'product_id.numeric' => 'A product name is required.',
            'quantity.required' => 'The quantity field is required.',
            'quantity.min' => 'The quantity must be at least one.',
            'quantity.max' => 'The quantity must be not greater than 2000.',
        ]);

        //getting the record of chosen product to access info
        $product = Product::find($validated['product_id']);
        Cart::add($product->id, $product->product_name, $product->unit_price, $validated['quantity']);
        $this->update_cart();
        $this->product_id = null;
        $this->quantity = 1;
    }

    /**
     * Removes a cart item by id.
     */
    public function remove_from_cart(string $id): void
    {
        Cart::remove($id);
        $this->update_cart();
    }

    /**
     * Clears the cart content.
     */
    public function clear_cart(): void
    {
        Cart::clear();
        $this->update_cart();
    }

    /**
     * Clears the session.
     */
    public function clear_session(): void
    {
        Cart::clear();
    }

    /**
     * Updates a cart item.
     */
    public function update_cart_item(string $id, string $action): void
    {
        Cart::update($id, $action);
        $this->update_cart();
    }

    /**
     * Updates the public vars to be rendered to the web page with correct values
     */
    public function update_cart(): void
    {
        $this->total = Cart::total();
        $this->content = Cart::content();
    }
}
