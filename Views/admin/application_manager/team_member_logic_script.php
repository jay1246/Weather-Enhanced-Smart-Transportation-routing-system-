<script>
    
    var pointer_id = <?= $pointer_id ?>;
    var current_team_member = "";
    $("#team_member_allocation_form").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(document.getElementById("team_member_allocation_form"));
        // Ignore Confirm Not looking good
        // custom_alert_popup_show(header = '', body_msg = "Are you sure you want to change status?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'stage_1_pop_btn');
        // // check Btn click
        //         $("#stage_1_pop_btn").click(function() {
        //             console.log("Clicked");
        //         });
        $('#cover-spin').show(0);
        $.ajax({
                method: "POST",
                url: "<?php echo base_url('admin/application_manager/change_team_member'); ?>",
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    $('#cover-spin').hide(0);
                   if(data){
                       drawTeamMemberAqato();
                       __close_popup();
                   }
                }
            });

    });
    
    function drawTeamMemberAqato(){
        $.post("<?php echo base_url('admin/application_manager/change_team_member_show'); ?>",{
            pointer_id,
        },function(res){
            var data = JSON.parse(res);
            // console.log(data);
            // return;
            if(data){
             drawTRforTeamMember(data);   
            }
        });
    }
    
    function drawTRforTeamMember(data){
        var label_name = data["main_data"]["team_member_name"];
        // console.log(data["main_data"]["id"]);
        current_team_member = data["main_data"]["team_member"];
        var selected = "";
        if(data["admin_login_id"] == 1){
            label_name = `<select name="team_members_select" id="team_members_select" class="form-select" onchange="show_edit_btn(this.value, '#change_edit_team_member_btn')">`;
            data["team_members"].forEach(ele => {
                selected = (data["main_data"]["team_member"] == ele["id"]) ? "selected" : "";
                label_name += `<option ${selected} value="${ele["id"]}">${ele["first_name"]} ${ele["last_name"]}</option>`;
            });
            label_name += `</select>`;
        }
        var html = `
        <tr>
            <td width="30%">AQATO Team Member</td>
            <td class="w-25">
                <div class="row">
                    <div class="col-6">
                        ${label_name}
                    </div>
                    <div class="col-md-6">
                         <a href="javascript:void(0)" id="change_edit_team_member_btn" style="display: none;" class="btn btn-sm btn_green_yellow" onclick="team_members_select_action()">
                            <i class="bi bi-check-circle" title="Save"></i>
                        </a>
                     </div>
                </div>
            </td>
        </tr>
        `;
        $("#applicant_detail_pathway").after(html);
    }
    
    function show_edit_btn(id, ele){
        if(current_team_member == id){
            $(ele).hide();
            return;
        }
        $(ele).show();
    }
    
    function highlightTheBorders(element){
        $(element).css("border", "2px solid #065837");
    }
    
    function removehighlightTheBorders(element){
        $(element).css("border", "1px solid #ced4da");
    }
    
    function team_members_select_action(){
        // Changing stuff
        $("#change_edit_team_member_btn").hide();
        highlightTheBorders("#team_members_select");
        // 
        
        var select_team_member = $("#team_members_select").val();
        $.post("<?= base_url("admin/application_manager/change_team_member") ?>",{
            team_member: select_team_member,
            pointer_id
        },function(res){
          console.log(res);
           if(res){
               current_team_member = select_team_member;
               removehighlightTheBorders("#team_members_select");
           }
        });
        // 
    }
    
    function __open_popup(){
        $("#notice_popup").css('display', 'block');
    }

    function __close_popup(){
        $("#notice_popup").css('display', 'none');
    }
    
    var team_member = <?= $app_table->team_member ?>;
    console.log("Team Member", team_member);
    <?php 
    if (session()->get('admin_account_type') == 'admin'){
    ?>
            if(!team_member){
                __open_popup();
            }
            else{
                drawTeamMemberAqato();
            }
    
    <?php 
    }
    ?>

    // $("body").on("click", () => {
    //     __close_popup();
    //     console.log("Closed");
    // });
</script>