<?php
$success_msg = [];
$warning_msg = [];

if (isset($_POST['add_to_cart'])) {
    if (!empty($user_id)) {

        $id = unique_id();
        $product_id = $_POST['product_id'];
        $qty = filter_var($_POST['qty'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // Check if cart is full first
        $max_cart_items = $conn->prepare("SELECT COUNT(*) FROM cart WHERE user_id = ?");
        $max_cart_items->execute([$user_id]);
        $item_count = $max_cart_items->fetchColumn();

        if ($item_count >= 20) {
            $warning_msg[] = 'Your cart is full (max 20 items)';
        } else {
            // Check if product already exists
            $verify_cart = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
            $verify_cart->execute([$user_id, $product_id]);

            if ($verify_cart->rowCount() > 0) {
                $warning_msg[] = 'Product already exists in your cart';
            } else {
                // Add to cart
                $select_price = $conn->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
                $select_price->execute([$product_id]);
                $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

                $insert_cart = $conn->prepare("INSERT INTO cart (id, user_id, product_id, price, qty) VALUES (?, ?, ?, ?, ?)");
                $insert_cart->execute([$id, $user_id, $product_id, $fetch_price['price'], $qty]);

                $success_msg[] = 'Product added to your cart';
            }
        }

    } else {
        $warning_msg[] = 'Please login first';
    }
}
