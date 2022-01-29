<?php require_once 'partials/_header.php'; ?>
<main role="main" class="login-page">
    <div class="container">

        <?php require_once 'partials/_notification.php';?>

        <form class="form-signin" action="/login" method="post">
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
            <div class="form-floating">
                <input type="email" class="form-control" name="email" placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" name="password" placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
        </form>
    </div>
</main>
<?php require_once 'partials/_footer.php'; ?>


