<?php
$success_msg = [];
$warning_msg = [];

if (isset($_POST['add_to_wishlist'])) {
    if (!empty($user_id)) {
        $id = unique_id();
        $product_id = $_POST['product_id'];

      
        $verify_wishlist = $conn->prepare("SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?");
        $verify_wishlist->execute([$user_id, $product_id]);

        $cart_check = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
        $cart_check->execute([$user_id, $product_id]);

        if ($verify_wishlist->rowCount() > 0) {
            $warning_msg[] = 'Product already exists in your wishlist.';
        } elseif ($cart_check->rowCount() > 0) {
            $warning_msg[] = 'Product is already in your cart.';
        } else {
            $select_price = $conn->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
            $select_price->execute([$product_id]);
            $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

            $insert_wishlist = $conn->prepare("INSERT INTO wishlist (id, user_id, product_id, price) VALUES (?, ?, ?, ?)");
            $insert_wishlist->execute([$id, $user_id, $product_id, $fetch_price['price']]);

            $success_msg[] = 'Product added to your wishlist successfully!';
        }
    } else {
        $warning_msg[] = 'Please login first to use the wishlist.';
    }
}
?>
