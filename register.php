<?php require_once 'partials/_header.php'; ?>
<main role="main" class="login-page">
    <div class="container">
        <form class="form-signin">
            <!--            <img class="mb-4" src="assets/css/app.css" alt="" width="72" height="57">-->
            <h1 class="h3 mb-3 fw-normal">Create your account</h1>
            <div class="form-floating">
                <input type="text" class="form-control" id="inputUsername" placeholder="username" required autofocus>
                <label for="inputUsername">Username</label>
            </div>
            <div class="form-floating">
            <input type="email" class="form-control" id="inputEmail" placeholder="name@example.com" required autofocus>
            <label for="inputEmail">Email address</label>
    </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="inputPassword" placeholder="Password" required autofocus>
                <label for="inputPassword">Password</label>
            </div>
            <input type="file" class="form-control" id="inputPhoto" required>
                <label for="inputPhoto">Profile Photo</label>


            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Register</button>
        </form>
    </div>
</main>
<?php require_once                                                                                                                                                                                                                              'partials/_footer.php'; ?>