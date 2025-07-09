<?= $this->extend('template/admin_template') ?>
<?= $this->section('main') ?>
<style>
    .flag_button{
        padding: 10px 15px;
        margin: 0 5px;
        float: right;
        border-radius: 5px;
    }
    .filter_flag{
        width: 12px;
    }
    #itemsPerPageDropdown{
        border: 1px solid #aaa;
        border-radius: 3px; 
        padding: 5px;
        background-color: transparent;
        padding: 4px;
    }

    /* #__search_btn:hover + #__clear_btn{
        background-color: #055837;
        color: #FFCC01;
    }

    
    #__clear_btn:hover < #__search_btn{
        background-color: #FFCC01;
        color: #055837;
    } */

</style>
<main id="main" class="main">
    <div class="pagetitle">
        <h4 style="color: #055837;">Application Manager</h4>
    </div>

    <section class="section dashboard mt-3 card shadow">
        
        <!-- <div class="row">
            <div class="col-12">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium odio iste dolor totam blanditiis id reiciendis laborum dolores? Provident consequuntur, repudiandae nobis voluptatum obcaecati adipisci qui sequi accusamus omnis reiciendis.
            </div>
        </div> -->

        <div class="row g-0 p-2">
            <div class="col-2 my-auto">
            
                <!-- <div class="sub_bottom_pagination" style="position: absolute;
            bottom: 62px;
            right: 10px;"> -->
                    <select name="pageShow" id="itemsPerPageDropdown">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                <!-- </div> -->
            </div>
            <div class="col-8 my-auto">
                <div class="row g-0">
                    <div class="col-10">
                        <input type="text" name="search" class="form-control" placeholder="Search" id="search_input" value="<?= $__search_input ?>">
                    </div>
                    <div class="col-2 my-auto">
                        <button type="button" class="btn btn_green_yellow" id="__search_btn" data-toggle="tooltip" data-placement="top" title="Search" style="margin-left: 10px;" onclick="search_filter()">
                            <i class="bi bi-search"></i>
                        </button>
                        <button type="button" class="btn btn_yellow_green" id="__clear_btn" data-toggle="tooltip" data-placement="top" title="Refresh" onclick="clear_filter()">
                            <i class="bi bi-arrow-clockwise"></i>
                        </button>
                    </div>

                </div>
            </div>
            <!-- <div class="col-2">
                <a class="btn"  data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    More Option
                    <i class="bi bi-caret-down-fill"></i>
                </a>
            </div> -->
            <div class="col-2 my-auto">
                    <button onclick="add_flag_filter('send')" class="flag_button red_btn" id="red_flag_btn" data-toggle="tooltip" data-placement="top" title="Additional Information Requested" type="button" style="border: 1px solid white;">
                        <img id="id_flag_red" class="filter_flag" src="<?= base_url() ?>/public/assets/icon/flag-red.png">
                    </button>
                    <button onclick="add_flag_filter('upload')" class="flag_button grn_btn" id="green_flag_btn" type="button" style="border: 1px solid white;"  data-toggle="tooltip" data-placement="top" title="Additional Information Received">
                        <img id="id_flag_green" class="filter_flag" src="<?= base_url() ?>/public/assets/icon/flag-green.png">
                    </button>
            </div>
        </div>

        <div class="collapse" id="collapseExample">
            <div class="card card-body">
                <div class="row">
                    <div class="col-4">
                        <label>PRN</label>
                        <input type="text" name="prn_no" class="form-control">
                    </div>
                    <div class="col-4">
                        <label>Applicant No.</label>
                        <input type="text" name="applicant_no" class="form-control">
                    </div>
                    
                    <div class="col-4">
                        <label>D.O.B</label>
                        <input type="text" name="dob" class="form-control">
                    </div>
                    
                    <div class="col-4">
                        <label>Occupation</label>
                        <input type="text" name="occupation" class="form-control">
                    </div>
                    
                    <div class="col-4">
                        <label>Current Status</label>
                        <input type="text" name="current_status" class="form-control">
                    </div>
                    
                </div>
            </div>
        </div>
        

    </section>

    <section class="section dashboard mt-3 card shadow p-2">
        <div id="data_container">
            <!-- Paginated data will be loaded here via AJAX -->
        </div>
    </section>
