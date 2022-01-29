<?php require_once 'partials/_dash_header.php';?>
<div class="container-fluid">
    <div class="row">
        <?php require_once 'partials/_dash_sidebar.php';?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
    </div>
    <?php require_once 'partials/_notification.php';?>
    <div class="well">
        <div class="alert alert_info">
            You have been logged in as <strong><?php echo $_SESSION['user'];?></strong>
        </div>
    </div>
        </main>
    </div>
</div>
<?php require_once 'partials/_dash_footer.php';?>