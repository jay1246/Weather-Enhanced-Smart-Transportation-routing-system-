<?= $this->extend('template/admin_template') ?>
<?= $this->section('main') ?>


<main id="main" class="main">

    <div class="pagetitle">
        <h4 style="color: #055837;">Mail Template Name Keywords</h4>
    </div><!-- End Page Title -->
    <section class="section dashboard mt-5 shadow">
        <div class="row">
            <div class="card shadow">
                <div class="card-body">         

                    <div class="row card-header ">
                        <div class="col-10">
                            <a href="" data-bs-toggle="modal" data-bs-target="#add_form" class="btn btn_green_yellow">   
                                <i class="bi bi-plus"></i>
                                ADD
                            </a>
                            
                        </div>
                        <div class="col-2" style="text-align: right; margin:0px">
                            <a href="<?= base_url("admin/mail_template") ?>" class="btn btn_yellow_green">
                                <i class="bi bi-arrow-left"></i>
                                Back
                            </a>
                        </div>
                    </div>

                    <!-- modal box for add -->
                        <div class="modal" id="add_form">
                            <div class="modal-dialog  modal-lg">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Add Name Keywords</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="" class="add_data">
                                            <div class="row"> 
                                                <div class="col-6">
                                                    <label>Keyword
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="name_keyword" class="form-control md-2" required>
                                                </div>                                                                                
                                                <div class="col-6">
                                                    <label>Name
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="name" class="form-control md-2" required>
                                                </div>
                                                
                                            </div>
                                            <br>                                                     
                                            <div class="row">                                                
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn_green_yellow">Save</button>
                                                    <button type="button" class="btn btn_yellow_green" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- modal box for add end -->

                    <div class="table table-responsive">
                        <table id="staff_table" class="table table-striped datatable" >
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Keyword</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                foreach ($name_keywords as $name_keyword) {
                                ?>
                                    <tr>
                                        <td><input type="hidden" <?= $count ?>></td>
                                        <td><?= $name_keyword->id ?></td>
                                        <td>
                                        <?php $mail = find_one_row('mail_template','name',$name_keyword->id);
                                                  if($mail){
                                                    ?>
                                                    <a href="<?= base_url("admin/mail_template/edit/" . $mail->id) ?>"><?= $name_keyword->name_keyword ?></a>
                                                    <?php
                                                  }else{?>
                                                <?= $name_keyword->name_keyword ?>
                                                <?php } ?>
                                            </a>
                                        </td>
                                        <td><?= $name_keyword->name ?></td>
                                        <td>
                                            <a href="" data-bs-toggle="modal" data-bs-target="#add_form<?= $count?>"  class="btn btn-sm btn_green_yellow">
                                            <i class="bi bi-pencil-square"></i>
                                            </a>
                                            
                                           
                                        </td>
                                    </tr>

                                    <!-- modal box for edit -->
                                        <div class="modal" id="add_form<?= $count?>">
                                            <div class="modal-dialog  modal-lg">
                                                <div class="modal-content" style="background-color: white;">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Name Keywords</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="" class="edit_data">
                                                            <div class="row">                         
                                                                
                                                            <div class="col-6">
                                                                <label>Keyword
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                <input type="text" name="name_keyword" class="form-control md-2" value="<?=$name_keyword->name_keyword ?>">
                                                                <input type="hidden" name="id" class="form-control md-2" value="<?=$name_keyword->id ?>">

                                                            </div>                                                                                
                                                            <div class="col-6">
                                                                <label>Name
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                <input type="text" name="name" class="form-control md-2" value="<?=$name_keyword->name ?>">
                                                            </div>
                                                            </div> 
                                                            <br>                                                    
                                                            <div class="row">                                                
                                                                <div class="text-end">
                                                                    <button type="submit" class="btn btn_green_yellow">Save</button>
                                                                    <button type="button" class="btn btn_yellow_green" data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- modal box for edit end -->
            
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
<?= $this->section("custom_script") ?>

<script>
     $(".add_data").submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            method: "POST",
            url: "<?= base_url("admin/mail_template/add_name_keyword") ?>",
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                res = JSON.parse(res);
                if (res) {
                    window.location = "<?= base_url("admin/mail_template/name_keywords") ?>";
                } else {
                    console.log(res);
                }
            }
        });
    });
 
    $(".edit_data").submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
    
        $.ajax({
            method: "POST",
            url: "<?= base_url("admin/mail_template/edit_name_keyword") ?>",
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                res = JSON.parse(res);
                if (res) {
                    window.location = "<?= base_url("admin/mail_template/name_keywords") ?>";
                } else {
                    console.log(res);
                }
            }
        });
    });
    $(document).ready(function() {
        $('#staff_table').DataTable({
              "language": {
                "lengthMenu": '_MENU_ ',
                "search": '<i class="fa fa-search"></i>',
                "searchPlaceholder": "Search",
            }
        });
    });

</script>
<?= $this->endSection() ?>
