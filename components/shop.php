<div class="products">
   <div class="box-container">
    <?php
    $select_products = $conn->prepare("SELECT * FROM products WHERE status = ? LIMIT 6");
    $select_products->execute(['active']);

    if ($select_products->rowCount() > 0) {
        while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <form action="" method="post" class="box <?php if ($fetch_products['stock'] == 0) echo 'disabled'; ?>">
        
        <img src="uploaded_files/<?= htmlspecialchars($fetch_products['image']); ?>" class="image">
       
        <?php if($fetch_products['stock'] > 9){ ?>
            <span class="stock" style="color: green;">In stock</span>
        <?php } elseif ($fetch_products['stock'] == 0) { ?>
            <span class="stock" style="color: red;">Out of stock</span>
        <?php } else { ?> 
            <span class="stock" style="color: red;">Hurry, only <?= htmlspecialchars($fetch_products['stock']); ?> left!</span>
        <?php } ?>

        <div class="content">
            <div class="button">
                <h3 class="name"><?= htmlspecialchars($fetch_products['name']); ?></h3>
                <div>
                    <?php if ($fetch_products['stock'] > 0) { ?>
                        <button type="submit" name="add_to_cart" title="Add to cart"><i class="bx bx-cart"></i></button>
                    <?php } ?>
                    <button type="submit" name="add_to_wishlist" title="Add to wishlist"><i class="bx bx-heart"></i></button>
                    <a href="view_page.php?pid=<?= htmlspecialchars($fetch_products['id']); ?>" class="bx bxs-show" title="View product"></a>
                </div>
            </div>

            <p class="price">price Ksh<?= htmlspecialchars($fetch_products['price']); ?></p>
            <input type="hidden" name="product_id" value="<?= htmlspecialchars($fetch_products['id']); ?>">

            <div class="flex-btn">
                <a href="checkout.php?get_id=<?= htmlspecialchars($fetch_products['id']); ?>" class="btn">buy now</a>
                <input type="number" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty box" <?= ($fetch_products['stock'] == 0) ? 'disabled' : ''; ?>>
            </div>
        </div>
    </form>
    <?php
        }
    } else {
        echo '<div class="empty"><p>No products added yet!</p></div>';
    }
    ?>
    </div>
</div>
