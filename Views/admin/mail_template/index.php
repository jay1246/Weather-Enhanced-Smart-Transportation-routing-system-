<?= $this->extend('template/admin_template') ?>
<?= $this->section('main') ?>


<main id="main" class="main">

    <div class="pagetitle">
        <h1 class="text-green">Mail Template</h1>
    </div><!-- End Page Title -->
    <section class="section dashboard mt-3 shadow">
        <!--<div class="row">-->
        <div class="card shadow">
            <div class="card-body">
                <div class="row card-header">
                    <div class="col-12 p-0">
                        <a href="<?= base_url("admin/mail_template/add") ?>" class="btn btn_green_yellow" style="position: absolute;
    left: 120px;
    top: 30px;z-index:3">
                            <i class="bi bi-plus"></i>
                            Add Mail
                        </a>
                        <a href="<?= base_url("admin/mail_template/name_keywords") ?>" class="btn btn_green_yellow float-end" style="position: absolute;
    right: 250px;
    top: 30px;z-index:3">
                            <i class="bi bi-plus"></i>
                            Name Keywords
                        </a>
                    </div>
                    <!--</div>-->
                    <div class="table table-responsive">
                        <table class="table table-striped datatable" id="mail_template_table">
                            <thead>
                                <tr>
                                    <!-- <th></th> -->
                                    <!-- <th>test</th> -->
                                    <th>IDs</th>
                                    <th>Name</th>
                                    <th>Keyword</th>
                                    <th>Subject</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                foreach ($mail_templates as $mail_template) {
                                ?>
                                    <tr>
                                        <!-- <td><input type="hidden" <?= $count ?>></td> -->
                                        <!-- <td>
                                            <a target="_blank" class="btn btn-info" href="<?= base_url('admin/mail_template/test_email/' . $mail_template->id) ?>">
                                                Test
                                            </a>
                                        </td> -->
                                        <td><?= $mail_template->id ?></td>
                                        <td>
                                            <a target="_blank" href="<?= base_url("admin/mail_template/edit/" . $mail_template->id)  ?>" style="color:#009933">
                                                <?php
                                                if (isset($mail_template->name)) {
                                                    $keyword = find_one_row('mail_template_name_keyword', 'id', $mail_template->name);
                                                    echo (isset($keyword->name) ? $keyword->name : "");
                                                } ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php
                                            echo (isset($keyword->name_keyword) ? $keyword->name_keyword : "");
                                            ?>
                                        </td>
                                        <td><?= $mail_template->subject ?></td>

                                    </tr>
                                <?php
                                    $count++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>


<?= $this->endSection() ?>

<?= $this->section('custom_script') ?>

<script>
    $(document).ready(function() {
        $('#mail_template_table').DataTable({
            "language": {
                "lengthMenu": '_MENU_ ',
                "search": '<i class="fa fa-search"></i>',
                "searchPlaceholder": "Search",
            }
        });
    });
</script>
<?= $this->endSection() ?>