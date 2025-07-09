<?= $this->extend('template/admin_template') ?>
<?= $this->section('main') ?>
<style>
    .nav-tabs .nav-item .nav-link {
        color: black;
    }

    * {
        font-family: "Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif;
    }

    /* #main {
        margin-top: 100px;
    } */
    .pg_link{
        font-color:#009933;
    }

    .nav-link {
        font-weight:bold;
        color: #055837;
    }
    .nav-link:hover {
        font-weight:bold;
        background-color: #FFC107 !important;
        color: #055837 !important;
    }

    .active_btn {
        font-weight:bold;
        background-color: #055837 !important;
        color: #FFC107 !important;
    }


    .active_btn:hover {
        font-weight:bold;
        background-color: #FFC107 !important;
        color: #055837 !important;
    }

    .btn_green {
        background-color: #055837 !important;
        color: #FFC107 !important;
    }

    .btn_green:hover {
        background-color: #FFC107 !important;
        color: #055837 !important;
    }
    .pdf_design,.pdf_design:hover{
        background-color: #B40B00;
        color: white;
    }
    .excel_design,.excel_design:hover{
        background-color: green;
        color: white;
    }
</style>
<style>
    /* CSS */
.tooltip-wrapper {
  position: relative;
  display: inline-block;
}

.tooltip {
    visibility: hidden;
    background-color: #555;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    /* padding-bottom: 20px; */
    height: 60%;
    width: max-content;
    position: absolute;
    z-index: 1;
    bottom: 125%;
    left: 72%;
    top: -16px;
    margin-left: -60px;
    opacity: 0;
    transition: opacity 0.3s;
}

.tooltip-wrapper:hover .tooltip {
  visibility: visible;
  opacity: 1;
}

</style>

