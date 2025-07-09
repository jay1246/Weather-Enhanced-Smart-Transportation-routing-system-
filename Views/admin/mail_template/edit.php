<?= $this->extend('template/admin_template') ?>
<?= $this->section('main') ?>

<main id="main" class="main">
    <!-- End Page Title -->
    <section class="section dashboard mt-3 shadow">

        <div class="row">
            <div class="card shadow">
                <div class="card-body">

                    <form id="test_f" method="post" action="">
                        <label for="name">email:</label>
                        <input type="email" name="email">
                        <input type="hidden" name="id" value="<?= $mail_template["id"] ?>">
                        <button type="button" onclick="new_funtion()" value=""> Test Email Send</button>
                    </form><br>
                    <form action="" id="edit_form">
                        <div class="row g-0 card-header">
                            <div class="col-2">
                                <button class="btn btn_green_yellow">Save Template</button>
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
                                        <label> Name</label>
                                        <input type="hidden" name="name" class="form-control" value="<?= $mail_template["name"] ?>">
                                        <input type="hidden" name="id" value="<?= $mail_template["id"] ?>">

                                        <select name="name" class="form-control" disabled>
                                            <option value="<?= $mail_template["name"] ?>"><?= find_one_row('mail_template_name_keyword', 'id', $mail_template["name"])->name ?></option>

                                        </select>
                                    </div>
                                </div>
                                <div class="row g-0 my-2">
                                    <div class="col-12">
                                        <label for="">Subject</label>
                                        <input type="text" name="subject" class="form-control subject" value="<?= $mail_template["subject"] ?>" id="subjectField">
                                    </div>
                                </div>
                                <div class="row g-0 my-2">
                                    <div class="col-12">
                                        <label for="">Body</label>
                                        <textarea name="body" cols="30" rows="10" class="form-control text_editor"><?= $mail_template["body"] ?></textarea>
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
            // var formData = new FormData($(this)[0]);
            var formData = new FormData(document.getElementById("edit_form"));

            $.ajax({
                method: "POST",
                url: "<?= base_url("admin/mail_template/edit_action") ?>",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    (JSON.parse(res)) ? location.reload(): console.log(res);
                }
            });
        });





    });



    function new_funtion() {
        console.log("click");

        var formData = new FormData(document.getElementById("test_f"));
        $.ajax({
            method: "POST",
            url: "<?= base_url('admin/mail_template/test_email') ?>",
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                console.log(res);
                alert(res);
            }
        });
    }
</script>

<?= $this->endSection() ?>