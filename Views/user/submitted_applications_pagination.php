<?= $this->extend('template/user_template') ?>
<?= $this->section('main') ?>
<!-- Pagination Css -->
<style>
    .pagination {
    /* Style the container */
    padding: 10px;
    background-color: #ffffff;
    border-radius: 5px;
    justify-content: center;  /* Center the pagination items */
}
.pagination li {
    margin: 0 3px;  /* Add spacing between pagination items */
}

.pagination a {
    color: #212529;
    text-decoration: none !important;
    padding: 10px 20px;
    border-radius: 5px;
    transition: background-color 0.3s;  /* Smooth transition for hover effects */
}

.pagination a:hover {
    /*background-color: #212529;*/
    /*color: #ffffff;*/
    
    background-color: #EFEFEF;
    color: black;
}


/* Active */
.pagination li.active a {
    /*background-color: #212529;*/
    /*color: #ffffff;*/
    
    background-color: #EFEFEF;
    color: black;
    border: none;
    pointer-events: none;  /* Disable click events on the active item */
}

.pagination li.disabled a {
    color: #cccccc;
    pointer-events: none;
    cursor: not-allowed;
}
/* find_one_row */

.main_bottom_pagination{
    display: flex;
    flex-wrap: nowrap;
    justify-content: space-between;
    justify-items: center;
}
.sub_bottom_pagination{
    padding-top: 05px;
}
.flag_img {
    width: 18px;
}

</style>

<style>
    .container-fluid {
        max-width: 1600px !important;
    }

    .search_input{
        border: 1px solid #aaa;
        border-radius: 3px;
        padding: 5px;
        background-color: transparent;
        margin-left: 3px;
        float: right;
    }
    .dropdown_input{
        border: 1px solid #aaa;
        border-radius: 3px;
        padding: 5px;
        background-color: transparent;
        padding: 4px;
    }

</style>
<!-- inner heading  -->
<div class="bg-green text-white text-center pt-1 pb-1" style="font-size: 120%;">
    <b> Submitted Applications</b>
</div>

<!-- start -->
<div class="container-fluid mt-4 mb-4  ">
    <!-- center div  -->
    <div class=" p-2 bg-white shadow p-3 ">

        <!-- Alert on set - Flashdata -->
        <?= $this->include("alert_box.php") ?>
        <div class="data_show">
            <div class="row">
                <div class="col-1 my-auto">
                    <select name="pageShow" id="itemsPerPageDropdown">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="col-11">
                    <input type="text" name="search" placeholder="Search" class="search_input" id="search_input" onkeyup="apply_filter()">
                </div>
            </div>
            <div class="row">
                <div class="col-12 table-responsive-sm" id="render_table">
                    <!-- Table Render -->
                </div>
            </div>
        </div>

    </div>
</div>


<?= $this->endSection() ?>

<!---------- custom_script -->
<?= $this->section('custom_script') ?>

<script>
    // Pagination Code
    var itemsPerPage = 10;
    var search_input = "";
    load_data();


    $(document).on('click', '.pagination li a', function(event) {
            event.preventDefault();
            var page = $.trim($(this).attr("href"));
            page = page.split("?");
            page = page[1].split("&");
            page = page[0].split("page=");

            page = page[1];

            load_data(page);

    });

    $(document).on('change', '#itemsPerPageDropdown', function() {
        itemsPerPage = $(this).val();
        load_data(1); // Reset to page 1 when itemsPerPage changes
    });

    function apply_filter(){
        search_input = $("#search_input").val();
        load_data();
    }
    
    function load_data(page = 1) {
        // var body = `
        // <tr>
        //     <td colspan="8" class="text-center">Please Wait</td>
        // </tr>
        // `;
        // $("#show_here_result").html(body);
        // return;
        $.ajax({
            url: "<?= base_url('user/submitted_applications_fetch_data'); ?>",
            method: "GET",
            data: {
                page: page,
                itemsPerPage: itemsPerPage,
                search_input,
            },
            success: function(data) {
                $('#render_table').html(data);
            }
        });
    }

</script>
<?= $this->endSection() ?>