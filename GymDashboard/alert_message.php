<div class="col-sm-6">
    <div class="alert-container">
        <?php if ($msg) { ?>
            <div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Well done!</strong>
                <?php echo htmlentities($msg); ?>
            </div>
        <?php } ?>

        <?php if ($error) { ?>
            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Oh snap!</strong>
                <?php echo htmlentities($error); ?>
            </div>
        <?php } ?>

    </div>