<?php if (session()->has('msg')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong> <?= session()->get('msg'); ?> </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php } ?>
<?php if (session()->has('error_msg')) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong> <?= session()->get('error_msg'); ?> </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php } ?>