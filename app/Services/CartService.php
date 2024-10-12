<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Session\SessionManager;

class CartService {
    const MINIMUM_QUANTITY = 1;

    protected $session;

    /**
     * Constructs a new cart object.
     *
     * @param Illuminate\Session\SessionManager $session
     */
    public function __construct(SessionManager $session)
    {
        $this->session = $session;
    }

    /**
     * Adds a new item to the cart.
     *
     * @param string $id
     * @param string $name
     * @param string $price
     * @param string $quantity
     * @param array $options
     * @return void
     */
    public function add($id, $name, $price, $quantity, $session_name = 'shopping-cart'): void
    {
        $cartItem = $this->createCartItem($name, $price, $quantity,$session_name);

        $content = $this->getContent($session_name);

        if ($content->has($id)) {
            $cartItem->put('quantity', $content->get($id)->get('quantity') + $quantity);
        }

        $content->put($id, $cartItem);

        $this->session->put($session_name, $content);
    }

    /**
     * Updates the quantity of a cart item.
     *
     * @param string $id
     * @param string $action
     * @return void
     */
    public function update(string $id, string $action, $session_name= 'shopping-cart' ): void
    {
        $content = $this->getContent($session_name);

        if ($content->has($id)) {
            $cartItem = $content->get($id);

            switch ($action) {
                case 'plus':
                    $cartItem->put('quantity', $content->get($id)->get('quantity') + 1);
                    break;
                case 'minus':
                    $updatedQuantity = $content->get($id)->get('quantity') - 1;

                    if ($updatedQuantity < self::MINIMUM_QUANTITY) {
                        $updatedQuantity = self::MINIMUM_QUANTITY;
                    }

                    $cartItem->put('quantity', $updatedQuantity);
                    break;
            }

            $content->put($id, $cartItem);

            $this->session->put($session_name, $content);
        }
    }

    /**
     * Removes an item from the cart.
     *
     * @param string $id
     * @return void
     */
    public function remove(string $id,$session_name= 'shopping-cart'): void
    {
        $content = $this->getContent($session_name);

        if ($content->has($id)) {
            $this->session->put($session_name, $content->except($id));
        }
    }

    /**
     * Clears the cart.
     *
     * @return void
     */
    public function clear($session_name= 'shopping-cart'): void
    {
        $this->session->forget($session_name);
    }

    /**
     * Returns the content of the cart.
     *
     * @return Illuminate\Support\Collection
     */
    public function content($session_name= 'shopping-cart'): Collection
    {
        return is_null($this->session->get($session_name)) ? collect([]) : $this->session->get($session_name);
    }

    /**
     * Returns total price of the items in the cart.
     *
     * @return string
     */
    public function total($session_name= 'shopping-cart'): string
    {
        $content = $this->getContent($session_name);

        $total = $content->reduce(function ($total, $item) {
            return $total += $item->get('price') * $item->get('quantity');
        });

        if($total==null)
            return '0';

        return $total;
    }

    /**
     * Returns the content of the cart.
     *
     * @return Illuminate\Support\Collection
     */
    protected function getContent($session_name= 'shopping-cart'): Collection
    {
        return $this->session->has($session_name) ? $this->session->get($session_name) : collect([]);
    }

    /**
     * Creates a new cart item from given inputs.
     *
     * @param string $name
     * @param string $price
     * @param string $quantity
     * @param array $options
     * @return Illuminate\Support\Collection
     */
    protected function createCartItem(string $name, string $price, string $quantity,$session_name= 'shopping-cart'): Collection
    {
        $price = intval($price);
        $quantity = intval($quantity);

        if ($quantity < self::MINIMUM_QUANTITY) {
            $quantity = self::MINIMUM_QUANTITY;
        }

        return collect([
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity,
        ]);
    }


}