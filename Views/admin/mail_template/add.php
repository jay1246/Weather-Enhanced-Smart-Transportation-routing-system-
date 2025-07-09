<?= $this->extend('template/admin_template') ?>
<?= $this->section('main') ?>
<main id="main" class="main">
    <!-- End Page Title -->
    <section class="section dashboard mt-3 shadow">
        <div class="row">
            <div class="card shadow">
                <div class="card-body">
                    <form action="" id="edit_form">
                        <div class="row g-0 card-header">
                            <div class="col-2">
                                <button class="btn btn_green_yellow">Add Template</button>
                            </div>
                            <div class="col-10">
                                <a href="<?= base_url("admin/mail_template") ?>" class="btn btn_yellow_green float-end">
                                    <i class="bi bi-arrow-left"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                        <div class="row card-body">
                            <div class="col-10">

                                <div class="row my-2">
                                    <div class="col-12">
                                        <label>Name</label>
                                        <select name="name" class="form-control" required>
                                            <option></option>
                                            <?php
                                            $mail_template_name_keywords = mail_name();
                                            $num = 1;
                                            foreach ($mail_template_name_keywords as $name_keyword) {
                                            ?>
                                                <option value="<?= $name_keyword->id ?>"><?= $name_keyword->name ?></option>

                                            <?php
                                                $num++;
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row g-0 my-2">
                                    <div class="col-12">
                                        <label for="">Subject</label>
                                        <input type="text" name="subject" class="form-control subject" id="subjectField">
                                    </div>
                                </div>
                                <div class="row g-0 my-2">
                                    <div class="col-12">
                                        <label for="">Body</label>
                                        <textarea name="body" cols="30" rows="10" class="form-control text_editor"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2 text-center">
                                <?= $this->include("./admin/mail_template/keywordWrapper") ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

</main>
<?= $this->endSection() ?>

<?= $this->section("custom_script") ?>
<?= $this->include("./admin/mail_template/summernoteScript") ?>
<script>
    $(document).ready(function() {
        $("form").submit((e) => {
            e.preventDefault();
            // var formData = new FormData(e[0]);
            var formData = new FormData(document.getElementById("edit_form"));

            $.ajax({
                method: "POST",
                url: "<?= base_url("admin/mail_template/add_action") ?>",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    res = JSON.parse(res);
                    // console.log(res);
                    // return;
                    if (res) {
                        window.location = "<?= base_url("admin/mail_template/edit") ?>/" + res["id"];
                    } else {
                        console.log(res);
                    }
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>