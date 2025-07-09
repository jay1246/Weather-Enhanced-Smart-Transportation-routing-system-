<!-- Modal -->
<div class="modal" id="comment_action_center" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-xl" style="margin-top: 123px">
    <div class="modal-content" id="comment_action_approval_box" style="background-color: white;">
        
        </div>
    </div>
</div>
<!---->


<script>
function __openTheAlertMessage(pointer_id){
    // console.log(pointer_id);
    $('#cover-spin').show();
    fetch_backend_comment_data(pointer_id);
}

function fetch_backend_comment_data(pointer_id){
    $.post("<?= base_url("admin/application_manager/show_s1_s2_s3_comments") ?>",{
        pointer_id
    },function(data){
        // console.log(data);
        // return;
        data = JSON.parse(data);
        
        drawPopupofComment(data);    
    });
}


function softDeleteTheRecordComment(selector){
    $(selector).remove();
}

function hardDeleteTheRecordComment(id, selector){
    custom_alert_popup_show(header = '', body_msg = "Are you sure you want to delete the note ?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD_delete_comment');
    $("#AJDSAKAJLD_delete_comment").click(function() {
        if (custom_alert_popup_close('AJDSAKAJLD_Yes')) {
            $(selector).remove();
            $.post("<?= base_url("admin/comment_store_documents/deleteTheRecord") ?>",{
                id,
            },function(res){
              console.log("Deleted => ", res);
            
            });
        }
    });
}

function drawPopupofComment(data){
    var stage1_tr = "";
    var stage2_tr = "";
    var stage3_tr = "";
    var admin_account_type = data["admin_account_type"];
    // Random Numbers
    let random_no = getTheUniqueNumberSet();
    if(data["stage_1_comment_msg"]){
    var options = '';
    if(admin_account_type == "admin"){
        options = `
         <td>
            <a class="btn btn_green_yellow disabled">
                <i class="bi bi-plus"></i>
            </a>
            <a class="btn btn-danger" onclick="delete_comment_single(${data["pointer_id"]},'#stage1_${random_no}','stage_1')" title="Delete">
                <i class="bi bi-trash"></i>
            </a>
        </td>
        
        `;
    }    
        
    
    stage1_tr = `
    <tr id="stage1_${random_no}" style="border: 1px solid #065837">
        <td>S1</td>
        <td>${data["stage_1_comment_msg"]}</td>
        ${options}
    </tr>
    `;
    }
    
    if(data["stage_2_comment_msg"]){
    var options = "";
    if(admin_account_type == "admin"){
        var enable_add = `
        <a class="btn btn_green_yellow disabled" title="Add">
                <i class="bi bi-plus"></i>
            </a>
        `;
        
        if(data["current_stage"] == "stage_2" && data["current_status"] == "Approved"){
            enable_add = ` 
            <a class="btn btn_green_yellow" onclick="add_new_fields(${data["pointer_id"]},'#stage2_${random_no}','stage_2')" title="Add">
                <i class="bi bi-plus"></i>
            </a>
            
            `;
        }
        
        options = `
        <td>
            ${enable_add}
            <a class="btn btn-danger" onclick="delete_comment_single(${data["pointer_id"]},'#stage2_${random_no}','stage_2')" title="Delete">
                <i class="bi bi-trash"></i>
            </a>
        </td>
        `;
    }
    
    stage2_tr = `
    <tr id="stage2_${random_no}" style="border: 1px solid #065837">
        <td>S2</td>
        <td>${data["stage_2_comment_msg"]}</td>
        ${options}
    </tr>
    `;
    
    if(data["stage_2_comment_docs"].length > 0){
        // Draw the Document which is requested -> Mohsin
        stage2_tr += drawTheDocumentList(data["stage_2_comment_docs"],admin_account_type);
        // end
    }
    
    
    }
        
    if(data["stage_3_comment_msg"]){
    var options = "";
    if(admin_account_type == "admin"){
        
        var enable_add = `
            
            <a class="btn btn_green_yellow disabled" title="Add">
                <i class="bi bi-plus"></i>
            </a>
        `;
        
        if(data["current_stage"] == "stage_3" && data["current_status"] == "Approved"){
            enable_add = `
            
            <a class="btn btn_green_yellow" onclick="add_new_fields(${data["pointer_id"]},'#stage3_${random_no}','stage_3')" title="Add">
                <i class="bi bi-plus"></i>
            </a>
        `;
        }
        
        options = `
        <td>
        ${enable_add}
            <a class="btn btn-danger" onclick="delete_comment_single(${data["pointer_id"]},'#stage3_${random_no}','stage_3')" title="Delete">
                <i class="bi bi-trash"></i>
            </a>
        </td>
        `;
    }
    stage3_tr = `
    <tr id="stage3_${random_no}" style="border: 1px solid #065837">
        <td>S3</td>
        <td>${data["stage_3_comment_msg"]}</td>
        ${options}
    </tr>
    `;
    
        if(data["stage_3_comment_docs"].length > 0){
            // Draw the Document which is requested -> Mohsin
            stage3_tr += drawTheDocumentList(data["stage_3_comment_docs"],admin_account_type);
            // end
        }
    }
    
    
    var no_data_found = "";
    if(stage1_tr == "" && stage2_tr == "" && stage3_tr == ""){
        no_data_found = `
            <tr>
                <td class="text-center font-weight-bold" colspan="3">No Data Found</td>
            </tr>
        `;
    }
    
    var delete_all_comments = "";
    if(no_data_found == "" && admin_account_type == "admin"){
         delete_all_comments = `
         <a onclick="delete_all_comments(${data["pointer_id"]})" class="btn btn-sm btn-danger ms-auto">
            <i class="bi bi-trash"></i>
            <b>Delete all notes</b>
        </a>
         `;
    }
    var th_options = "";
    if(admin_account_type == "admin"){
    th_options = `
    
                        <th style="width: 10%"> Action </th>
    `;
    }
    var body = `
    <div class="modal-header">
        <h4 class="modal-title text-center text-success">IMPORTANT NOTE</h4>
        ${delete_all_comments}
    </div>
    <div class="modal-header">
        <h5 class="modal-title text-center text-green"> ${data["application_no"]} ${data["applicant_name"]} - ${data["occupation"]}</h5>
    </div>
    <!-- Modal Body -->
    <div class="modal-body">
        <div class="table">
            <!--  Table with stripped rows starts -->
            <table class="table table-striped datatable">
                <thead>
                    <tr>
                        <th style="width: 10%"> Stage </th>
                        <th> Comments </th>
                        ${th_options}
                    </tr>
                </thead>
                <tbody>
                ${stage1_tr}
                ${stage2_tr}
                ${stage3_tr}
                ${no_data_found}
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal Body -->
    `;
    $('#cover-spin').hide();
    $("#comment_action_center").modal("show");
    
    $("#comment_action_approval_box").html(body);
}

function getTheUniqueNumberSet(){
    return Math.floor((Math.random() * 100000) + 1);
}


function makeEditViewComment(pointer_id, value, table_name, selector, primary_key, id){
    
    var tr = `
        <td></td>
        <td>
            <input class="form-control" id="input_docs_${primary_key}" value="${value}">
        </td>
        <td>
            <a class="btn btn_green_yellow" title="Save" onclick="saveToTheCommentDocs('${pointer_id}', '${selector}', '${table_name}', '#input_docs_${primary_key}','${selector}', ${primary_key}, ${id})">
                <i class="bi bi-check"></i>
            </a>
            <a class="btn btn-danger" title="Delete" onclick="hardDeleteTheRecordComment(${id},'${selector}')">
                <i class="bi bi-trash"></i>
            </a>
        </td>
    `;
    $(selector).html(tr);
}

function drawTheDocumentList(docs,admin_account_type){
    var tr = '';
    console.log("Docs => ", docs);
    docs.forEach(doc => {
        var random_no = getTheUniqueNumberSet();
        var setupTheALink = `<span>${doc["name"]}</span>`;
        var action_btns = `
                <td>
                <a class="btn btn_green_yellow" onclick="makeEditViewComment(${doc["pointer_id"]}, '${doc["name"]}', '${doc["stage"]}', '#tr_save_mode_${random_no}', ${random_no}, ${doc["id"]})">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <a class="btn btn-danger" onclick="hardDeleteTheRecordComment(${doc["id"]},'#tr_save_mode_${random_no}')">
                    <i class="bi bi-trash"></i>
                </a>
                </td>
        `;
        if(doc["document_id"] != 0){
            console.log("Document Link => ", doc["documents_full_link"]);
            setupTheALink = `
                <a href="${doc["documents_full_link"]}" target="_blank">
                    <span>${doc["name"]}</span>
                </a>
                `;
                
            action_btns = `
                
            <td>
                <a class="btn btn_green_yellow disabled">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <a class="btn btn-danger disabled">
                    <i class="bi bi-trash"></i>
                </a>
            </td>
            `;
        }
        if(admin_account_type != "admin"){
            setupTheALink = `<span>${doc["name"]}</span>`;
            action_btns = ``;
        }
        tr += `
        <tr id="tr_save_mode_${random_no}">
            <td>
            </td>
            
            <td>
                ${setupTheALink}
            </td>
            
                ${action_btns}
        </tr>
        `;
    });
    
    return tr;
}

function add_new_fields(pointer_id, selector, table_name){
    // let unqiue_string = Math.floor((Math.random() * 100000) + 1)."_aqato_".Math.floor((Math.random() * 100000) + 1);
    // Check Whether Existing Input is Fields
        var exit_yes = "";
        document.querySelectorAll(".selector_class_"+table_name).forEach(function(input_fields) {
            // Now do something with my button
            // console.log(button);
            if($(input_fields).val().trim() == ""){
                $(input_fields)[0].setCustomValidity("Please fill the input.");
                $(input_fields)[0].reportValidity();
                exit_yes = "yes";
                return;
            }
        });
        
    
    if(exit_yes != ""){
        return;
    }
    
    // 
    let unqiue_string = getTheUniqueNumberSet();
    var html = `
        <tr id="tr_docs_input_docs_${unqiue_string}">
            <td></td>
            <td>
                <input class="form-control selector_class_${table_name}" id="input_docs_${unqiue_string}" placeholder="Specify Document Name">
            </td>
            <td>
                <a class="btn btn_green_yellow" title="Save" onclick="saveToTheCommentDocs('${pointer_id}', '${selector}', '${table_name}', '#input_docs_${unqiue_string}','#tr_docs_input_docs_${unqiue_string}', ${unqiue_string})">
                    <i class="bi bi-check"></i>
                </a>
                <a class="btn btn-danger" title="Delete" onclick="softDeleteTheRecordComment('#tr_docs_input_docs_${unqiue_string}')">
                    <i class="bi bi-x"></i>
                </a>
            </td>
        </tr>
    `;
    
    $(selector).after(html);
}

function saveToTheCommentDocs(pointer_id, selector, table_name, input_fields, input_tr_div, primary_key,id = ""){
    
    var input_data = $(input_fields).val();
    input_data = input_data.trim();
    if(!input_data){
        $(input_fields)[0].setCustomValidity("Please fill the input.");
        $(input_fields)[0].reportValidity();
        return;
    }
    
    
    $.post("<?= base_url("admin/comment_store_documents/insertTheFile") ?>",{
        pointer_id,
        table_name,
        input_data,
        id,
    },function(res){
        console.log(res);
        reDrawInput(JSON.parse(res), input_tr_div, primary_key);
    });
}

function reDrawInput(data, input_tr_div, primary_key){
    // 
    var html = `
            <td></td>
            <td>
                <span>${data["name"]}</span>
            </td>
            <td>
                <a class="btn btn_green_yellow" title="Edit" onclick="makeEditViewComment(${data["pointer_id"]}, '${data["name"]}', '${data["stage"]}', '${input_tr_div}', ${primary_key}, ${data["id"]})">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <a class="btn btn-danger" title="Delete" onclick="hardDeleteTheRecordComment(${data["id"]},'${input_tr_div}')">
                    <i class="bi bi-trash"></i>
                </a>
            </td>
    `;
    
    $(input_tr_div).html(html);
}

function delete_comment_single(pointer_id, selector, table_name){
    custom_alert_popup_show(header = '', body_msg = "Are you sure, you want to delete note ?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD_Yes');
    $("#AJDSAKAJLD_Yes").click(function() {
        if (custom_alert_popup_close('AJDSAKAJLD_Yes')) {
            // $(selector).remove();
            $('#cover-spin').hide();
            // Call the Api to delete single
            $.post("<?= base_url("admin/application_manager/show_s1_s2_s3_comments_single_delete") ?>",{
                pointer_id,
                table_name
            },function(res){
                console.log("Single Delete => ", res);
                if(!res){
                    location.reload();
                    return;
                }
                __openTheAlertMessage(pointer_id);
            });
        }
    });
}

function delete_all_comments(pointer_id){
    custom_alert_popup_show(header = '', body_msg = "Are you sure, you want to delete all notes ?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD_all');
    $("#AJDSAKAJLD_all").click(function() {
        if (custom_alert_popup_close('AJDSAKAJLD_all')) {
            $('#cover-spin').show();
            // Call the Api to delete single all
            $.post("<?= base_url("admin/application_manager/show_s1_s2_s3_comments_all_delete") ?>",{
                pointer_id,
            },function(res){
                console.log("Multi Delete => ", res);
                location.reload();
                // $("#comment_action_center").modal("hide");
                // $('#cover-spin').hide();
            });
        }
    });
   
}
    
</script>