<main id="main" class="main" style="width: 100%;">
    <div class="pagetitle">
        <h4 class="text-green">Admin Functions -> Reporting</h4>
    </div>
    <section class="section dashboard mt-3 shadow">
        <div class="card card-primary card-outline card-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link active active_btn  active" id="custom-tabs-agent-tab" href="<?= base_url("admin/admin_functions") ?>" role="tab" aria-controls="custom-tabs-agent" aria-selected="false">Reporting</a>
                    </li>
                    <?php 
                    $session = session();
                    if($session->admin_id == 1){
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url("admin/admin_functions/accounting") ?>" id="custom-tabs-applicant-tab" role="tab" aria-controls="custom-tabs-applicant" aria-selected="true">Accounting</a>
                    </li>

                    <?php 
                    }
                    ?>
                    
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-applicant-tab" role="tab" aria-controls="custom-tabs-applicant" aria-selected="true">Data Analysis</a>
                    </li>
                </ul>
                <select name="pageShow" id="itemsPerPageDropdown" style="float: right;margin-top: -35px;margin-right: 10px;">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>


            <div class="tab-content" id="custom-tabs-three-tabContent">

                <div class="tab-pane fade show active" id="custom-tabs-agent" role="tabpanel" aria-labelledby="custom-tabs-agent-tab">
                    <div class="card-body table-responsive">
                        <div class="row mb-2">
                            <div class="col-12 px-2">
                                <div class="row g-0">
                                    <div class="col-9">
                                        <div class="row gx-1">
                                            <div class="col-2">
                                                <label><b>From Date</b></label>
                                                <input type="date" name="from_date" id="from_date" class="form-control">
                                            </div>
                                            <div class="col-2">
                                                <label><b>To Date</b></label>
                                                <input type="date" name="to_date" id="to_date" class="form-control" max="<?= date("Y-m-d") ?>">
                                            </div>
                                            <div class="col-2">
                                                <label><b>Stage</b></label>
                                                <select name="stage" id="stage" class="form-select" onchange="__changeDropdown(this.value)">
                                                    <option value="">All</option>
                                                    <option value="stage_1">Stage 1</option>
                                                    <option value="stage_2">Stage 2</option>
                                                    <option value="stage_3">Stage 3</option>
                                                    <!--<option value="stage_3_R">Stage 3 (R)</option>-->
                                                    <option value="stage_4">Stage 4</option>
                                                </select>
                                            </div>
                                            
                                            <div class="col-2">
                                                <label><b>Status</b></label>
                                                <select name="status" id="status" class="form-select">
                                                    <option value="">All</option>
                                                    <option value="submitted">Submitted</option>
                                                    <option value="lodged">Lodged</option>
                                                    <option value="in_progress">In Progress</option>
                                                    <option value="approved">Approved</option>
                                                    <option value="omitted">Omitted</option>
                                                    <option value="declined">Declined</option>
                                                    <option value="closed">Closed</option>
                                                </select>
                                            </div>

                                            <div class="col-2">
                                                <label><b>Current Status</b></label>
                                                <select name="current_status" id="current_status" class="form-select" onchange="search_filter()">
                                                    <option value="">All</option>
                                                    <!-- <option value="submitted">Submitted</option>
                                                    <option value="lodged">Lodged</option>
                                                    <option value="in_progress">In Progress</option>
                                                    <option value="approved">Approved</option>
                                                    <option value="declined">Declined</option>
                                                    <option value="closed">Closed</option> -->
                                                </select>
                                            </div>
                                            
                                            <div class="col-2 tooltip-wrapper">
                                                <label><b>Agent / Applicant</b></label>
                                                <select name="agent_name" class="form-select" id="agent_id" onchange="search_filter()">
                                                    
                                                </select>
                                                <span id="agent_tooltip">
                                                    <!-- <span class="tooltip">Select your favorite fruit</span> -->
                                                </span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3" style="margin-top: 23px;">
                                        <button type="button" class="btn btn_green_yellow" id="__search_btn" data-toggle="tooltip" data-placement="top" title="Search" style="margin-left: 10px;" onclick="search_filter()">
                                            <i class="bi bi-search"></i>
                                        </button>

                                        
                                        <a href="<?= base_url("admin/admin_functions") ?>" class="btn btn_yellow_green" id="__clear_btn" data-toggle="tooltip" data-placement="top" title="Refresh">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </a>

                                        <a class="btn" onclick="toggle_arrow('#arrow_icon')"  data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" title="Advance Option">
                                            <!-- <span>Advanced Option</span> -->
                                            <span id="arrow_icon">
                                                <i class="bi bi-caret-down-fill"></i>
                                            </span>
                                        </a>

                                        
                                        <a class="btn float-end excel_design mx-1" title="Export to Excel" onclick="_export_to_spreadsheet()">
                                            <i class="bi bi-file-earmark-spreadsheet"></i>
                                        </a>

                                        
                                        <a class="btn float-end pdf_design mx-1" title="Export to PDF" onclick="_export_to_pdf()">
                                            <i class="bi bi-file-pdf-fill"></i>
                                        </a>
                                    </div>
                                </div>

                                <!-- Collapse -->
                                
                                <div class="collapse my-2" id="collapseExample">
                                    <div class="card card-body">
                                        <div class="row">
                                            <div class="col">
                                                <label><b>PRN</b></label>
                                                <input type="text" name="prn_no" class="form-control" id="prn">
                                            </div>
                                            <div class="col">
                                                <label><b>Applicant No.</b></label>
                                                <input type="text" name="applicant_no" class="form-control" id="applicant_no">
                                            </div>
                                            <div class="col">
                                                <label><b>Pathway</b></label>
                                                <select class="form-select" name="pathway" id="pathway">
                                                    <option value="">All</option>
                                                    <option>Pathway 1</option>
                                                    <option>Pathway 2</option>
                                                </select>
                                            </div>
                                            
                                            
                                            <div class="col">
                                                <label><b>D.O.B</b></label>
                                                <input type="date" name="dob" class="form-control" id="dob">
                                            </div>
                                            
                                            <div class="col">
                                                <label><b>Occupation</b></label>
                                                <select name="occupation" class="form-select" id="occupation">
                                                    <option value="">All</option>
                                                    <?php 
                                                    foreach($occupations as $occupation){
                                                        ?>
                                                        <option value="<?= $occupation["id"] ?>"><?= $occupation["name"] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            
                                            <!-- <div class="col-4">
                                                <label>Current Status</label>
                                                <input type="text" name="current_status" class="form-control">
                                            </div> -->
                                            
                                        </div>
                                    </div>
                                </div>
                                <!-- Collpase -->
                            </div>
                        </div>
                        <hr class="mb-0">
                        <div id="reporting_table">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?= $this->endSection() ?>
<?= $this->section("custom_script") ?>
<script>
var arrow_listen = 0;
function toggle_arrow(selector){
    var arrow_select = (arrow_listen == 0) ? `<i class="bi bi-caret-up-fill"></i>` : `<i class="bi bi-caret-down-fill"></i>`;
    $(selector).html(arrow_select);
    arrow_listen = (arrow_listen == 0) ? 1 : 0;
}
</script>
<script>
        var itemsPerPage = 10;
        var search_input = '';
        var search_flag = "";
        var from_date = to_date = stage = status = prn = applicant_no = agent = d_o_b = occupation = agent_id = current_status = pathway =  "";
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


    function __make_DropDown_Current_Status(){
        console.log(current_status);
        $("#current_status").html("<option value=''>All</option>");
        $("#current_status").html(options_html);
        $('#current_status').val(current_status);
    }

    function search_filter() {
            // if ($('#collapseExample').hasClass('show')) {
            //     // the collapse is open
            //     $("#collapseExample").collapse('hide');
            //     toggle_arrow('#arrow_icon');
            // } 
            search_input = $("#search_input").val();
            from_date = $("#from_date").val();
            to_date = $("#to_date").val();
            stage = $("#stage").val();
            status = $("#status").val();
            prn = $("#prn").val();
            applicant_no = $("#applicant_no").val();
            d_o_b = $("#dob").val();
            occupation = $("#occupation").val();
            agent_id = $("#agent_id").val();
            current_status = $("#current_status").val();
            pathway = $("#pathway").val();
            
            
            
            __make_DropDown_Current_Status();
            __makeDropDownBack();
            // Reset ItemsPerPAge
            itemsPerPage = 10;
            load_data(1); // Reset to page 1 when itemsPerPage changes
        }
        function __makeDropDownBack(){
        

        var html = `
        
        <option value="10">10</option>
        <option value="25">25</option>
        <option value="50">50</option>
        <option value="100">100</option>
        `;
        $("#itemsPerPageDropdown").html(html);
    }
        
        function load_data(page = 1) {
            // console.log(pathway);
            // return;
            // var body = `
            // <tr>
            //     <td colspan="8" class="text-center">Please Wait</td>
            // </tr>
            // `;
            // $("#pagination__table__body").html(body);
            load_agent_data(page);
            $.ajax({
                url: "<?= base_url('admin/admin_functions/fetch_application_records'); ?>",
                method: "GET",
                data: {
                    page: page,
                    itemsPerPage: itemsPerPage,
                    search_input: search_input,
                    search_flag: search_flag,
                    from_date,
                    to_date,
                    stage,
                    status,
                    prn,
                    applicant_no,
                    d_o_b,
                    occupation,
                    agent_id,
                    current_status,
                    pathway,
                },
                success: function(data) {
                    $('#reporting_table').html(data);
                }
            });
        }

        function load_agent_data(page=1){
            $("#agent_tooltip").html('');
            $.ajax({
                url: "<?= base_url('admin/admin_functions/fetch_application_records_agent'); ?>",
                method: "GET",
                data: {
                    page: page,
                    itemsPerPage: itemsPerPage,
                    search_input: search_input,
                    search_flag: search_flag,
                    from_date,
                    to_date,
                    stage,
                    status,
                    prn,
                    applicant_no,
                    d_o_b,
                    occupation,
                    agent_id,
                    current_status,
                    pathway,
                },
                success: function(data) {
                    // console.log(data);
                    // return;
                    data = JSON.parse(data);
                    var selected_agent_id = $("#agent_id").val();
                    var options_agent = '<option value="">Select Agent / Applicant</option>';
                    var tooltip_string = "";
                    data.forEach(ele => {
                        var selected_agent = (selected_agent_id == ele["id"]) ? "selected" : "";
                        var full_name = (ele["business_name"]) ? ele["business_name"] : ele["name"]+" "+ele["last_name"];
                        options_agent += `<option value="${ele["id"]}" ${selected_agent}>${full_name} - ${ele["agent_count"]}</option>`;
                        if(selected_agent){
                            __fetch_country_code(ele);
                        }
                    });
                    $("#agent_id").html(options_agent);
                }
            });
        }

        
        function __fetch_country_code(ele){
            var tooltip_string = "";
            $.post("<?= base_url("admin/admin_functions/getTheCountry") ?>",{
                country_id: ele["mobile_code"],
            },function(res){
                console.log(res);
                res = JSON.parse(res);
                // return;
                tooltip_string = `<span class="tooltip">(${ele["email"]} / +${res["phonecode"]} ${ele["mobile_no"]})</span>`;
                $("#agent_tooltip").html(tooltip_string);
            });
            
        }
        
        function _export_to_pdf(page=1){
            $('#cover-spin').show(0);
            $.ajax({
                url: "<?= base_url('admin/admin_functions/download_report'); ?>",
                method: "GET",
                data: {
                    page: page,
                    itemsPerPage: itemsPerPage,
                    search_input: search_input,
                    search_flag: search_flag,
                    from_date,
                    to_date,
                    stage,
                    status,
                    prn,
                    applicant_no,
                    d_o_b,
                    occupation,
                    agent_id,
                    current_status,
                    pathway,
                },
                success: function(data) {
                    console.log(data);
                    $('#cover-spin').hide(0);
                    window.open(data, "_blank");
                }
            });
        }

        
        function _export_to_spreadsheet(page=1){
            $('#cover-spin').show(0);
            $.ajax({
                url: "<?= base_url('admin/admin_functions/download_report_spreadsheet'); ?>",
                method: "GET",
                data: {
                    page: page,
                    itemsPerPage: itemsPerPage,
                    search_input: search_input,
                    search_flag: search_flag,
                    from_date,
                    to_date,
                    stage,
                    status,
                    prn,
                    applicant_no,
                    d_o_b,
                    occupation,
                    agent_id,
                    current_status,
                    pathway,
                },
                success: function(data) {
                    console.log(data);
                    $('#cover-spin').hide(0);
                    window.open(data, "_blank");
                }
            });
        }

        function clear_filter(){
            search_input = "";
            $("#search_input").val(search_input);
            itemsPerPage = 10;
            search_flag = from_date = to_date = "";
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

        var __status_dropdown;
        var options_html = "";
        function __changeDropdown(stage){
            options_html = "<option value=''>All</option>";
            var __dropdown_status = {
                    "Submitted": "submitted",
                    "Lodged": "lodged",
                    "In_Progress": "in_progress",
                    "Scheduled": "scheduled",
                    "Conducted": "conducted",
                    "Approved": "approved",
                    "Omitted": "omitted",
                    "Declined": "declined",
                    "Closed": "closed",
            };
            // console.log(__dropdown_status.In_Progress);
            // return;
            if(stage == "stage_3" || stage == "stage_3_R" || stage == "stage_4"){
                __status_dropdown = {
                    
                "submitted" : "Submitted",
                "lodged" : "Lodged",
                "in_progress" : "In Progress",
                "scheduled": "Scheduled",
                "conducted": "Conducted",
                "approved" : "Approved",
                "declined" : "Declined",
                "closed" : "Closed",   

                };
            }
            else if(stage == "stage_1"){
                __status_dropdown = {
                    "submitted" : "Submitted",
                    "lodged" : "Lodged",
                    "in_progress" : "In Progress",
                    "approved" : "Approved",
                    "omitted" : "Omitted",
                    "declined" : "Declined",
                    "closed" : "Closed",
                };
            }
            else{
                __status_dropdown = {
                    "submitted" : "Submitted",
                    "lodged" : "Lodged",
                    "in_progress" : "In Progress",
                    "approved" : "Approved",
                    "declined" : "Declined",
                    "closed" : "Closed",
                };
            }


            Object.values(__status_dropdown).forEach((value, key) => {
                var new_value = value.replace(" ", "_");
                var __key = __dropdown_status[new_value];
                console.log(__dropdown_status[new_value]);
                options_html += `<option value='${__key}'>${value}</option>`;
            });
            // console.log(options_html);
            $("#status").html(options_html);
            $("#current_status").html(options_html);
            search_filter();
        }
</script>
<?= $this->endSection() ?>