</main>

<?= $this->endSection() ?>
<?= $this->section('custom_script') ?>
<script>
        var itemsPerPage = 10;
        var search_input = '<?= $__search_input ?>';
        var search_flag = "";
        load_data();

        $(document).on('click', '.pagination li a', function(event) {
            event.preventDefault();
            var page = $.trim($(this).attr("href"));
            page = page.split("?");
            page = page[1].split("&");
            page = page[0].split("page=");
            // console.log(page);
            // return;
            page = page[1];
            // console.log(page);
            // return;
            load_data(page);

            // // Dropdown change event
            // $('#itemsPerPageDropdown').change(function() {
            //     var value = $(this).val();
            //     console.log(value);
            //     itemsPerPage = value;
            //     load_data();
            // });
            // $("#search_btn").on("click", function(){
            //     var search_input = $("#search_input").val();
            //     console.log(search_input);
            // });
        });

        $(document).on('change', '#itemsPerPageDropdown', function() {
            itemsPerPage = $(this).val();
            load_data(1, itemsPerPage); // Reset to page 1 when itemsPerPage changes
        });
        $(document).on("keypress", "#search_input", function(e){
            if(e.which == 13){
                search_filter();
            }
        });

        $(document).ready(function(){
            $("#__clear_btn").hover(
                function(){
                    console.log("here");
                    // On mouseenter
                    $("#__search_btn").css({
                        "background-color": "#FFCC01 !important",
                        "color": "#055837 !important"
                    });
                },
                function(){
                    // On mouseleave
                    $("#__search_btn").css({
                        "background-color": "", // Reset to original color or specify the color
                        "color": "" // Reset to original color or specify the color
                    });
                }
            );
        });
    
    function search_filter() {
            search_input = $("#search_input").val();
            console.log(search_input);
            // Reset ItemsPerPAge
            itemsPerPage = 10;
            load_data(1, itemsPerPage, search_input); // Reset to page 1 when itemsPerPage changes
        }
        function load_data(page = 1) {
            // var body = `
            // <tr>
            //     <td colspan="8" class="text-center">Please Wait</td>
            // </tr>
            // `;
            // $("#pagination__table__body").html(body);
            $.ajax({
                url: "<?= base_url('admin/application_manager/fetch_application_records'); ?>",
                method: "GET",
                data: {
                    page: page,
                    itemsPerPage: itemsPerPage,
                    search_input: search_input,
                    search_flag: search_flag,
                },
                success: function(data) {
                    $('#data_container').html(data);
                }
            });
        }

        function clear_filter(){
            search_input = "";
            $("#search_input").val(search_input);
            itemsPerPage = 10;
            search_flag = "";
            __clear_flag_filter();
            load_data(1, itemsPerPage, search_input); // Reset to page 1 when itemsPerPage changes
        }

        function add_flag_filter(flag){
            // Check Already Enable then Disabled it
            __clear_flag_filter();
            if(search_flag == flag){
                clear_filter();
                console.log("Here");
                return;
            }

            if(flag == "upload"){
                $("#green_flag_btn").css("background-color", "#EBFCDF");
                // console.log("Here");
            }

            if(flag == "send"){
                $("#red_flag_btn").css("background-color", "#FCE8E4");
            }

            search_flag = flag;

            search_input = "";
            $("#search_input").val(search_input);
            itemsPerPage = 10;
            load_data(1, itemsPerPage, search_input); // Reset to page 1 when itemsPerPage changes
        }
        function __clear_flag_filter(){
            // 
            $("#green_flag_btn").css("background-color", "#F0F0F0");
            $("#red_flag_btn").css("background-color", "#F0F0F0");
            // 
        }
</script>
<?= $this->endSection() ?>