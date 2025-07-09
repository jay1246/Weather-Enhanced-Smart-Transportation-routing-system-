<!-- bootstrap 5 CDN: -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">

<!-- datatables CDN: -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

<!-- date picker jqury CDN:  -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<!-- custom css -->
<?php if (isset($_COOKIE['day_night_mode'])) { ?>
    <?php if ($_COOKIE['day_night_mode'] == "day") { ?>
        <link rel="stylesheet" type="text/css" href="<?= base_url('public/assets/css/style.css') ?>">
    <?php } ?>
    <?php if ($_COOKIE['day_night_mode'] == "night") { ?>
        <link rel="stylesheet" type="text/css" href="<?= base_url('public/assets/css/night_style.css') ?>">
    <?php } ?>
<?php } else { ?>
    <link rel="stylesheet" type="text/css" href="<?= base_url('public/assets/css/style.css') ?>">
<?php

} ?>


<!-- Summernote CDN:  -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

<style>
    .note-editable {
        z-index: 1000;
        background-color: white;
    }

    .dataTable>thead>tr>th[class*="sort"]:before,
    .dataTable>thead>tr>th[class*="sort"]:after {
        content: "" !important;
    }
</style>