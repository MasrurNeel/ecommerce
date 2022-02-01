<?php require_once 'partials/_header.php'; ?>
<main role="main">
    <div class="container">
        <div class="py-5 text-center">
              <h2>Checkout Form</h2>
            <p class="lead">You are ordering as <?php echo $_SESSION['user']['email']; ?></p>
        </div>

        <div class="row g-5">
            <div class="col-md-5 col-lg-4 order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary">Your cart</span>
                    <span class="badge bg-primary rounded-pill"><?php echo count($cart);?></span>
                </h4>
                <ul class="list-group mb-3">
                <?php foreach($cart as $id => $product): ?>
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0"><?php echo $product['title']; ?></h6>
                            <small class="text-muted">Quantity: <?php echo $product['quantity'];?></small>
                        </div>
                        <span class="text-muted"><?php echo number_format($sum, 2); ?></span>
                    </li>
                    <?php endforeach; ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total BDT)</span>
                        <strong><?php echo number_format($sum, 2); ?></strong>
                    </li>
                </ul>
            </div>
            <div class="col-md-7 col-lg-8">
                <h4 class="mb-3">Billing address</h4>
                <form action="/checkout" method="post">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="firstName" class="form-label">First name</label>
                            <input type="text" class="form-control" name="first_name" placeholder="" value="" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="lastName" class="form-label">Last name</label>
                            <input type="text" class="form-control" name="last_name" placeholder="" value="" required>
                        </div>
                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo $_SESSION['user']['email'];?>" placeholder="you@example.com" required>
                        </div>
                        <div class="col-12">
                            <label for="phone_number">Phone Number</label>
                            <input type="text" class="form-control" name="phone_number" placeholder="Enter Phone Number" required>
                        </div>
                        <div class="col-12">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" name="address" placeholder="1234 Main St" required>
                        </div>
                        <hr class="my-4">

                    <button class="w-100 btn btn-primary btn-lg" type="submit">Continue to checkout</button>
                </form>
            </div>
    </div>
</main>
<?php require_once 'partials/_footer.php'; ?>