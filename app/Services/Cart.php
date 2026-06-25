<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class Cart
{
    private const KEY = 'cart';

    /**
     * @return array<string, array<string, mixed>>
     */
    public function items(): array
    {
        return Session::get(self::KEY, []);
    }

    public function add(Product $product, ?string $size, int $quantity = 1): void
    {
        $quantity = max(1, $quantity);
        $items = $this->items();
        $key = $this->lineKey($product->id, $size);

        if (isset($items[$key])) {
            $items[$key]['quantity'] += $quantity;
        } else {
            $items[$key] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => (float) $product->price,
                'image' => $product->image_url,
                'size' => $size,
                'quantity' => $quantity,
            ];
        }

        Session::put(self::KEY, $items);
    }

    public function update(string $key, int $quantity): void
    {
        $items = $this->items();
        if (! isset($items[$key])) {
            return;
        }

        if ($quantity <= 0) {
            unset($items[$key]);
        } else {
            $items[$key]['quantity'] = $quantity;
        }

        Session::put(self::KEY, $items);
    }

    public function remove(string $key): void
    {
        $items = $this->items();
        unset($items[$key]);
        Session::put(self::KEY, $items);
    }

    public function clear(): void
    {
        Session::forget(self::KEY);
    }

    public function count(): int
    {
        return array_sum(array_column($this->items(), 'quantity'));
    }

    public function total(): float
    {
        $total = 0.0;
        foreach ($this->items() as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $total;
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function detailed(): array
    {
        $items = $this->items();
        foreach ($items as $key => &$item) {
            $item['key'] = $key;
            $item['line_total'] = $item['price'] * $item['quantity'];
        }

        return $items;
    }

    public function isEmpty(): bool
    {
        return count($this->items()) === 0;
    }

    private function lineKey(int $productId, ?string $size): string
    {
        return $productId . '-' . ($size ?? 'na');
    }
}
