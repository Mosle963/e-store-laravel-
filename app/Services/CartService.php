<?php

namespace App\Services;

use Illuminate\Session\SessionManager;
use Illuminate\Support\Collection;

/**
 * Service class to manage cart operations.
 *
 * Functions:
 * - __construct(SessionManager $session): void - Constructs a new cart object.
 * - add(string $id, string $name, string $price, string $quantity): void - Adds a new item to the cart.
 * - update(string $id, string $action): void - Updates the quantity of a cart item.
 * - remove(string $id): void - Removes an item from the cart.
 * - clear(): void - Clears the cart.
 * - content(): Collection - Returns the content of the cart.
 * - total(): string - Returns the total price of the items in the cart.
 * - getContent(): Collection - Returns the content of the cart.
 * - createCartItem(string $name, string $price, string $quantity): Collection - Creates a new cart item from given inputs.
 */
class CartService
{
    // Minimum quantity allowed for cart items
    const MINIMUM_QUANTITY = 1;

    // Session name for storing cart data
    const SESSION_NAME = 'cart';

    /** @var \Illuminate\Session\SessionManager Session manager instance */
    protected $session;

    /**
     * Constructs a new cart object.
     */
    public function __construct(SessionManager $session)
    {
        $this->session = $session;
    }

    /**
     * Adds a new item to the cart.
     */
    public function add(string $id, string $name, string $price, string $quantity): void
    {
        $cartItem = $this->createCartItem($name, $price, $quantity);
        $content = $this->getContent();

        if ($content->has($id)) {
            $cartItem->put('quantity', $content->get($id)->get('quantity') + $quantity);
        }

        $content->put($id, $cartItem);
        $this->session->put(self::SESSION_NAME, $content);
    }

    /**
     * Updates the quantity of a cart item.
     */
    public function update(string $id, string $action): void
    {
        $content = $this->getContent();

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
            $this->session->put(self::SESSION_NAME, $content);
        }
    }

    /**
     * Removes an item from the cart.
     */
    public function remove(string $id): void
    {
        $content = $this->getContent();

        if ($content->has($id)) {
            $this->session->put(self::SESSION_NAME, $content->except($id));
        }
    }

    /**
     * Clears the cart.
     */
    public function clear(): void
    {
        $this->session->forget(self::SESSION_NAME);
    }

    /**
     * Returns the content of the cart.
     */
    public function content(): Collection
    {
        return is_null($this->session->get(self::SESSION_NAME)) ? collect([]) : $this->session->get(self::SESSION_NAME);
    }

    /**
     * Returns the total price of the items in the cart.
     */
    public function total(): string
    {
        $content = $this->getContent();
        $total = $content->reduce(function ($total, $item) {
            return $total += $item->get('price') * $item->get('quantity');
        });

        return $total ?? '0';
    }

    /**
     * Returns the content of the cart.
     */
    protected function getContent(): Collection
    {
        return $this->session->has(self::SESSION_NAME) ? $this->session->get(self::SESSION_NAME) : collect([]);
    }

    /**
     * Creates a new cart item from given inputs.
     */
    protected function createCartItem(string $name, string $price, string $quantity): Collection
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
