<?php

namespace Database\Seeders;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder {
    public function run(): void {
        $users = User::where('role', 'customer')->get();
        $products = Product::all();

        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        $paymentStatuses = ['pending', 'paid', 'failed', 'refunded'];

        foreach ($users as $user) {
            // Create 2-4 orders per user
            $orderCount = rand(2, 4);

            for ($i = 0; $i < $orderCount; $i++) {
                $orderProducts = $products->random(rand(1, 4));
                $subtotal = 0;

                $order = Order::create([
                    'order_number' => Order::generateOrderNumber(),
                    'user_id' => $user->id,
                    'customer_name' => $user->name,
                    'customer_email' => $user->email,
                    'customer_phone' => '+1' . rand(1000000000, 9999999999),
                    'shipping_address' => '123 Test Street, City, Country',
                    'billing_address' => '123 Test Street, City, Country',
                    'subtotal' => 0,
                    'tax' => 0,
                    'shipping_cost' => 0,
                    'discount' => 0,
                    'total' => 0,
                    'status' => $statuses[array_rand($statuses)],
                    'payment_status' => $paymentStatuses[array_rand($paymentStatuses)],
                    'payment_method' => rand(0, 1) ? 'cash' : 'card',
                    'notes' => rand(0, 1) ? 'Please handle with care' : null,
                    'created_at' => now()->subDays(rand(0, 60)),
                ]);

                foreach ($orderProducts as $product) {
                    $qty = rand(1, 3);
                    $itemTotal = $product->final_price * $qty;
                    $subtotal += $itemTotal;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->translated_name,
                        'price' => $product->final_price,
                        'quantity' => $qty,
                        'total' => $itemTotal,
                    ]);
                }

                $order->update([
                    'subtotal' => $subtotal,
                    'total' => $subtotal,
                ]);
            }
        }
    }
}
