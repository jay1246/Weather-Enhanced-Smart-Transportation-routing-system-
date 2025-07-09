
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <?php   
  if (session()->has('admin_account_type')) {
       $admin_account_type =  session()->get('admin_account_type');
    
       $admin_id =  session()->get('admin_id');
       $admin_name=session()->get('admin_name');
       $admin_email=session()->get('admin_email');
  }     
  
      $current_url_notes = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
      $parts_notes = explode('/', trim(parse_url($current_url_notes, PHP_URL_PATH), '/'));
      $pointer_id_note=(isset($parts_notes[3]) ? $parts_notes[3]:"");   

?>

<style>
    .notes_header{
        height:28rem;
        background-color: #f7f7f7;
        border: 2px solid #d2d2d2;
        border-radius: 4px;
        border-bottom-left-radius: 0px;
        border-bottom-right-radius: 0px;
    }
    .crt_ftr{
         background-color: #e9ecef;
         border: 2px solid #d2d2d2;
         position:relative;
        
    }
    .notes_input{
        resize:none;
    }
       #popup {
   width: 196px;
    height: 83px;
    display: none;
    position: absolute;
    top: -47px;
    right: 0;
    transform: translate(-50%, -50%);
    padding: 15px;
    background-color: #dcd8d8;
    border: 2px solid #ccc;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 300px;
    border-radius: 10px;     
        }
        #popup_action{
       width: 91px;
    height: 91px;
    display: none;
    position: absolute;
    top: 25%;
    left: 94.7%;
    transform: translate(-50%, -50%);
    padding: 15px;
    background-color: #dcd8d8;
    border: 2px solid #ccc;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 300px;
    border-radius: 10px;
    z-index: 3;
        }
/*        .popup {*/
/*    display: none;*/
/*    position: absolute;*/
/*    background-color: #fff;*/
/*    border: 1px solid #ccc;*/
/*    padding: 10px;*/
/*    z-index: 1;*/
/*}*/
   .text_area{
     width: 98.3%;
     /*max-width:85.3%;*/
    margin-top: 4px;
    border-radius: 10px;
    background-color: #ece9e9;
    padding: 3px 3px 0px 3px;
    display: inline-block;
    margin-left: 12px;
        }
  .text_area_reply_docs{
    border-radius: 12px;
    background-color: #ece9e9;
    padding: 3px 3px 0px 3px;
    display: inline-block;
    margin-left: 12px;
    max-width: 93%;
    position: relative;
        }
      
 .text_area {
            position: relative;
        }
       
  .drag_files{
    width: 93.5%;
    margin-left: 0px;
    margin-top: -7px;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
    background-color: #FFFFFF;
        }
     .drag_files_ui{
    box-shadow: none !important;
    outline: none !important;
    border: none !important;
    border-radius: 10px;
    min-width: 90.8%;
    max-width: 90.8%;
      } 
      
      .files_box{
     border-width:2px;
     border-radius: 10px;
     margin: 5px;
     padding: 0px 4px 6px 4px;
     background-color: #ededed;
     list-style:none;
      }
      
      .popup {
        position: absolute;
        background-color: #f9f9f9;
        border: 1px solid #ccc;
        padding: 15px;
        z-index: 1;
        background-color: #dcd8d8;
        border: 2px solid #ccc;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 300px;
        border-radius: 10px;
        display: none;
        padding-bottom: 0px;
        margin-right: 3px;
        /*right: 0;*/
        /*bottom: 1px;*/
        }
      .popup_reply_image{
            position: absolute;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            padding: 15px;
            z-index: 1;
            background-color: #dcd8d8;
            border: 2px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 300px;
            border-radius: 10px;
            display: none;
            padding-bottom: 0px;
            margin-right: 3px;
            right: -122px;
            top: -23px;
      }
      .previous_msg_note{
            padding-left: 10px;
            margin-left: 10px;
            width: 92.1%;
            margin-top: -4px;
            border-radius: 15px;
            background: #adacac26;
            max-width: 89.5%;
            min-width: 88%;
      }
      a{
          color:black;
      }
      
</style>
     <?php   if (session()->has('admin_account_type')) {?>
 <section style=" margin-top: 3px;" >
  <div>
     <div id="show_notes_all_data" class="notes_header" style="overflow-y:scroll;"> 
   

     </div>
     
     </div>
     
  <!--ondragover="allowDrop(event) ondrop="handleDrop(event)""-->
   <div class="card-footer crt_ftr">
     
        <div id="popup">
    <p class="cursor_" style="line-height: 2px;" data-bs-toggle="modal" data-bs-target="#images_popup"  onclick="hide_options('images')"><i class="bi bi-file-image" ></i>&nbsp Images</p>
    <p class="cursor_" style="line-height: 2px;" data-bs-toggle="modal" data-bs-target="#images_popup" onclick="hide_options('docs')" ><i class="bi bi-file-earmark-text"></i>&nbsp Documents</p>
  </div>
       <div style="display:none;" class="row align-items-center position-relative mb-2" id="showhidereply_note">
        <div class="col-10 previous_msg_note" id="previous_msg_note"></div>
        <button id="btn_close" style="float: right;position: absolute;right: 7.5%;top: 31%;" class="btn btn-close" onclick="deleteDiv_note()"></button>
      </div>
      
      <div style="display:none;" class="row align-items-center position-relative mb-2" id="showeditoldmessage">
        <div class="col-10 previous_msg_note" style="height: auto;padding: 9px;margin-left: 13px;width: 91.9%;" id="old_msg_note"></div>
        <button id="btn_close" style="float: right;position: absolute;right: 7.5%;top: 31%;" class="btn btn-close" onclick="hide_edit_popup()"></button>
      </div>
    
  <div id="progress" style="display:none;width:90.8%"  class="progress" role="progressbar"   aria-valuenow="0">
     <div id="progress_bar" class="progress-bar progress-bar-striped bg-success" min="0"  ></div>
             <button id="btn_close" style="float: right;position: absolute;right: 7.5%;top: 3%;" class="btn btn-close"  onclick="refresh_files('yes')"></button>
</div>
     <div class="d-flex align-items-center">
      <textarea  id="notes_grp" ondragover="allowDrop(event)"; ondrop="handleDrop(event)"; oninput="autoResizenote(this)" onpaste="autoResizenote(this, 'yes')" class="drag_files_ui form-control notes_input d-inline-flex flex-grow-1" placeholder="Type message" value=""></textarea>
      <i onclick="show_options()" id="open_the_gallery_area" class="bi bi-plus d-inline" style="font-size: 3rem; cursor: pointer;"></i>
      <i class="bi bi-telegram d-inline" style="font-size: 3rem; transform: rotate(13deg); color: #28a745; cursor:pointer;" onclick="notes()"></i>
     </div>
      <div class="drag_files" id="show_drag_files" style="display:none;min-width: 90.8%;max-width: 90.8%;">
          <div class="fs-5" id="title_of_docs">
              
       </div>
    </div>
  
      </div>
   <div>
       <input type="hidden" id="pointer_id_note" value="<?=$pointer_id_note?>">
       <input type="hidden" id="admin_id_note" value="<?=$admin_id?>">
       <input type="hidden" id="" value="">
   </div>
   
   
 <!--Modal -->
    <div class="modal fade" id="images_popup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header" style="height: 38px;margin-top: 10px;">
             <h5 class="text-center" id="title_upload_drag"></h5>
              <div id="loader" style="display: none;"  class="spinner-border text-success" role="status">
                     
                </div>
          </div>
          <div class="modal-body">
              
              <b id="extension_error" style="display:none;"></b>
               
            <div class="m-1">
             <form id="uploadForm" enctype="multipart/form-data">
             <input type="file" id="note_file" name="note_file[]" class="form-control form-control-lg" multiple >
              <input type="hidden" id="lastinsertedids" name="lastinsertedids[]" value=""class="form-control form-control-lg" >
             </form>
             <span style="color:rgb(227 53 69);" id="validation_docs"></span>
            </div>
          </div>
          <div class="modal-footer" style="padding-top: 3px;height: 50px;margin-bottom: 3px;">
            <button type="button"  class="btn btn_yellow_green" data-bs-dismiss="modal" onclick="refresh_files('yes');">Close</button>
            <button id="uploadButton" type="button" class="btn btn_yellow_green" onclick="notes('yes')">Upload</button>
          </div>
        </div>
      </div>
    </div>
</section>
<?php 
$base_url_note=base_url();
?>
<?php  }?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>

//for hide validation

//for scroll top the note module
  function scroll_bottom(){
    setTimeout(() => {
                
                $('#show_notes_all_data').animate({scrollTop: $('#show_notes_all_data')[0].scrollHeight}, 1000);    
            },200);    
  } 

    $(document).ready(function() {
        fetch_notes_all_data();
        scroll_bottom();
        if (innerWidth <= 1735 && innerWidth >= 1600) {
            $('.drag_files').width('1194px');
        }
    });  

   //Global Variables 
   const  pointer_id_note=$('#pointer_id_note').val();
   const  admin_id_note=$('#admin_id_note').val();
   var userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
   var base_url_note='<?= $base_url_note.'/' ; ?> ';
   var admin_name='<?= $admin_name?>';
   var for_update_msg="";
   var if_drag_files=false;
   var pointer_id_global=<?=$pointer_id_note;?>
   //console.log(base_url_note);
  
  //for show hide the actions buttons
  var for_hide_pupup_id=null;
  function showOptionsAction(paragraphNumber) {
    const popupId = 'popup' + paragraphNumber;
    for_hide_pupup_id=paragraphNumber;
    const popup = document.getElementById(popupId);
    if (popup.style.display === 'block') {
        popup.style.display = 'none'; 
    } else {
        document.querySelectorAll('.popup').forEach(otherPopup => otherPopup.style.display = 'none');

        popup.style.display = 'block'; 
    }
  
}

    function hideOptionsAction() {
        $(".popup").hide();
        // const popupId = 'popup' + paragraphNumber;
        // for_hide_pupup_id=paragraphNumber;
        // const popup = document.getElementById(popupId);
        // if (popup.style.display === 'block') {
        //     popup.style.display = 'none'; 
        // } else {
        //     document.querySelectorAll('.popup').forEach(otherPopup => otherPopup.style.display = 'none');
    
        //     popup.style.display = 'none'; 
        // }
      
    }

// function anywhere_click_on_note(){
//   console.log(for_hide_pupup_id);
//   var popup_anywhere='popup' + for_hide_pupup_id;
//   var popup_anywhere_hide=document.getElementById(popup_anywhere);
//   if (popup_anywhere_hide.style.display === 'block') {
//         popup_anywhere_hide.style.display = 'none'; 
//     }
   
// }

// function hide_show_openpopups(){
//   document.querySelectorAll('.popup').forEach(otherPopup => otherPopup.style.display = 'none');
//   //popup.style.display = 'block';  
// }
function autoResizenote(textarea, __isPaste = "") {
    var popup = document.getElementById('popup');
       // popup.style.display = (popup.style.display === 'none' || popup.style.display === '') ? 'block' : 'none';
        if( popup.style.display === 'block'){
           show_options(); 
        }
       
    $('#notes_grp').animate({scrollTop: $('#notes_grp')[0].scrollHeight}, 0);
    var chat_length = $("#notes_grp").val();
    chat_length = chat_length.length;
    if (textarea.scrollHeight != 40) {
        textarea.style.height = 'auto';
        if (textarea.scrollHeight >= 99) {
            textarea.style.height = '99px';
        } else if (textarea.scrollHeight <= 160) {
            textarea.style.height = (textarea.scrollHeight) + 'px';
        }
    } else {
        textarea.style.height = '40px';
    }
}

 
      
 function show_options() {
        var popup = document.getElementById('popup');
        popup.style.display = (popup.style.display === 'none' || popup.style.display === '') ? 'block' : 'none';
    }
    
    function close_options() {
        var popup = document.getElementById('popup');
        popup.style.display = (popup.style.display === 'none' || popup.style.display === '') ? 'none' : 'none';
    }
    
 function hide_options(files){
     if(files == 'images'){
         var text_title='Only:(jpg,png,jpeg,heic)';
         $('#title_upload_drag').text('Upload Image:');
         $('#validation_docs').text(text_title);
         
     }else{
         var text_title='Only:(docs,pdf,docx,xlsx)';
         $('#validation_docs').text(text_title);
         $('#title_upload_drag').text('Upload Document:');
     }
         var popup = document.getElementById('popup');
             popup.style.display = 'none';  
             select_type_files(files);
    }
    
 function select_type_files(files){
     if(files == 'images'){
        //$('#note_file').attr('accept', 'image/*');
         var allowedTypes = ["png","jpg","jpeg","heic"];
         $('#note_file').attr('accept', '.' + allowedTypes.join(', .'));
     }else{
         var allowedTypes = ["docs","pdf","docx","xlsx"];
         $('#note_file').attr('accept', '.' + allowedTypes.join(', .'));
       
     }
 }   
 
 
 // for Drag And Drop 
 function allowDrop(event) {
        event.preventDefault();
   }

 function handleDrop(event) {
    
    event.preventDefault();
        //for uploads only valid files
        var note_file = document.getElementById('note_file');
        var files = event.dataTransfer.files;
        var allowedTypes = ["jpeg", "png", "jpg","heic","docs","pdf","docx","xlsx"];
        var filteredFiles = Array.from(files).filter(function(file) {
            var fileType = file.name.split('.').pop().toLowerCase();
            return allowedTypes.includes(fileType);
        });
        var dataTransfer = new DataTransfer();
        filteredFiles.forEach(function(file) {
            dataTransfer.items.add(file);
            //console.log(file);
        });
       filteredFiles.sort(function(a, b) {
        return a.lastModified - b.lastModified;
    });
    var dataTransfer = new DataTransfer();
    filteredFiles.forEach(function(file) {
        dataTransfer.items.add(file);
    });

    note_file.files = dataTransfer.files;
        //console.log(dataTransfer.files.name);
       //for submit form and hide the input type file
      // var txt="";
      //if ($('#notes_grp').val() == '') {
        if_drag_files=true;
      // $('#progress_bar').width('0%');
       if (filteredFiles.length > 0) {
           $('#progress').css({'display': 'block'});
          $('#uploadButton').click();
        }else{
            custom_alert_popup_show(header = '', body_msg = "Please Select Valid Files", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'stage_1_pop_btn');
            return;
            
            //show_invalid_files_msg
        }
       
        
        $('#note_file').css('display', 'none');
        // }

        
   
}

function getFileExtension(filename) {
    return filename.split('.').pop();
}

function removeFile(button,id) {
   // console.log(button + id);
    var val_of_lastinsertedids = $('#lastinsertedids').val();
    var idsArray = val_of_lastinsertedids ? JSON.parse(val_of_lastinsertedids) : [];
    var indexToRemove = idsArray.indexOf(id);
    if (indexToRemove !== -1) {
        idsArray.splice(indexToRemove, 1);
    }
    $('#lastinsertedids').val(JSON.stringify(idsArray));
     $.ajax({
    method:"POST",
    url:"<?= base_url("admin/admin_functions/delete_notes_single") ?>",
    data:{id},
    success: function(response) {
        //console.log(response);
    if(response){
        $('#div_delete' + id).remove();
         updateFileInput();
    //   $(button).closest('div').remove();  
         
       
    }    
        
    },
     });
   
    
}

function updateFileInput() {
    var titleElement = $('#title_of_docs');
    var filesCount = titleElement.find('ol li').length;
    if (filesCount === 0) {
        $('#lastinsertedids').val('');
        $('#note_file').val('');
        // $('#images_popup').modal('hide');
        $('#note_file').css('display', 'block');
        $('#show_drag_files').hide();
         $('#older_list').each(function() {
            $(this).remove();
        });
        $('#notes_grp').css({
        'border-radius': '10px',
    });
    }
}

function refresh_files(hide=""){
     
    if(hide == 'yes'){
        if (ajaxRequest) {
        ajaxRequest.abort(); 
        ajaxRequest = null; 
        for_delete_all_trash_files();
        console.log("Upload cancelled.");
        $('#progress').css({'display': 'none'});
        $('#progress_bar').attr('aria-valuenow', 0);
        $('#progress_bar').width('0%');
        $('#progress_bar').text('0%');
        
    }
    $('#loader').css('display', 'none');
    $('#note_file').val('');
    $('#note_file').css('display', 'block');
    }else{
     $('#title_of_docs').html('');   
    }
      
    //('#note_file').show();
    
}    
 
 
 //For Insert The Notes messages/Files.
 var check_updated=true;
 var ajaxRequest;
  function notes(files ="") {
       //console.log(reply_docs_path);
    //   console.log("Mohsin Here");

      if(for_update_msg){
          
          for_update_message(for_update_msg);
          check_updated=false;
      }
      if(check_updated == false){
         return;
      }
      
     
      
        var note_file=$('#note_file').val();
        // Empty the input -> Mohsin
        // $('#note_file').val("");    
        if(note_file == '' && files == 'yes'){
          custom_alert_popup_show(header = '', body_msg = "Please select file.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false);
              return;  
        }
        
   // var files_yes='';
    var message = $("#notes_grp").val();
    // Empty the input -> Mohsin
        $('#notes_grp').val("");
    var form = document.getElementById('uploadForm');
    var formData = new FormData(form);
    var currentValue = $('#lastinsertedids').val();
    var fileSize=0;
   if ($('#note_file')[0].files.length > 0) {
    var fileNames = ""; 
    for (var i = 0; i < $('#note_file')[0].files.length; i++) {
        var fileSize = $('#note_file')[0].files[i].size;
        var fileName = $('#note_file')[0].files[i].name;
        var fileSizeInMB = fileSize / (1024 * 1024);
        fileNames += fileName + ", "; 
        //console.log("File Name:", fileName);
        if (fileSizeInMB > 20) {
            custom_alert_popup_show('', "File size cannot exceed 20MB.", 'Ok', 'btn-danger', false);
            return;
        }
    }
   // console.log("All File Names:", fileNames);
}
      
    
       //when msg and docs send paralelly
        if(if_drag_files == true){
             message="";
         }
         
        formData.append('userTimezone', userTimezone);
        formData.append('message', message);
        formData.append('pointer_id', pointer_id_note);
        formData.append('admin_id', admin_id_note);
        formData.append('docs_ids', currentValue);
        formData.append('reply_msg_note', reply_msg_update_note);
        formData.append('reply_user_name_note', reply_user_name_note);
        formData.append('reply_docs_files', reply_docs_files);
        formData.append('reply_docs_path', reply_docs_path);
        formData.append('reply_color_note', reply_color_note);
        formData.append('reply_id_note', reply_id_note);
        formData.append('reply_admin_id', reply_admin_id);
        formData.append('pointer_id', pointer_id_global);
        
        
        
        
         if(fileSize){
           $('#loader').show();  
         }
         
  ajaxRequest =  $.ajax({
        method: "POST",
        url: "<?= base_url("admin/admin_functions/notes") ?>",
        data: formData,
        processData: false,
        contentType: false,
           xhr: function() {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener('progress', function(e) {
            if (e.lengthComputable) {
                var percentComplete = Math.round((e.loaded / e.total) * 100);
                $('#progress_bar').width(percentComplete + '%');
                $('#progress_bar').text(percentComplete + '%');
                $('#progress_bar').attr('aria-valuenow', percentComplete);
            }
        }, false);
        return xhr;
    },
        success: function(response) {
            if(response) {
              // console.log('jafdbczvfchyvcfdc' + response);
                
                if(response.last_message_data != '' && response.last_message_data != null){
                 deleteDiv_note();
                 reply_msg_update_note = '';
                 reply_user_name_note = '';
                 reply_docs_files = '';
                 reply_color_note = '';
                 reply_id_note = '';
                 reply_docs_path = ''; 
                 reply_admin_id = '';
                //  last_msg__id_note=response.last_message_data.id;
                 //call function when response come
                // fetchData_last_note();
                
                }
               if (response.last_docs_data != '' && response.last_docs_data != null) {
                 deleteDiv_note();
                 reply_msg_update_note = '';
                 reply_user_name_note = '';
                 reply_docs_files = '';
                 reply_color_note = '';
                 reply_id_note = '';
                 reply_docs_path = ''; 
                 reply_admin_id = '';
                 processRecords(response);} 
               
        if(message || response.last_docs_data){
            $('#lastinsertedids').val('');
            $('#title_of_docs').html('');
              $('#notes_grp').css({
                'border-radius': '10px',
                 'height':'60px',
            });
            }else{
                //console.log('i am here when files select');
                
                Show_ondrags_files(response.data);
                var lastInsertedIds = response.lastInsertedIds;
              
                try {
                    var currentArray = currentValue ? JSON.parse(currentValue) : [];
                    var updatedArray = currentArray.concat(lastInsertedIds);
                    $('#lastinsertedids').val(JSON.stringify(updatedArray));
                      console.log(updatedArray);
                } catch (error) {
                    console.error('Error occurred while processing the current value:', error);
                }
                 
            }
                $('#images_popup').modal('hide');
                //console.log(JSON.stringify(response.last_docs_data) + JSON.stringify(response.last_message_data));
                if(response.last_docs_data !== "" && response.last_docs_data != null || response.last_message_data !== "" && response.last_message_data != null){
                    $("#notes_grp").val(""); 
                }
                
                $('#note_file').val('');
                $('#note_file').css('display','block'); 
                
            }
            
               $('#loader').hide();
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
        
    });
    return false;
}
  
 //For After Enter Send Message. 
   var enter_note = document.getElementById('notes_grp');
    enter_note.addEventListener('keydown', function(event) {
    if (event.keyCode === 13) { 
        event.preventDefault(); 
        notes();
    }
});


function Show_ondrags_files(response){
     
    var html = ' <ol id="older_list"> <div class="row" style="margin-left: -26px;margin-right: 6px;" id="child_docs">  ';
    var count=0;
    var html_child='';
    
     response.forEach(function(response_data) {
        count++;
          var doc_name_limit;
         if(innerWidth <= 1920 && innerWidth >= 1800){
             var doc_name_limit = response_data.documents.length > 36 ? response_data.documents.substring(0,36) + '...' : response_data.documents;
         }else if(innerWidth <= 1800 && innerWidth >= 1600){
             var doc_name_limit =response_data.documents.length > 30 ? response_data.documents.substring(0,30) + '...' : response_data.documents;
         }else if(innerWidth <= 1600 && innerWidth >= 1450){
             var doc_name_limit =response_data.documents.length > 25 ? response_data.documents.substring(0,25) + '...' : response_data.documents;
         }
         else{
            var doc_name_limit =response_data.documents.length > 20 ? response_data.documents.substring(0,20) + '...' : response_data.documents; 
         }
         var fileExtension = getFileExtension(response_data.documents);
            html += `<div class="col-3" id="div_delete${response_data.id}"   data-toggle="tooltip" data-placement="top" title="${response_data.documents}" style="padding:0px;border-radius:8px;margin-top:-4px;">
                     <li class="border border-1 border-secondary files_box" style="cursor:pointer;font-size: 15px;font-weight:bold;padding-top:5px;border-radius: 5px;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                      ${doc_name_limit}
                     <button id="btn_remove${response_data.id}" value="${response_data.id}" style="display:inline-block;float: right;font-size: 12px;margin-top: 1px;" class="btn-close btn-sm" onclick="removeFile(this,${response_data.id})"></button></li></div>`;

          html_child += `<div id="div_delete${response_data.id}" class="col-3"  data-toggle="tooltip" data-placement="top" title="${response_data.documents}" style="padding:0px;border-radius:8px;margin-top:-4px;">
                     <li class="border border-1 border-secondary files_box" style="cursor:pointer;font-size: 15px;font-weight:bold;padding-top:5px;border-radius: 5px;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                      ${doc_name_limit}
                     <button id="btn_remove${response_data.id}" value="${response_data.id}" style="display:inline-block;float: right;font-size: 12px;margin-top: 1px;" class="btn-close btn-sm" onclick="removeFile(this,${response_data.id})"></button></li></div>`;
         
     });
  html += '</div></ol>';

  $('#progress').css({'display': 'none'});
  $('#progress_bar').attr('aria-valuenow', 0);
  $('#progress_bar').width('0%');
  $('#progress_bar').text('0%');

  $('#show_drag_files').show();
  var currentValue_of_input = $('#lastinsertedids').val();
   //console.log('value -->' + currentValue_of_input);
   if(currentValue_of_input != ''){
       $('#child_docs').append(html_child);
   }else{
       $('#title_of_docs').append(html);
   }
  
     $('#notes_grp').css({
        'border-bottom-width': '0',
        'border-bottom-left-radius': '0px',
        'border-bottom-right-radius': '0px'
    });
    if_drag_files=false;
    console.log(if_drag_files);
    // $('#showhidereply_note').css({'display':'block'});
}
//scroll use for fetch data------------------   
$('#show_notes_all_data').on('scroll', function () {
            if ($(this).scrollTop() < 10) {
               
                setTimeout(() => {  
                    //console.log('World!'); 
                 fetch_notes_all_data("no_store_last_id");
                    
                }, 200);
            }
        });
        
function formatTimestamp_note(timestamp) {
    var date = new Date(timestamp);
    var options = {
        weekday: 'short',
        month: 'short',
        day: 'numeric',
        hour: 'numeric',
        minute: '2-digit',
        hour12: true
    };
    var formattedDate = date.toLocaleString('en-US', options);
    return formattedDate;
}

//fetch_for_all_data
var record_fetch_note = 10;  
var offset_record_note = 0;
var prevoius_offset_record_note = -1;
var last_msg__id_note = "";
var  check_fetch_run_note = "yes";
 async function fetch_notes_all_data(no_store_last_id = "" ) {
    //  console.log("Here Mohsin");
     if(prevoius_offset_record_note == offset_record_note){
            return;
        }
        prevoius_offset_record_note = offset_record_note;
    try {
       // console.log('offset' + offset_record_note + 'record' + record_fetch_note);
        const response = await $.ajax({
            url: "<?= base_url("admin/admin_functions/fetch_notes") ?>",
            method: 'POST',
            data: {userTimezone,
            record_fetch_note,
            offset_record_note,
            pointer_id_global
            },
        });
            offset_record_note += record_fetch_note;
           // console.log(offset_record_note);
           First_record_note=0;
         response.forEach(function(response_note) {
            if (response_note) {
                //console.log(response_note);
                
                if(First_record_note == 0){
                    if(no_store_last_id == ''){
                       last_msg__id_note =response_note.id; 
                    }
                    
                }
                var show_action_permission="";
                    if(admin_id_note == 1){
                    show_action_permission=`<p class="cursor_" style="line-height: 5px;" onclick="for_delete_message(${response_note.id})">Delete</p>`;
                    }
                    var for_edit_self=""
                    if(admin_id_note == response_note.admin_id){
                        if(response_note.is_send_doc_request == null){
                            for_edit_self=`<p class="cursor_" style="line-height: 5px;" onclick="makeEditable(${response_note.id})" >Edit</p>`;
                        }
                    }
                //console.log("last_id --- >" ,last_msg__id_note);
                         var Popup="";
            
                
                        var username_note='';
                        var username_note_reply='';
                        if(admin_id_note == response_note.admin_id && response_note.is_send_doc_request != null){
                          username_note='You';
                        }else{
                          username_note=response_note.user_name;
                        }
                       // console.log(admin_id_note   + "<----> " + response_note.reply_admin_id )
                        if(admin_id_note == response_note.reply_admin_id && response_note.is_send_doc_request != null){
                             username_note_reply='You';
                        }else{
                             username_note_reply=response_note.reply_user_name;
                        }
                //console.log(username_note  + admin_id_note);
                
                    if(response_note.message != ''){
                        
                        
                    popup=`  margin-right: 3px;right: 0;bottom: 1px;`;
                    var Edited="";
                    if(response_note.old_message){
                        Edited='Edited';
                    }
                        
                        
                         //console.log(username_note_reply + "--->" + admin_name   + "--->" + admin_id_note);
                    if(response_note.isdeleted != 1){
                      
                        if(response_note.reply_id != '' && response_note.reply_msg != '' || response_note.reply_documents != ''){
                        
                        
                        if(response_note.reply_msg != ''){
                        truncatedMessage_note = response_note.reply_msg.length > 210 ? response_note.reply_msg.substring(0,210) + '...' : response_note.reply_msg;
                        response_note.message =  response_note.message.replace(/(https?:\/\/\S+)/g, '<a href="$1" target="_blank">$1</a>');
                        var show_fetch_data=`
                        <span id="span_${response_note.id}" class="d-block" style="font-size: 11px; padding-left:14px;">
                        &nbsp<b style="font-size:13px;color:${response_note.color};margin-right: 6px;">${username_note}</b>
                          ${ (formatTimestamp_note(response_note.created_at)) } <span id="edited_${response_note.id}"></span></span>
                          <div class="p-1">
                          <div id="text_area${response_note.id}" class="text_area" style="margin-top: -8px;">
                         <p onclick="goto_up_note('text_area'+ ${response_note.reply_id})"  style="cursor:pointer;position: relative;border-left: 4px solid ${response_note.reply_color};border-radius: 12px;background: #1d0b0b3b;padding: 7px;"> <b style="color:${response_note.reply_color};font-size: 13px;">${username_note_reply}</b> <br> ${truncatedMessage_note}
                        </p>
                        
                         <p style="position: relative;margin-top: -15px; margin-left: 8px;margin-bottom: 9px;" id="note_paragraph${response_note.id}">
                            ${response_note.message}
                         </p>
                         <i id="icon${response_note.id}" style="float:right;position: relative; z-index: 2;margin-top: -33px;" class="bi bi-three-dots-vertical cursor_ three_dots_action_btn" onclick="showOptionsAction(${response_note.id})"></i>
                        <div class="popup" style="margin-right: 3px; right: 0px; bottom: 1px; display: none;" id="popup${response_note.id}">
                                  ${for_edit_self}
                          <p onclick="reply_msg_note(${response_note.id})" class="cursor_" style="line-height: 5px;">Reply</p>
                           ${show_action_permission}
                        </div>
                        </div>
                      </div>`; 
                        } 
                      else if(response_note.reply_documents != ''  ){
                          
                         var file_docs_name_reply = getFileExtension(response_note.reply_documents);
                         var doc_name_show_reply = response_note.reply_documents.length > 70 ? response_note.reply_documents.substring(0,70) + '...' : response_note.reply_documents;
                         response_note.message =  response_note.message.replace(/(https?:\/\/\S+)/g, '<a href="$1" target="_blank">$1</a>');
                         
                         var show_fetch_data=`
                        <span id="span_${response_note.id}" class="d-block" style="font-size: 11px; padding-left:14px;">
                        &nbsp<b style="font-size:13px;color:${response_note.color};margin-right: 6px;">${username_note}</b>
                          ${ (formatTimestamp_note(response_note.created_at)) } <span id="edited_${response_note.id}"></span></span>
                          <div class="p-1" >
                          <div  id="text_area${response_note.id}" style="min-width:200px;" class="text_area_reply_docs ">
                         <div onclick="goto_up_note_docs('docs_reply'+ ${response_note.reply_id})"  style="cursor:pointer;position: relative;border-left: 4px solid ${response_note.reply_color};border-radius: 12px;background: #1d0b0b3b;">
                         <b style="color:${response_note.reply_color};font-size: 13px;padding-left: 7px;">${username_note_reply}</b> <br> 
                         
                          <span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon(file_docs_name_reply)}</span>
                        <p  class="d-inline font-weight-bold mr-3" style="width: auto; margin-top: 9px; margin-left: 6px; overflow: hidden; text-overflow: ellipsis;padding-right: 5px;">${doc_name_show_reply}</p>
                        </div>
                      <div class="d-flex align-items-center" style="margin-top: 1px;margin-left: 1px;overflow: hidden;padding: 0px 0px 3px 5px;">
                        <p id="note_paragraph${response_note.id}" > ${response_note.message} &nbsp;&nbsp;</p>
                    </div>
                         <i id="icon${response_note.id}" style="float:right;position: relative; z-index: 2;margin-top: -33px;" class="bi bi-three-dots-vertical cursor_ three_dots_action_btn" onclick="showOptionsAction(${response_note.id})"></i>
                        <div class="popup" style="right: -86px;top: 30px;"  id="popup${response_note.id}">
                                  ${for_edit_self}
                          <p onclick="reply_msg_note(${response_note.id})" class="cursor_" style="line-height: 5px;">Reply</p>
                           ${show_action_permission}
                        </div>
                        
                      </div>`;  
                          
                      }
                      
                      
                        } 
                    else{
                     //  console.log('i am here..............................');
                            //      return;
                        //         var show_fetch_data = `
                        //     <span id="span_${response_note.id}" class="d-block" style="font-size: 11px; padding-left:14px; margin-bottom: -10px;">
                        //         &nbsp<b style="font-size:13px;color:${response_note.color};margin-right: 6px;">${username_note}</b>
                        //     ${(formatTimestamp_note(response_note.created_at)) }  <span id="edited_${response_note.id}">${Edited}</span>
                        //     </span>
                        //     <div class="p-1">
                        //         <div id="text_area${response_note.id}" class="text_area">
                        //             <p style="position: relative;padding-left: 8px" id="note_paragraph${response_note.id}">${response_note.message}</p> 
                        //             <i id="icon${response_note.id}" style="float:right;position: relative; z-index: 2;margin-top: -33px;" class="bi bi-three-dots-vertical cursor_" onclick="showOptionsAction(${response_note.id})"></i>
                        //             <div class="popup" style="${popup}" id="popup${response_note.id}">
                        //                  ${for_edit_self}
                        //             <p  onclick="reply_msg_note(${response_note.id})"   class="cursor_" style="line-height: 5px;">Reply</p>
                        //                  ${show_action_permission}
                        //             </div>
                        //         </div>
                        //     </div>
                        // `; 
                
                       if(response_note.message != "" && response_note.documents != "" ){
                             var path=base_url_note.trim() + response_note.documents_path;
                             //console.log(response_note.documents_path);
                             var file_docs_name = getFileExtension(response_note.documents);
                              show_flag='';
                             if(response_note.is_send_doc_request == 'upload'){
                                 show_flag=`<img style="width:11px;margin-left: 7px;" src="${base_url_note.trim() + '/public/assets/icon/flag-green.png'}">`;
                                 username_note = response_note.user_name;
                                 for_edit_self='';
                             }
                             //console.log(show_flag);
                            //  console.log('when message with docs/files then code stop here');
                         //var file_docs_name_reply = getFileExtension(lastItem_notes.documents);
                         response_note.message =  response_note.message.replace(/(https?:\/\/\S+)/g, '<a href="$1" target="_blank">$1</a>');
                         var show_fetch_data=`
                        <span id="span_${response_note.id}" class="d-block" style="font-size: 11px; padding-left:14px;">
                        &nbsp<b style="font-size:13px;color:${response_note.color};margin-right: 6px;">${username_note}</b>
                          ${ (formatTimestamp_note(response_note.created_at)) } <span id="edited_${response_note.id}"></span>${show_flag}</span>
                          <div class="p-1" id="text_area_parent${response_note.id}" style="margin-top:-5px">
                          <div  id="text_area${response_note.id}" class="text_area_reply_docs w-auto" style="min-width: 14%;">
                         <div   style="    cursor: pointer; position: relative;border-radius: 9px;background: #1d0b0b3b; height: 53px;    display: flex;
    align-items: center;
    padding-left: 9px;">
                          <span class="d-inline" style="font-size: 28px; margin-top: -3px; margin-right: 7px;">${check_icon(file_docs_name)}</span>
                          
                       <p data-toggle="tooltip" data-placement="top" title="${response_note.documents}" class="d-inline font-weight-bold mr-3" style="width: auto; margin-top: 9px;  overflow: hidden; text-overflow: ellipsis; padding-right: 5px;">
                        <a href="${path}" target="_blank">${response_note.documents}</a>
                    </p>

                          
                        </div>
                      <div class="d-flex align-items-center" style="margin-top: 1px;margin-left: 1px;overflow: hidden;padding: 0px 3px 3px 5px;">
                    <div id="note_paragraph${response_note.id}" style="padding: 4px;" > ${response_note.message} &nbsp;&nbsp;</div>
                    </div>
                           <i id="icon${response_note.id}" style="float:right;position: relative; z-index: 2;margin-top: -27px;" class="bi bi-three-dots-vertical cursor_ three_dots_action_btn" onclick="showOptionsAction(${response_note.id})"></i>
                        <div class="popup" style="right: -112px;top: 2px;"  id="popup${response_note.id}">
                                  ${for_edit_self}
                          <p onclick="reply_msg_note(${response_note.id})" class="cursor_" style="line-height: 5px;">Reply</p>
                           ${show_action_permission}
                             <p data-toggle="tooltip" data-placement="top" title="${response_note.documents}" class="cursor_" style="line-height: 5px;"><a class="text-dark" style="text-decoration:none;" href="${path}" download="${response_note.documents}">Download</a></p>
                        </div>
                        
                      </div>`; 
                      
                            //END THE CODE OF MSG WITH DOCS 
                         }else{
                             show_flag='';
                             if(response_note.is_send_doc_request == 'send'){
                                 show_flag=`<img style="width:11px;margin-left: 7px;" src="${base_url_note.trim() + '/public/assets/icon/flag-red.png'}">`;
                             }
                            
                            response_note.message =  response_note.message.replace(/(https?:\/\/\S+)/g, '<a href="$1" target="_blank">$1</a>'); 
                            
                           var show_fetch_data = `
                    <span id="span_${response_note.id}" class="d-block" style="font-size: 11px; padding-left:14px; margin-bottom: -10px;">
                        &nbsp<b style="font-size:13px;color:${response_note.color};margin-right: 6px;">${username_note}</b>
                    ${ (formatTimestamp_note(response_note.created_at)) } <span id="edited_${response_note.id}"></span>
                    ${show_flag}
                    </span>
                        <div class="p-1">
                        <div id="text_area${response_note.id}" class="text_area">
                            <div style="position: relative;padding: 5px 10px" id="note_paragraph${response_note.id}">${response_note.message}</div> 
                            <i id="icon${response_note.id}" style="float:right;position: relative; z-index: 2;margin-top: -33px;" class="bi bi-three-dots-vertical cursor_ three_dots_action_btn" onclick="showOptionsAction(${response_note.id})"></i>
                            <div class="popup" style="margin-right: 3px;right: 0;bottom: -45px;" id="popup${response_note.id}">
                                  ${for_edit_self}
                            <p  onclick="reply_msg_note(${response_note.id})"   class="cursor_" style="line-height: 5px;">Reply</p>
                                 ${show_action_permission}
                            </div>
                        </div>
                    </div>
                `;
                         }
                
                       }
                       
                    }else{
                        show_fetch_data=`
                        <span id="span_${response_note.id}" class="d-block" style="font-size: 11px; padding-left: 14px; margin-bottom: -10px; margin-left: 5px;">${(formatTimestamp_note(response_note.deleted_at)) }</span>
                        <div class="p-1">
                        <div id="text_area${response_note.id}" class="text_area" style="width: 27%;">
                            <p style="position: relative; font-style: italic;color:#706666;margin-bottom: 8px;margin-top: 3px;" id="note_paragraph${response_note.id}">This Message Is Deleted By Superadmin</p> 
                            </div>
                        </div>
                    </div>`;
                    }
                }else{
                    
                    
                    //console.log('files/docs --->' + response_note.id);
                        var file_docs_name = getFileExtension(response_note.documents);
                        var path = base_url_note.trim() + response_note.documents_path.trim();
                        // console.log(response_note);
                        
                        //check data when reply message is empty.
                        if(response_note.reply_id == 0 && response_note.reply_documents == '' ){
                            
                        // var path_redirect;
                        // console.log(path);
                        // if (file_docs_name === 'xls' || file_docs_name === 'xlsx' || file_docs_name === 'xlsm' || file_docs_name === 'xlsb' || file_docs_name === 'xltx' || file_docs_name === 'xltm') {
                        //     path_redirect = 'ms-excel:ofe|u|' + path;
                        // } else if (file_docs_name === 'doc' || file_docs_name === 'docx' || file_docs_name === 'docm') {
                        //     path_redirect = 'ms-word:ofe|u|' + path;
                        // } else {
                        //     path_redirect = path;
                        // }
                        
                      if(response_note.documents.endsWith('.png') || response_note.documents.endsWith('.jpg') || response_note.documents.endsWith('.jpeg') || response_note.documents.endsWith('.heic')){
                     popup=` right: -113px;top: 8px;padding: 11px 4px 1px 8px;`;
                    if(response_note.isdeleted != 1){
                     var show_fetch_data = `
                    <span id="span_${response_note.id}" class="d-block" style="font-size: 11px; padding-left:14px; margin-bottom: -10px;">
                        &nbsp<b style="font-size:13px;color:${response_note.color};margin-right: 6px;">${username_note}</b>
                    ${(formatTimestamp_note(response_note.created_at))}
                    </span>
                    <div class="docs_files${response_note.id}">
                     <div id="text_area${response_note.id}"  class="p-1" style="width: 200px;position:relative;">
                        <div id="docs_reply${response_note.id}"   class="text_area" style="border:2px solid #c8c8c8; width: auto;height: auto;padding: 0px;position:ralative;">
                        <a data-toggle="tooltip" data-placement="top" title="${response_note.documents}" href="${path}"  target="_blank" >
                        <img src="${path}" width="191px" height="145px" style="border: 1px solid #c8c8c8;border-radius: 10px;"></a>
                        <i id="icon${response_note.id}" style="float: right;position: absolute;z-index: 2;top: -3px; right: -22px;font-size: 26px;color: #8d8a8a;" class="bi bi-three-dots-vertical cursor_ three_dots_action_btn" onclick="showOptionsAction(${response_note.id})"></i>
                        </div>
                     <div>
                        </div>
                          <div class="popup" style="${popup}" id="popup${response_note.id}">
                                 <p  onclick="reply_msg_note(${response_note.id})"   class="cursor_" style="line-height: 5px;">Reply</p>
                                  ${show_action_permission}
                                 <p data-toggle="tooltip" data-placement="top" title="${response_note.documents}" class="cursor_" style="line-height: 5px;"><a class="text-dark" style="text-decoration:none;" href="${path}" download="${response_note.documents}">Download</a></p>
                            </div>
                    </div> 
                    </div> 
                `;
                    }else{
                        show_fetch_data=`
                        <span id="span_${response_note.id}" class="d-block" style="font-size: 11px; padding-left: 14px; margin-bottom: -10px; margin-left: 5px;">${(formatTimestamp_note(response_note.deleted_at)) }</span>
                        <div class="p-1">
                        <div id="text_area${response_note.id}" class="text_area" style="width: 27%;">
                            <p style="position: relative; font-style: italic;color:#706666;margin-bottom: 8px;margin-top: 3px;" id="note_paragraph${response_note.id}">This Message Is Deleted By Superadmin</p> 
                            </div>
                        </div>
                    </div>`;
                    }
                }else{
                    if(response_note.isdeleted != 1){
                     popup=`right: -58px; top: -7px;padding: 11px 3px 0px 8px;`;
                    var doc_name_show = response_note.documents.length > 70 ? response_note.documents.substring(0,70) + '...' : response_note.documents;
                    
                    console.log(check_icon(file_docs_name));
                   var show_fetch_data = `
                    <span id="span_${response_note.id}" class="d-block" style="font-size: 11px; padding-left:14px; margin-bottom: -10px;">
                        &nbsp<b style="font-size:13px;color:${response_note.color};margin-right: 6px;">${username_note}</b>
                    ${ (formatTimestamp_note(response_note.created_at)) }
                    </span>
                     <div class="docs_files${response_note.id}">
                   <div id="text_area${response_note.id}"  class="col-3 m-2 ms-3 d-flex position-relative" >
                    <div id="docs_reply${response_note.id}" class="d-flex align-items-center" style="border: 2px solid #c8c8c8;border-radius: 10px; padding-left: 6px;padding-top: 5px; width: 91%;">
                        <span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon(file_docs_name)}</span>
                        <p data-toggle="tooltip" data-placement="top" title="${response_note.documents}"  class="d-inline font-weight-bold mr-3" style="width: auto; margin-top: 9px; margin-left: 6px; overflow: hidden; text-overflow: ellipsis;padding-right: 5px;"><a href="${path}" target="_blank">${doc_name_show}</a></p>
                    </div>
                 <i id="icon${response_note.id}" style="float: right;position: relative;z-index: 2;right: 17px;top: 3px;color: #8d8a8a;" class="bi bi-three-dots-vertical cursor_ three_dots_action_btn" onclick="showOptionsAction(${response_note.id})"></i>
                      <div class="popup" style="${popup}"  id="popup${response_note.id}">
                       <p onclick="reply_msg_note(${response_note.id})"   class="cursor_" style="line-height: 5px;">Reply</p>
                                  ${show_action_permission}
                                 <p data-toggle="tooltip" data-placement="top" title="${response_note.documents}" class="cursor_" style="line-height: 5px;"><a class="text-dark" style="text-decoration:none;" href="${path}" download="${response_note.documents}">Download</a></p>
                            </div>
                </div>
                 </div>
                
                `; 
                    }else{
                        show_fetch_data=`
                        <span id="span_${response_note.id}" class="d-block" style="font-size: 11px; padding-left: 14px; margin-bottom: -10px; margin-left: 5px;">${(formatTimestamp_note(response_note.deleted_at)) }</span>
                        <div class="p-1">
                        <div id="text_area${response_note.id}" class="text_area" style="width: 27%;">
                            <p style="position: relative; font-style: italic;color:#706666;margin-bottom: 8px;margin-top: 3px;" id="note_paragraph${response_note.id}">This Message Is Deleted By Superadmin</p> 
                            </div>
                        </div>
                    </div>`;
                    }
                    
                } 
                
                
                }else{
                    
                    popup=`right: -104px;top: -19px;padding: 11px 3px 0px 8px;`;
                    if(response_note.isdeleted != 1){
                   if(response_note.reply_msg != ''){
                      // console.log(response_note.id);
                        truncatedMessage_note = response_note.reply_msg.length > 30 ? response_note.reply_msg.substring(0,30) + '...' : response_note.reply_msg;
                      
                      if(response_note.documents.endsWith('.png') || response_note.documents.endsWith('.jpg') || response_note.documents.endsWith('.jpeg') || response_note.documents.endsWith('.heic')){
                      
                        var show_fetch_data=`
                        <span id="span_${response_note.id}" class="d-block" style="font-size: 11px; padding-left:14px;">
                        &nbsp<b style="font-size:13px;color:${response_note.color};margin-right: 6px;">${username_note}</b>
                          ${ (formatTimestamp_note(response_note.created_at)) } <span id="edited_${response_note.id}"></span></span>
                          <div class="p-1" id="text_area_parent${response_note.id}">
                          <div  class="text_area" style="width:13.8% !important;margin-top: -6px;min-width:202px;">
                         <p onclick="goto_up_note('text_area'+ ${response_note.reply_id})"  style="cursor:pointer;position: relative;border-left: 4px solid ${response_note.reply_color};border-radius: 12px;background: #1d0b0b3b;padding: 7px;"> <b style="color:${response_note.reply_color};font-size: 13px;">${username_note_reply}</b> <br> ${truncatedMessage_note}
                        </p>
                           <div class="docs_files${response_note.id}">
                      <div id="text_area${response_note.id}"  class="p-1" style="width: 200px;position:relative;">
                        <div id="docs_reply${response_note.id}"class="text_area" style="border: 2px solid #c8c8c8;width: auto;height: auto;padding: 0px;position: ralative;margin: 0px;margin-top: -18px;margin-left: -2px;">
                        <a data-toggle="tooltip" data-placement="top" title="${response_note.documents}" href="${path}"  target="_blank" >
                        <img src="${path}" width="191px" height="145px" style="border: 1px solid #c8c8c8;border-radius: 10px;"></a>
                        <i id="icon${response_note.id}" style="float: right;position: absolute;z-index: 2;top: -3px; right: -26px;font-size: 26px;color: #8d8a8a;" class="bi bi-three-dots-vertical cursor_ three_dots_action_btn" onclick="showOptionsAction(${response_note.id})"></i>
                        </div>
                     <div>
                        </div>
                          <div class="popup_reply_image popup" style="${popup}" id="popup${response_note.id}" rohit>
                                 <p  onclick="reply_msg_note(${response_note.id})"   class="cursor_" style="line-height: 5px;">Reply</p>
                                  ${show_action_permission}
                                 <p data-toggle="tooltip" data-placement="top" title="${response_note.documents}" class="cursor_" style="line-height: 5px;"><a class="text-dark" style="text-decoration:none;" href="${path}" download="${response_note.documents}">Download</a></p>
                            </div>
                    </div> 
                    </div> 
                             
                        </div>
                      </div>`; 
                      }else{
                           var truncatedMessage_note = response_note.reply_msg.length > 43 ? response_note.reply_msg.substring(0,43) + '...' : response_note.reply_msg;
                           var doc_name_show = response_note.documents.length > 30 ? response_note.documents.substring(0,30) + '...' : response_note.documents;
                      var show_fetch_data=`
                        <span id="span_${response_note.id}" class="d-block" style="font-size: 11px; padding-left:14px;">
                        &nbsp<b style="font-size:13px;color:${response_note.color};margin-right: 6px;">${username_note}</b>
                          ${ (formatTimestamp_note(response_note.created_at)) } <span id="edited_${response_note.id}"></span></span>
                          <div class="p-1" id="text_area_parent_${response_note.id}">
                          <div id="text_area${response_note.id}"   class="text_area" style="width: 22.8% !important;margin-top: -6px;" rohit>
                          <p onclick="goto_up_note('text_area'+ ${response_note.reply_id})" style="cursor:pointer;position: relative;border-left: 4px solid ${response_note.reply_color};border-radius: 12px;background: #1d0b0b3b;padding: 7px;"> <b style="color:${response_note.reply_color};font-size: 13px;">${username_note_reply}</b> <br> ${truncatedMessage_note}
                         </p>
                 <div class="docs_files${response_note.id}" style="margin-top: -13px;width: 100% ">
                <div id="text_area${response_note.id}" class=" d-flex position-relative" style="width: 105%;margin-left: 0px;margin-bottom: 3px;">
                    <div id="docs_reply${response_note.id}" class="d-flex align-items-center" style="border: 2px solid #c8c8c8;border-radius: 10px;padding-left: 6px;padding-top: 5px;/* width: 75%; *//* max-width: 80%; */width: 100%;">
                        <span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon(file_docs_name)}</span>
                        <p data-toggle="tooltip" data-placement="top" title="${response_note.documents}" class="d-inline font-weight-bold mr-3" style="width: auto; margin-top: 9px; margin-left: 6px; overflow: hidden; text-overflow: ellipsis;padding-right: 5px;">
                        <a href="${path}" target="_blank">${doc_name_show}</a></p>
                    </div>
                 <i id="icon${response_note.id}" style="float: right;position: relative;z-index: 2;right: 17px;top: 3px;color: #8d8a8a;" class="bi bi-three-dots-vertical cursor_ three_dots_action_btn" onclick="showOptionsAction(${response_note.id})"></i>
                      <div class="popup" style="right: -77px;top: -11px;padding: 11px 3px 0px 8px;" id="popup${response_note.id}">
                      <p onclick="reply_msg_note(${response_note.id})" class="cursor_" style="line-height: 5px;">Reply</p>
                                ${show_action_permission}
                     <p data-toggle="tooltip" data-placement="top" title="${response_note.documents}" class="cursor_" style="line-height: 5px;"><a class="text-dark" style="text-decoration:none;" href="${path}" download="${response_note.documents}">Download</a></p>
                            </div>
                         </div>
                          </div> 
                      </div></div> 
                      
                      
                      `;    
                
                      }
                      
                      
                        } 
                      else if(response_note.reply_documents != ''  ){
                          
                         popup = `right: -153px;top: -10px;padding: 11px 4px 1px 8px;`;
                         var file_docs_name_reply = getFileExtension(response_note.reply_documents);
                         var doc_name_show_reply = response_note.reply_documents.length > 20 ? response_note.reply_documents.substring(0,20) + '...' : response_note.reply_documents;
                         
                         
                         //else for reply image to image when docs insert.
                         if(response_note.documents.endsWith('.png') || response_note.documents.endsWith('.jpg') || response_note.documents.endsWith('.jpeg') || response_note.documents.endsWith('.heic')){ 
                         var show_fetch_data=`
                        <span id="span_${response_note.id}" class="d-block" style="font-size: 11px; padding-left:14px;">
                        &nbsp<b style="font-size:13px;color:${response_note.color};margin-right: 6px;">${username_note}</b>
                          ${ (formatTimestamp_note(response_note.created_at)) } <span id="edited_${response_note.id}"></span></span>
                          <div class="p-1">
                          <div  id="text_area${response_note.id}" class="text_area_reply_docs" style="width:17%;margin-top: -7px;">
                         <div onclick="goto_up_note_docs('docs_reply'+ ${response_note.reply_id})"  style="cursor:pointer;position: relative;border-left: 4px solid ${response_note.reply_color};border-radius: 12px;background: #1d0b0b3b;">
                         <b style="color:${response_note.reply_color};font-size: 13px;padding-left: 7px;">${username_note_reply}</b> <br> 
                         
                          <span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon(file_docs_name_reply)}</span>
                        <p  class="d-inline font-weight-bold mr-3" style="width: auto; margin-top: 9px; margin-left: 6px; overflow: hidden; text-overflow: ellipsis;padding-right: 5px;">${doc_name_show_reply}</p>
                        
                         
                        </div>
                        <div class="docs_files${response_note.id}">
                      <div id="text_area${response_note.id}"  class="p-1" style="width: 200px;position:relative;">
                        <div id="docs_reply${response_note.id}"class="text_area" style="border: 2px solid #c8c8c8;width: auto;height: auto;padding: 0px;position: ralative;margin: 0px;margin-left: -2px;">
                        <a data-toggle="tooltip" data-placement="top" title="${response_note.documents}" href="${path}"  target="_blank" >
                        <img src="${path}" width="242px" height="145px" style="border: 1px solid #c8c8c8;border-radius: 10px;"></a>
                       
                        </div>
                     <div>
                        </div>
                         <i id="icon${response_note.id}" style="float: right;position: absolute;z-index: 2;top: -3px; right: -69px;font-size: 26px;color: #8d8a8a;" class="bi bi-three-dots-vertical cursor_ three_dots_action_btn" onclick="showOptionsAction(${response_note.id})"></i>
                          <div class="popup_reply_image popup" style="${popup}" id="popup${response_note.id}" rohit>
                                 <p  onclick="reply_msg_note(${response_note.id})"   class="cursor_" style="line-height: 5px;">Reply</p>
                                  ${show_action_permission}
                                 <p data-toggle="tooltip" data-placement="top" title="${response_note.documents}" class="cursor_" style="line-height: 5px;"><a class="text-dark" style="text-decoration:none;" href="${path}" download="${response_note.documents}">Download</a></p>
                            </div>
                    </div> 
                    </div> 
                       
                        
                      </div>`;  
                      //else for reply documents
                      }else{
                          
                          
                          var doc_name_show = response_note.documents.length > 50 ? response_note.documents.substring(0,50) + '...' : response_note.documents;
                         var doc_name_show_reply = response_note.reply_documents.length > 35 ? response_note.reply_documents.substring(0,35) + '...' : response_note.reply_documents;

                         var show_fetch_data=`
                        <span id="span_${response_note.id}" class="d-block" style="font-size: 11px; padding-left:14px;">
                        &nbsp<b style="font-size:13px;color:${response_note.color};margin-right: 6px;">${username_note}</b>
                          ${ (formatTimestamp_note(response_note.created_at)) } <span id="edited_${response_note.id}"></span></span>
                          <div class="p-1" style="margin-top:-5px;">
                          <div  id="text_area_parent${response_note.id}" class="text_area_reply_docs" style="width:23%;">
                         <div onclick="goto_up_note_docs('docs_reply'+ ${response_note.reply_id})"  style="cursor:pointer;position: relative;border-left: 4px solid ${response_note.reply_color};border-radius: 12px;background: #1d0b0b3b;">
                         <b style="color:${response_note.reply_color};font-size: 13px;padding-left: 7px;">${username_note_reply}</b> <br> 
                         
                          <span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon(file_docs_name_reply)}</span>
                        <p  class="d-inline font-weight-bold mr-3" style="width: auto; margin-top: 9px; margin-left: 6px; overflow: hidden; text-overflow: ellipsis;padding-right: 5px;">${doc_name_show_reply}</p>
                        
                        </div>
                       <div class="docs_files${response_note.id}" style="margin-top: 3px;width: 100% ">
                <div id="text_area${response_note.id}" class=" d-flex position-relative" style="width: 105%;margin-left: 0px;margin-bottom: 3px;">
                    <div id="docs_reply${response_note.id}" class="d-flex align-items-center" style="border: 2px solid #c8c8c8;border-radius: 10px;padding-left: 6px;padding-top: 5px;/* width: 75%; *//* max-width: 80%; */width: 100%;">
                        <span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon(file_docs_name)}</span>
                        <p data-toggle="tooltip" data-placement="top" title="${response_note.documents}" class="d-inline font-weight-bold mr-3" style="width: auto; margin-top: 9px; margin-left: 6px; overflow: hidden; text-overflow: ellipsis;padding-right: 5px;">
                        <a href="${path}" target="_blank">${doc_name_show}</a></p>
                    </div>
                 <i id="icon${response_note.id}" style="float: right;position: relative;z-index: 2;right: 17px;top: 3px;color: #8d8a8a;" class="bi bi-three-dots-vertical cursor_ three_dots_action_btn" onclick="showOptionsAction(${response_note.id})"></i>
                      <div class="popup" style="right: -77px;top: -11px;padding: 11px 3px 0px 8px;" id="popup${response_note.id}">
                      <p onclick="reply_msg_note(${response_note.id})" class="cursor_" style="line-height: 5px;">Reply</p>
                                ${show_action_permission}
                     <p data-toggle="tooltip" data-placement="top" title="${response_note.documents}" class="cursor_" style="line-height: 5px;"><a class="text-dark" style="text-decoration:none;" href="${path}" download="${response_note.documents}">Download</a></p>
                            </div>
                         </div>
                          </div> 
                      </div></div> 
                            
                            
                    </div> 
                    </div> 
                       
                        
                      </div>        `;    
                          
                          
                      }
                          
                      }
                    
                  
                    
                }else{
                     show_fetch_data=`
                        <span id="span_${response_note.id}" class="d-block" style="font-size: 11px; padding-left: 14px; margin-bottom: -10px; margin-left: 5px;">${(formatTimestamp_note(response_note.deleted_at)) }</span>
                        <div class="p-1">
                        <div id="text_area${response_note.id}" class="text_area" style="width: 27%;">
                            <p style="position: relative; font-style: italic;color:#706666;margin-bottom: 8px;margin-top: 3px;" id="note_paragraph${response_note.id}">This Message Is Deleted By Superadmin</p> 
                            </div>
                        </div>
                    </div>`;
                }
                
                
                }
                
                      }
            } 
            
            $('#show_notes_all_data').prepend(show_fetch_data);
            
            
            First_record_note++;
        });
        
        check_fetch_run_note="yes";
         fetchData_last_note(false);
        // for run single data
    //      check_fetch_run = "yes";
    
    //   fetchData_last(false);
      
        
    } catch (error) {
        console.error(error.responseText);
    }
}
 
function check_icon(icon_type) {
   // alert('sdjfbjdzvf');
    var icon = "";
    if (icon_type === 'pdf') {
        icon = "<i style='color:#f34646;'  class='bi bi-file-earmark-pdf-fill'></i>";
    } else if (icon_type === 'xls' || icon_type === 'xlsx' || icon_type === 'xlsm' || icon_type === 'xlsb' || icon_type === 'xltx' || icon_type === 'xltm') {
        icon = "<i style='color:#055837c9;' class='bi bi-file-earmark-excel-fill'></i>";
    } 
    else if (icon_type === 'mp4') {
        icon = "<i class='bi bi-file-earmark-play-fill'></i>";
    } else if(icon_type == 'png' || icon_type == 'jpg' || icon_type == 'jpeg' || icon_type == 'heic'){
        icon = '<i style="color:#6eab7f;"  class="bi bi-file-image"></i>';  
    }else{
        icon = "<i style='color:#3b8fe7;' class='bi bi-file-earmark-word-fill'></i>";
    }
    //console.log(icon); // This line will not be executed if placed after the return statement
    return icon;
}
function check_icon_image(icon_type) {
    var icon = "";
    if (icon_type === 'png' || icon_type === 'jpg' || icon_type === 'jpeg' || icon_type === 'heic') {
        icon = '<i style="color:#6eab7f;"  class="bi bi-file-image"></i>';     
    }
    return icon;
}

function makeEditable(id) {
    
    // if  reply open then hide 
    $('#showhidereply_note').css({'display':'none'});
    
    showOptionsAction(id);
    var note_paragraph = $('#note_paragraph' + id).text();
    $('#notes_grp').val(note_paragraph.trim());
    $('#showeditoldmessage').css('display','block');
    $('#old_msg_note').text(note_paragraph);
      autoResizenoteOther();
      for_update_msg=id;

}


function for_update_message(id){
    var old_message = $('#note_paragraph' + id);
    var message_update = $("#notes_grp").val();
    //hide edit popup....
    hide_edit_popup();

     
    $.ajax({
        method: "POST",
        url: "<?= base_url("admin/admin_functions/for_update_message") ?>",
        data:{
            id: id,
            message_update: message_update,
            admin_id_note: admin_id_note,
            old_message: old_message.text() ,
        },
        success: function(response) {
        if (response) {
           $("#notes_grp").val("");
           old_message.text(response.message)
           for_update_msg="";
           check_updated=true;
           console.log('for_update_msg -->' + for_update_msg )
           $('#edited_' + id).text('Edited');
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

function hide_edit_popup(){
     $('#showeditoldmessage').css('display','none');
     $('#old_msg_note').empty(); 
     $('#notes_grp').val(''); 
     $('#notes_grp').css('height','60px'); 
      
}


function for_delete_message(id) {
    $('#popup' + id).hide();
    custom_alert_popup_show('', " Are you sure you want to delete this message ?", 'No', 'btn-danger', true, 'Yes', 'btn_green_yellow', 'AJDSAKAJLD');
    // check Btn click
    $("#AJDSAKAJLD").click(function () {

        $.ajax({
            method: "POST",
            url: "<?= base_url("admin/admin_functions/for_delete_message") ?>",
            data: {
                id: id,
                admin_id_note: admin_id_note,
                userTimezone
            },
            success: function (response) {
                if (response) {
                    //console.log(response);
                    if (response.isdeleted == 1) {

                        if (response.message != '' ) {
                            $('#text_area' + id).css({
                                'width': '27%'
                            });
                            $('#span_' + id).html('');
                            $('#span_' + id).text(formatTimestamp_note(response.deleted_at));
                            $('#span_' + id).css({
                                'margin-left': '5px'
                            });
                            $('#icon' + id).css({
                                'display': 'none'
                            });
                            $('#popup' + id).css({
                                'display': 'none'
                            });
                            
                           
                            
                            $('#note_paragraph' + id).text('This Message Is Deleted By Superadmin');
                            $('#note_paragraph' + id).css({
                                'font-style': 'italic',
                                'height':'22px',
                                'color':'#706666',
                               ' margin-bottom': '8px',
                                'margin-top': '3px'
                            });
                             if(response.reply_documents != '' ){ 
                            $('#text_area_parent' + id).css({
                                'width':'27%',
                                'position': 'relative',
                                'border-radius': '10px',
                                'background-color':'#ece9e9',
                                'padding':' 3px',
                                'display': 'inline-block',
                                'margin-left':'14px',
                                'margin-top':'-2px',
                                'opacity': '0.8',
                                'min-width':'27%',
                                'max-width': '27%',
                             });
                          $('#text_area_parent' + id).html('');    
                          var paragraph_html = `<p style="position: relative; font-style: italic;height:20px;" id="note_paragraph${response.id}">This Message Is Deleted By Superadmin</p>`;
                          $('#text_area_parent' + id).html(paragraph_html);
                         
                            }
                           
                          if(response.reply_message != "" && response.message !=''){
                            $('#text_area' + id).html("");
                            var paragraph_html = `<p style="opacity: 0.8;position: relative; font-style: italic;height:20px;" id="note_paragraph${response.id}">This Message Is Deleted By Superadmin</p>`;
                          $('#text_area' + id).html(paragraph_html);
                          }
                           
                            
                        } else {
                            
                            
                            
                            // if(response.documents != ''){
                            //   $('#text_area' + id).css({
                            //       'margin-top':'8px'
                            //   });
                                   
                            // }
                            
                            
                            $('#span_' + id).html('');
                            $('#span_' + id).text(formatTimestamp_note(response.deleted_at));
                            $('#span_' + id).css({
                                'margin-left': '5px'
                            });
                            $('#icon' + id).css({
                                'display': 'none'
                            });
                            $('#popup' + id).css({
                                'display': 'none'
                            });
                            $('#text_area' + id).html('');
                          
                          $('#text_area_parent' + id).html('');    
                          var paragraph_html = `<p style="opacity: 0.8;position: relative; font-style: italic;height:20px;color:#706666;margin-bottom: 8px;margin-top: 3px;" id="note_paragraph${response.id}">This Message Is Deleted By Superadmin</p>`;
                          $('#text_area_parent' + id).html(paragraph_html);
                         
                            $('#text_area' + id).css({
                                'width':'27%',
                                'position': 'relative',
                                'border-radius': '10px',
                                'background-color':'#ece9e9',
                                'padding':' 3px',
                                'display': 'inline-block',
                                'margin-left':'14px'
                                //'margin-top':'-3px'
                                
                                
                             });
                         var paragraph_html = `<p style="opacity: 0.8;position: relative; font-style: italic;height:20px;margin-bottom: 8px;margin-top: 3px;color:#706666;" id="note_paragraph${response.id}">This Message Is Deleted By Superadmin</p>`;
                         $('#text_area' + id).html(paragraph_html);
                         
                        var filename = response.documents;
                        var getFileExtension_docs = getFileExtension(filename);
                        if(getFileExtension_docs == 'png' || getFileExtension_docs == 'jpg' || getFileExtension_docs == 'jpeg' || getFileExtension_docs == 'heic'){
                       // console.log(getFileExtension_docs);
                         $('#span_' + id).css({
                                'margin-bottom': ''
                            });
                        }
                           if(response.reply_message != ''){
                            $('#text_area_parent' + id).css({
                                'width':'27%',
                                'position': 'relative',
                                'border-radius': '10px',
                                'background-color':'#ece9e9',
                                'padding':' 3px',
                                'display': 'inline-block',
                                'margin-left':'14px',
                                'margin-top':'-2px',
                                
                             });
                         }
                    }
                    }
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
}

function for_delete_all_trash_files() {
    $.ajax({
        method: "GET",
        url: "<?= base_url("admin/admin_functions/for_delete_all_trash_files") ?>",
        
        success: function(response) {
            // Handle success response here
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    }); 
}


function autoResizenoteOther() {
    var textarea = $('#notes_grp');
    textarea.animate({scrollTop: textarea[0].scrollHeight}, 0); 
    var scrollHeight = textarea.prop('scrollHeight'); 
    var currentHeight = textarea.outerHeight();
    if (scrollHeight !== 40) {
        textarea.css('height', 'auto'); 
        if (scrollHeight >= 99) {
            textarea.css('height', '99px'); 
        } else if (scrollHeight <= 160) {
            textarea.css('height', scrollHeight + 'px');
        }
    } else {
        textarea.css('height', '40px'); 
    }
}

    
async function processRecords(response) {
     //last_msg__id_note="";
    //for (const record of response.last_docs_data) {
       // last_msg__id_note = record.id;
       // console.log(record);
       // await fetchData_last_note(record);
   // }
}

 
 var new_msg_received_note = 0;
 var daylabel_afterword_last_note="";
 let fetchDataRunning_note = false;
async function fetchData_last_note(sendByUser = true) {
      
       console.log('last_id' + last_msg__id_note);
     // alert('hiii');
    if (fetchDataRunning_note) {
        return;
    }
    fetchDataRunning_note = true;
     console.log("Check Fetch Run = ", check_fetch_run_note);
    if (check_fetch_run_note == "") {
        return;
    }
    var check_looping_note = 1;
    // var input_resize = document.getElementById("chatbox");
    // input_resize.setAttribute("placeholder", "Type message");
     
    try {
         
          
        const response_one_note = await fetchDataFromServer_note(userTimezone, last_msg__id_note);
      
        if (response_one_note && response_one_note.length > 0) {
            //  console.log(response);
            response_one_note.reverse();
            response_one_note.forEach(response => {
            if (response !== null && response !== '') {
            var lastItem_notes = response;
             if(lastItem_notes.notes_count != 0){
             $('#notes_pointer_count').css({'display':''});     
             }
             $('#notes_pointer_count').text(lastItem_notes.notes_count);
             
             
            //console.log(lastItem_notes);
                       var popup="";
                      var show_action_permission = "";
                        if (admin_id_note == 1) {
                            show_action_permission = `<p class="cursor_" style="line-height: 5px;" onclick="for_delete_message(${lastItem_notes.id})">Delete</p>`;
                        }
                        var for_edit_self = "";
                        if (admin_id_note == lastItem_notes.admin_id) {
                            for_edit_self = `<p class="cursor_" style="line-height: 5px;" onclick="makeEditable(${lastItem_notes.id})" >Edit</p>`;
                        }
                        var username_note='';
                        var username_note_reply='';
                        if(admin_id_note == lastItem_notes.admin_id && lastItem_notes.is_send_doc_request != null){
                          username_note='You';
                        }else{
                          username_note=lastItem_notes.user_name;
                        }
    
                        if(admin_id_note == lastItem_notes.reply_admin_id && lastItem_notes.is_send_doc_request != null){
                             username_note_reply='You';
                        }else{
                             username_note_reply=lastItem_notes.reply_user_name;
                        }
                        //condition for not empty message
                        if(lastItem_notes.message != ''){
                       
                        var Edited = "";
                        if (lastItem_notes.old_message) {
                            Edited = 'Edited';
                        }
                    //when reply message is not empty and reply msg not empty and reply_docs not empty
                      if(lastItem_notes.reply_id != '' && lastItem_notes.reply_msg != '' || lastItem_notes.reply_documents){
                        
                        //if lastitem reply message is not empty
                        if(lastItem_notes.reply_msg != ''){
                        truncatedMessage_note = lastItem_notes.reply_msg.length > 210 ? lastItem_notes.reply_msg.substring(0,210) + '...' : lastItem_notes.reply_msg;
                        
                        lastItem_notes.message =  lastItem_notes.message.replace(/(https?:\/\/\S+)/g, '<a href="$1" target="_blank">$1</a>');
                        
                        var show_fetch_data_last=`
                        <span id="span_${lastItem_notes.id}" class="d-block" style="font-size: 11px; padding-left:14px;">
                        &nbsp<b style="font-size:13px;color:${lastItem_notes.color};margin-right: 6px;">${username_note}</b>
                          ${ (formatTimestamp_note(lastItem_notes.created_at)) } <span id="edited_${lastItem_notes.id}"></span></span>
                          <div id="text_area_parent_${lastItem_notes.id}" class="p-1" style="margin-top: -11px;"  rohit>
                          <div id="text_area${lastItem_notes.id}" class="text_area">
                         <p onclick="goto_up_note('text_area'+ ${lastItem_notes.reply_id})"  style="cursor:pointer;position: relative;border-left: 4px solid ${lastItem_notes.reply_color};border-radius: 12px;background: #1d0b0b3b;padding: 7px;"> <b style="color:${lastItem_notes.reply_color};font-size: 13px;">${username_note_reply}</b> <br> ${truncatedMessage_note}
                        </p>
                        
                         <p style="position: relative;margin-top: -15px; margin-left: 8px;margin-bottom: 9px;" id="note_paragraph${lastItem_notes.id}">
                            ${lastItem_notes.message}
                         </p>
                         <i id="icon${lastItem_notes.id}" style="float:right;position: relative; z-index: 2;margin-top: -33px;" class="bi bi-three-dots-vertical cursor_ three_dots_action_btn" onclick="showOptionsAction(${lastItem_notes.id})"></i>
                        <div class="popup" style="margin-right: 3px; right: 0px; bottom: 1px; display: none;" id="popup${lastItem_notes.id}">
                                  ${for_edit_self}
                          <p onclick="reply_msg_note(${lastItem_notes.id})" class="cursor_" style="line-height: 5px;">Reply</p>
                           ${show_action_permission}
                        </div>
                        </div>
                      </div>`; 
                        } 
                      else if(lastItem_notes.reply_documents != ''  ){
                          
                         var file_docs_name_reply = getFileExtension(lastItem_notes.reply_documents);
                         var doc_name_show_reply = lastItem_notes.reply_documents.length > 70 ? lastItem_notes.reply_documents.substring(0,70) + '...' : lastItem_notes.reply_documents;
                         
                         lastItem_notes.message =  lastItem_notes.message.replace(/(https?:\/\/\S+)/g, '<a href="$1" target="_blank">$1</a>');
                         
                         var show_fetch_data_last=`
                        <span id="span_${lastItem_notes.id}" class="d-block" style="font-size: 11px; padding-left:14px;">
                        &nbsp<b style="font-size:13px;color:${lastItem_notes.color};margin-right: 6px;">${username_note}</b>
                          ${ (formatTimestamp_note(lastItem_notes.created_at)) } <span id="edited_${lastItem_notes.id}"></span></span>
                          <div class="p-1" id="text_area_parent${lastItem_notes.id}" style="margin-top:-5px">
                          <div  id="text_area${lastItem_notes.id}" class="text_area_reply_docs w-auto" style="min-width: 14%;">
                         <div onclick="goto_up_note_docs('docs_reply'+ ${lastItem_notes.reply_id})"  style="cursor:pointer;position: relative;border-left: 4px solid ${lastItem_notes.reply_color};border-radius: 12px;background: #1d0b0b3b;">
                         <b style="color:${lastItem_notes.reply_color};font-size: 13px;padding-left: 7px;">${username_note_reply}</b> <br> 
                         
                          <span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon(file_docs_name_reply)}</span>
                        <p  class="d-inline font-weight-bold mr-3" style="width: auto; margin-top: 9px; margin-left: 6px; overflow: hidden; text-overflow: ellipsis;padding-right: 5px;">${doc_name_show_reply}</p>
                        </div>
                      <div class="d-flex align-items-center" style="margin-top: 1px;margin-left: 1px;overflow: hidden;padding: 0px 3px 3px 5px;">
                    <p id="note_paragraph${lastItem_notes.id}" > ${lastItem_notes.message} &nbsp;&nbsp;</p>
                    </div>
                           <i id="icon${lastItem_notes.id}" style="float:right;position: relative; z-index: 2;margin-top: -33px;" class="bi bi-three-dots-vertical cursor_ three_dots_action_btn" onclick="showOptionsAction(${lastItem_notes.id})"></i>
                        <div class="popup" style="right: -86px;top: 30px;"  id="popup${lastItem_notes.id}">
                                  ${for_edit_self}
                          <p onclick="reply_msg_note(${lastItem_notes.id})" class="cursor_" style="line-height: 5px;">Reply</p>
                           ${show_action_permission}
                        </div>
                        
                      </div>`;  
                          
                      }
                      
              
                     }else{
                         console.log(lastItem_notes);
                         if((lastItem_notes.message != "" && lastItem_notes.documents != "") ){
                             var path=base_url_note.trim() + lastItem_notes.documents_path;
                             var file_docs_name = getFileExtension(lastItem_notes.documents);
                             show_flag='';
                             if(lastItem_notes.is_send_doc_request == 'upload'){
                                 show_flag=`<img style="width:11px;margin-left: 7px;" src="${base_url_note.trim() + '/public/assets/icon/flag-green.png'}">`;
                                 username_note = lastItem_notes.user_name;
                                 for_edit_self='';
                             }
                            // console.log(show_flag);
                             //var file_docs_name = "";
                            //  console.log('when message with docs/files then code stop here');
                         //var file_docs_name_reply = getFileExtension(lastItem_notes.documents);
                         
                         lastItem_notes.message =  lastItem_notes.message.replace(/(https?:\/\/\S+)/g, '<a href="$1" target="_blank">$1</a>');
                         
                         var show_fetch_data_last=`
                        <span id="span_${lastItem_notes.id}" class="d-block" style="font-size: 11px; padding-left:14px;">
                        &nbsp<b style="font-size:13px;color:${lastItem_notes.color};margin-right: 6px;">${username_note}</b>
                          ${ (formatTimestamp_note(lastItem_notes.created_at)) } <span id="edited_${lastItem_notes.id}"></span>${show_flag}</span>
                          <div class="p-1" id="text_area_parent${lastItem_notes.id}" style="margin-top:-5px">
                          <div  id="text_area${lastItem_notes.id}" class="text_area_reply_docs w-auto" style="min-width: 14%;">
                         <div   style="cursor: pointer; position: relative;border-radius: 9px;background: #1d0b0b3b; height: 53px;">
                          <span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon(file_docs_name)}</span>
                      <p data-toggle="tooltip" data-placement="top" title="${lastItem_notes.documents}" class="d-inline font-weight-bold mr-3" style="width: auto; margin-top: 9px; overflow: hidden; text-overflow: ellipsis; padding-right: 5px;">
                        <a href="${path}" target="_blank" >${lastItem_notes.documents}</a>
                    </p>

                        </div>
                      <div class="d-flex align-items-center" style="margin-top: 1px;margin-left: 1px;overflow: hidden;padding: 0px 3px 3px 5px;">
                    <div id="note_paragraph${lastItem_notes.id}" style="padding: 4px;" > ${lastItem_notes.message} &nbsp;&nbsp;</div>
                    </div>
                           <i id="icon${lastItem_notes.id}" style="float:right;position: relative; z-index: 2;margin-top: -27px;" class="bi bi-three-dots-vertical cursor_ three_dots_action_btn" onclick="showOptionsAction(${lastItem_notes.id})"></i>
                        <div class="popup" style="right: -112px;top: 2px;"  id="popup${lastItem_notes.id}">
                                  ${for_edit_self}
                          <p onclick="reply_msg_note(${lastItem_notes.id})" class="cursor_" style="line-height: 5px;">Reply</p>
                           ${show_action_permission}
            <p data-toggle="tooltip" data-placement="top" title="${lastItem_notes.documents}" class="cursor_" style="line-height: 5px;"><a class="text-dark" style="text-decoration:none;" href="${path}" download="${lastItem_notes.documents}">Download</a></p>

                        </div>
                        
                      </div>`; 
                      
                            //END THE CODE OF MSG WITH DOCS 
                         }else{
                             show_flag='';
                             if(lastItem_notes.is_send_doc_request == 'send'){
                                 show_flag=`<img style="width:11px;margin-left: 7px;" src="${base_url_note.trim() + '/public/assets/icon/flag-red.png'}">`;
                             }
                             
                             lastItem_notes.message =  lastItem_notes.message.replace(/(https?:\/\/\S+)/g, '<a href="$1" target="_blank">$1</a>');
                             
                           var show_fetch_data_last = `
                    <span id="span_${lastItem_notes.id}" class="d-block" style="font-size: 11px; padding-left:14px;margin-bottom:-10px; " rohitpagare>
                        &nbsp<b style="font-size:13px;color:${lastItem_notes.color};margin-right: 6px;">${username_note}</b>
                    ${ (formatTimestamp_note(lastItem_notes.created_at)) } <span id="edited_${lastItem_notes.id}"></span> 
                     ${show_flag}
                        
                    </span>
                        <div class="p-1">
                        <div id="text_area${lastItem_notes.id}" class="text_area">
                            <div style="position: relative;padding: 5px 10px" id="note_paragraph${lastItem_notes.id}">${lastItem_notes.message}</div> 
                            <i id="icon${lastItem_notes.id}" style="float:right;position: relative; z-index: 2;margin-top: -33px;" class="bi bi-three-dots-vertical cursor_ three_dots_action_btn" onclick="showOptionsAction(${lastItem_notes.id})"></i>
                            <div class="popup" style="margin-right: 3px;right: 0;bottom: -45px;" id="popup${lastItem_notes.id}">
                                  ${for_edit_self}
                            <p  onclick="reply_msg_note(${lastItem_notes.id})"   class="cursor_" style="line-height: 5px;">Reply</p>
                                 ${show_action_permission}
                            </div>
                        </div>
                    </div>
                `;
                         }
                         
                         
                     }
                    
              
                 
                }else{
                        var file_docs_name = getFileExtension(lastItem_notes.documents);
                        var path = base_url_note.trim() + lastItem_notes.documents_path.trim();
                        
                        // var path_redirect;
                        // console.log(path);
                        // if (file_docs_name === 'xls' || file_docs_name === 'xlsx' || file_docs_name === 'xlsm' || file_docs_name === 'xlsb' || file_docs_name === 'xltx' || file_docs_name === 'xltm') {
                        //     path_redirect = 'ms-excel:ofe|u|' + path;
                        // } else if (file_docs_name === 'doc' || file_docs_name === 'docx' || file_docs_name === 'docm') {
                        //     path_redirect = 'ms-word:ofe|u|' + path;
                        // } else {
                        //     path_redirect = path;
                        // }
                     if(lastItem_notes.reply_id == 0 && lastItem_notes.reply_documents == '' ){
                            if(lastItem_notes.documents.endsWith('.png') || lastItem_notes.documents.endsWith('.jpg') || lastItem_notes.documents.endsWith('.jpeg')|| lastItem_notes.documents.endsWith('.heic')){
                    var popup = `right: -113px; top: 8px; padding: 11px 4px 1px 8px;`;
                    var show_fetch_data_last = `
                        <span id="span_${lastItem_notes.id}" class="d-block" style="font-size: 11px; padding-left:14px; margin-bottom: -10px;">
                            &nbsp;<b style="font-size:13px;color:${lastItem_notes.color};margin-right: 6px;">${username_note}</b>
                            ${formatTimestamp_note(lastItem_notes.created_at)}
                        </span>
                        <div id="text_area${lastItem_notes.id}" class="p-1" style="width: 200px;position:relative;">
                            <div id="docs_reply${lastItem_notes.id}" class="text_area" style="border:2px solid #c8c8c8; width: auto;height: auto;padding: 0px;position:relative;">
                                <a data-toggle="tooltip" data-placement="top" title="${lastItem_notes.documents}" href="${path}" target="_blank"><img src="${path}" width="191px" height="145px" style="border: 1px solid #c8c8c8;border-radius: 10px;" ></a>
                                <i id="icon${lastItem_notes.id}" style="float: right;position: absolute;z-index: 2;top: -3px; right: -22px;font-size: 26px;color: #8d8a8a;" class="bi bi-three-dots-vertical cursor_ three_dots_action_btn" onclick="showOptionsAction(${lastItem_notes.id})"></i>
                            </div>
                            <div>
                                <div class="popup" style="${popup}" id="popup${lastItem_notes.id}">
                    <p  onclick="reply_msg_note(${lastItem_notes.id})"   class="cursor_" style="line-height: 5px;">Reply</p>
                                    ${show_action_permission}
                                    <p data-toggle="tooltip" data-placement="top" title="${lastItem_notes.documents}" class="cursor_" style="line-height: 5px;"><a class="text-dark" style="text-decoration:none;" href="${path}" download="${lastItem_notes.documents}">Download</a></p>
                                </div>
                            </div>
                        </div>
                        
                
                `;
                }else{
                    // console.log(check_icon(file_docs_name));
                    // return;
                    popup=`right: 64px;top: -10px;padding: 11px 3px 0px 8px;`;
                    var doc_name_show = lastItem_notes.documents.length > 85 ? lastItem_notes.documents.substring(0,85) + '...' : lastItem_notes.documents;
                    var show_fetch_data_last = `
                    <span id="span_${lastItem_notes.id}" class="d-block" style="font-size: 11px; padding-left:14px; margin-bottom: -10px;">
                        &nbsp<b style="font-size:13px;color:${lastItem_notes.color};margin-right: 6px;">${username_note}</b>
                    ${ (formatTimestamp_note(lastItem_notes.created_at)) }
                    </span>
                    
                   <div id="text_area${lastItem_notes.id}"  class="col-4 m-2 ms-3 d-flex position-relative" >
                    <div id="docs_reply${lastItem_notes.id}" class="d-flex align-items-center" style="border: 2px solid #c8c8c8; border-radius: 10px; padding-left: 6px; padding-top: 5px; width: 68.7%;max-width: 68.7%;">
                        <span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon(file_docs_name)}</span>
                        <p data-toggle="tooltip" data-placement="top" title="${lastItem_notes.documents}"  class="d-inline font-weight-bold mr-3" style="width: auto; width: 76%; margin-top: 9px; margin-left: 6px; overflow: hidden; text-overflow: ellipsis;padding-right: 5px;">
                        <a href="${path}" target="_blank">${doc_name_show}</a></p>

                    </div>
                     <i id="icon${lastItem_notes.id}" style="float: right;position: relative;z-index: 2;right: 17px;top: 3px;color: #8d8a8a;" class="bi bi-three-dots-vertical cursor_ three_dots_action_btn"  onclick="showOptionsAction(${lastItem_notes.id})"></i>
                      <div class="popup" style="${popup}"  id="popup${lastItem_notes.id}">
                             <p  onclick="reply_msg_note(${lastItem_notes.id})"   class="cursor_" style="line-height: 5px;">Reply</p>
                                 ${show_action_permission}
                                 <p data-toggle="tooltip" data-placement="top" title="${lastItem_notes.documents}" class="cursor_" style="line-height: 5px;"><a class="text-dark" style="text-decoration:none;" href="${path}" download="${lastItem_notes.documents}">Download</a></p>
                            </div>
                        </div>
                         
                `; 
                 
                } 
                     }else{
                         //images reply to message
                          if(lastItem_notes.reply_msg != ''){
                         // console.log('i am here');
                        truncatedMessage_note = lastItem_notes.reply_msg.length > 30 ? lastItem_notes.reply_msg.substring(0,30) + '...' : lastItem_notes.reply_msg;
                      
                      if(lastItem_notes.documents.endsWith('.png') || lastItem_notes.documents.endsWith('.jpg') || lastItem_notes.documents.endsWith('.jpeg') || lastItem_notes.documents.endsWith('.heic')){
                      
                        var show_fetch_data_last=`
                        <span id="span_${lastItem_notes.id}" class="d-block" style="font-size: 11px; padding-left:14px;">
                        &nbsp<b style="font-size:13px;color:${lastItem_notes.color};margin-right: 6px;">${username_note}</b>
                          ${ (formatTimestamp_note(lastItem_notes.created_at)) } <span id="edited_${lastItem_notes.id}"></span></span>
                          <div class="p-1" style="margin-top:-5px;" rohit id="text_area_parent${lastItem_notes.id}">
                          <div  class="text_area" style="width:13.8% !important;min-width:200px;">
                         <p onclick="goto_up_note('text_area'+ ${lastItem_notes.reply_id})"  style="cursor:pointer;position: relative;border-left: 4px solid ${lastItem_notes.reply_color};border-radius: 12px;background: #1d0b0b3b;padding: 7px;"> <b style="color:${lastItem_notes.reply_color};font-size: 13px;">${username_note_reply}</b> <br> ${truncatedMessage_note}
                        </p>
                           <div class="docs_files${lastItem_notes.id}">
                      <div id="text_area${lastItem_notes.id}"  class="p-1" style="width: 200px;position:relative;margin-top: 8px;min-width:200px;">
                        <div id="docs_reply${lastItem_notes.id}"class="text_area" style="border: 2px solid #c8c8c8;width: auto;height: auto;padding: 0px;position: ralative;margin: 0px;margin-top: -18px;margin-left: -2px;">
                        <a data-toggle="tooltip" data-placement="top" title="${lastItem_notes.documents}" href="${path}"  target="_blank" >
                        <img src="${path}" width="191px" height="145px" style="border: 1px solid #c8c8c8;border-radius: 10px;"></a>
                        <i id="icon${lastItem_notes.id}" style="float: right;position: absolute;z-index: 2;top: -3px; right: -26px;font-size: 26px;color: #8d8a8a;" class="bi bi-three-dots-vertical cursor_ three_dots_action_btn" onclick="showOptionsAction(${lastItem_notes.id})"></i>
                        </div>
                     <div>
                        </div>
                          <div class="popup_reply_image popup" style="${popup}" id="popup${lastItem_notes.id}" rohit>
                                 <p  onclick="reply_msg_note(${lastItem_notes.id})"   class="cursor_" style="line-height: 5px;">Reply</p>
                                  ${show_action_permission}
                                 <p data-toggle="tooltip" data-placement="top" title="${lastItem_notes.documents}" class="cursor_" style="line-height: 5px;"><a class="text-dark" style="text-decoration:none;" href="${path}" download="${lastItem_notes.documents}">Download</a></p>
                            </div>
                    </div> 
                    </div> 
                             
                        </div>
                      </div>`; 
                      }else{
                          //reply for meessage with docs
                           var truncatedMessage_note = lastItem_notes.reply_msg.length > 43 ? lastItem_notes.reply_msg.substring(0,43) + '...' : lastItem_notes.reply_msg;
                           var doc_name_show = lastItem_notes.documents.length > 30 ? lastItem_notes.documents.substring(0,30) + '...' : lastItem_notes.documents;
                      var show_fetch_data_last=`
                        <span id="span_${lastItem_notes.id}" class="d-block" style="font-size: 11px; padding-left:14px;">
                        &nbsp<b style="font-size:13px;color:${lastItem_notes.color};margin-right: 6px;">${username_note}</b>
                          ${ (formatTimestamp_note(lastItem_notes.created_at)) } <span id="edited_${lastItem_notes.id}"></span></span>
                          <div class="p-1" id="text_area_parent${lastItem_notes.id}">
                          <div class="text_area" style="width: 22.8% !important;margin-top: -7px;">
                         <p onclick="goto_up_note('text_area'+ ${lastItem_notes.reply_id})" style="cursor:pointer;position: relative;border-left: 4px solid ${lastItem_notes.reply_color};border-radius: 12px;background: #1d0b0b3b;padding: 7px;"> <b style="color:${lastItem_notes.reply_color};font-size: 13px;">${username_note_reply}</b> <br> ${truncatedMessage_note}
                        </p>
                 <div class="docs_files${lastItem_notes.id}" style="margin-top: -13px;width: 100% ">
                <div id="text_area${lastItem_notes.id}" class=" d-flex position-relative" style="width: 105%;margin-left: 0px;margin-bottom: 3px;">
                    <div id="docs_reply${lastItem_notes.id}" class="d-flex align-items-center" style="border: 2px solid #c8c8c8;border-radius: 10px;padding-left: 6px;padding-top: 5px;/* width: 75%; *//* max-width: 80%; */width: 100%;">
                        <span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon(file_docs_name)}</span>
                        <p data-toggle="tooltip" data-placement="top" title="${lastItem_notes.documents}" class="d-inline font-weight-bold mr-3" style="width: auto; margin-top: 9px; margin-left: 6px; overflow: hidden; text-overflow: ellipsis;padding-right: 5px;">
                        <a href="${path}" target="_blank">${doc_name_show}</a></p>
                    </div>
                 <i id="icon${lastItem_notes.id}" style="float: right;position: relative;z-index: 2;right: 17px;top: 3px;color: #8d8a8a;" class="bi bi-three-dots-vertical cursor_ three_dots_action_btn" onclick="showOptionsAction(${lastItem_notes.id})"></i>
                      <div class="popup" style="right: -77px;top: -11px;padding: 11px 3px 0px 8px;" id="popup${lastItem_notes.id}">
                      <p onclick="reply_msg_note(${lastItem_notes.id})" class="cursor_" style="line-height: 5px;">Reply</p>
                                ${show_action_permission}
                     <p data-toggle="tooltip" data-placement="top" title="${lastItem_notes.documents}" class="cursor_" style="line-height: 5px;"><a class="text-dark" style="text-decoration:none;" href="${path}" download="${lastItem_notes.documents}">Download</a></p>
                            </div>
                         </div>
                          </div> 
                      </div></div> `;    
                
                      }
                      
                      
                        } 
                      else if(lastItem_notes.reply_documents != ''  ){
                          
                         popup = `right: -150px;top: -10px;padding: 11px 4px 1px 8px;`;
                         var file_docs_name_reply = getFileExtension(lastItem_notes.reply_documents);
                         var doc_name_show_reply = lastItem_notes.reply_documents.length > 20 ? lastItem_notes.reply_documents.substring(0,20) + '...' : lastItem_notes.reply_documents;
                         
                         
                         //else for reply image to image when docs insert.
                         if(lastItem_notes.documents.endsWith('.png') || lastItem_notes.documents.endsWith('.jpg') || lastItem_notes.documents.endsWith('.jpeg') || lastItem_notes.documents.endsWith('.heic')){ 
                         var show_fetch_data_last=`
                        <span id="span_${lastItem_notes.id}" class="d-block" style="font-size: 11px; padding-left:14px;">
                        &nbsp<b style="font-size:13px;color:${lastItem_notes.color};margin-right: 6px;">${username_note}</b>
                          ${ (formatTimestamp_note(lastItem_notes.created_at)) } <span id="edited_${lastItem_notes.id}"></span></span>
                          <div class="p-1" >
                          <div  id="text_area${lastItem_notes.id}" class="text_area_reply_docs" style="width:17%;margin-top: -7px;" >
                         <div onclick="goto_up_note_docs('docs_reply'+ ${lastItem_notes.reply_id})"  style="cursor:pointer;position: relative;border-left: 4px solid ${lastItem_notes.reply_color};border-radius: 12px;background: #1d0b0b3b;">
                         <b style="color:${lastItem_notes.reply_color};font-size: 13px;padding-left: 7px;">${username_note_reply}</b> <br> 
                         
                          <span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon(file_docs_name_reply)}</span>
                        <p  class="d-inline font-weight-bold mr-3" style="width: auto; margin-top: 9px; margin-left: 6px; overflow: hidden; text-overflow: ellipsis;padding-right: 5px;">${doc_name_show_reply}</p>
                        </div>
                        <div class="docs_files${lastItem_notes.id}">
                      <div id="text_area${lastItem_notes.id}"  class="p-1" style="width: 200px;position:relative;">
                        <div id="docs_reply${lastItem_notes.id}"class="text_area" style="border: 2px solid #c8c8c8;width: auto;height: auto;padding: 0px;position: ralative;margin: 0px;margin-left: -2px;">
                        <a data-toggle="tooltip" data-placement="top" title="${lastItem_notes.documents}" href="${path}"  target="_blank" >
                        <img src="${path}" width="242px" height="145px" style="border: 1px solid #c8c8c8;border-radius: 10px;"></a>
                       
                        </div>
                     <div>
                        </div>
                         <i id="icon${lastItem_notes.id}" style="float: right;position: absolute;z-index: 2;top: -3px; right: -68px;font-size: 26px;color: #8d8a8a;" class="bi bi-three-dots-vertical cursor_ three_dots_action_btn" onclick="showOptionsAction(${lastItem_notes.id})"></i>
                          <div class="popup_reply_image popup" style="${popup}" id="popup${lastItem_notes.id}" rohit>
                                 <p  onclick="reply_msg_note(${lastItem_notes.id})"   class="cursor_" style="line-height: 5px;">Reply</p>
                                  ${show_action_permission}
                                 <p data-toggle="tooltip" data-placement="top" title="${lastItem_notes.documents}" class="cursor_" style="line-height: 5px;"><a class="text-dark" style="text-decoration:none;" href="${path}" download="${lastItem_notes.documents}">Download</a></p>
                            </div>
                    </div> 
                    </div> 
                       
                        
                      </div>`;  
                      //else for reply documents
                      }else{
                          
                          
                          var doc_name_show = lastItem_notes.documents.length > 50 ? lastItem_notes.documents.substring(0,50) + '...' : lastItem_notes.documents;
                          var doc_name_show_reply = lastItem_notes.reply_documents.length > 35 ? lastItem_notes.reply_documents.substring(0,35) + '...' : lastItem_notes.reply_documents;

                         var show_fetch_data_last=`
                        <span id="span_${lastItem_notes.id}" class="d-block" style="font-size: 11px; padding-left:14px;">
                        &nbsp<b style="font-size:13px;color:${lastItem_notes.color};margin-right: 6px;">${username_note}</b>
                          ${ (formatTimestamp_note(lastItem_notes.created_at)) } <span id="edited_${lastItem_notes.id}"></span></span>
                          <div class="p-1" style="margin-top:-5px;">
                          <div  id="text_area_parent${lastItem_notes.id}" class="text_area_reply_docs" style="width:23%;">
                         <div onclick="goto_up_note_docs('docs_reply'+ ${lastItem_notes.reply_id})"  style="cursor:pointer;position: relative;border-left: 4px solid ${lastItem_notes.reply_color};border-radius: 12px;background: #1d0b0b3b;">
                         <b style="color:${lastItem_notes.reply_color};font-size: 13px;padding-left: 7px;">${username_note_reply}</b> <br> 
                         
                          <span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon(file_docs_name_reply)}</span>
                        <p  class="d-inline font-weight-bold mr-3" style="width: auto; margin-top: 9px; margin-left: 6px; overflow: hidden; text-overflow: ellipsis;padding-right: 5px;">${doc_name_show_reply}</p>
                        
                        </div>
                       <div class="docs_files${lastItem_notes.id}" style="margin-top: 3px;width: 100% ">
                    <div id="text_area${lastItem_notes.id}" class=" d-flex position-relative" style="width: 105%;margin-left: 0px;margin-bottom: 3px;">
                    <div id="docs_reply${lastItem_notes.id}" class="d-flex align-items-center" style="border: 2px solid #c8c8c8;border-radius: 10px;padding-left: 6px;padding-top: 5px;/* width: 75%; *//* max-width: 80%; */width: 100%;">
                        <span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon(file_docs_name)}</span>
                        <p data-toggle="tooltip" data-placement="top" title="${lastItem_notes.documents}" class="d-inline font-weight-bold mr-3" style="width: auto; margin-top: 9px; margin-left: 6px; overflow: hidden; text-overflow: ellipsis;padding-right: 5px;">
                        <a href="${path}" target="_blank">${doc_name_show}</a></p>
                    </div>
                 <i id="icon${lastItem_notes.id}" style="float: right;position: relative;z-index: 2;right: 17px;top: 3px;color: #8d8a8a;" class="bi bi-three-dots-vertical cursor_ three_dots_action_btn" onclick="showOptionsAction(${lastItem_notes.id})"></i>
                      <div class="popup" style="right: -77px;top: -11px;padding: 11px 3px 0px 8px;" id="popup${lastItem_notes.id}">
                      <p onclick="reply_msg_note(${lastItem_notes.id})" class="cursor_" style="line-height: 5px;">Reply</p>
                                ${show_action_permission}
                     <p data-toggle="tooltip" data-placement="top" title="${lastItem_notes.documents}" class="cursor_" style="line-height: 5px;"><a class="text-dark" style="text-decoration:none;" href="${path}" download="${lastItem_notes.documents}">Download</a></p>
                            </div>
                         </div>
                          </div> 
                      </div></div> 
                            
                            
                    </div> 
                    </div> 
                       
                        
                      </div>`;    
                          
                          
                      } 
                          
                      }
                      
                         
                     }
                     
                  
                
                
                
                
                      }
                      
        
          }
          
          //console.log('check data here........>' + last_msg__id_note  + lastItem_notes.id);
           if(last_msg__id_note != lastItem_notes.id && last_msg__id_note < lastItem_notes.id){
                 // console.log(show_fetch_data_last);
          $('#show_notes_all_data').append(show_fetch_data_last);
          scroll_bottom();  
         // console.log(lastItem_notes.admin_id + admin_id_note);
        //   if(lastItem_notes.admin_id == admin_id_note){
               
        //   }
             
         }  
          
        });
        
        
        
                //   console.log(lastItem_notes.id);
                //   response_one[0].id;
                //   return;
            
        //  if(last_msg__id_note != lastItem_notes.id){
                  
        //   $('#show_notes_all_data').append(show_fetch_data_last);
        //   scroll_bottom();
        //  }
            //  });
             // console.log("Last Message = ", loop);
        last_msg__id_note = response_one_note[response_one_note.length - 1].id;

        }

        // if (new_msg_received != 0) {
        //   //  play_sound();
        //     new_msg_received = 0;
        // }
        // make_count_area();
        setTimeout(async () => {
            fetchDataRunning_note = false;
            await fetchData_last_note(false);
        }, 500);

      // console.log("Running Last Function");
    } catch (error) {
         console.error(error);
         fetchDataRunning_note = false;
        // If an error occurs, clear the flag to allow future attempts
        setTimeout(() => {
            fetchData_last_note(false);
        }, 500);
    }
}

function fetchDataFromServer_note(userTimezone, last_msg__id_note) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '<?= base_url("admin/admin_functions/last_one_data_fetch_notes") ?>',
            method: 'POST',
            data: {
                userTimezone,
                last_msg__id_note,
                pointer_id_global
                
            },
            success: function (response) {
                
                // console.log(response);
                // console.log('efhdsgavhfcvd' + response);
                // return;
                resolve(response);
            },
            error: function (xhr, status, error) {
                reject(error);
            }
        });
    });
}



function deleteDiv_note() {
    reply_id_note="";
    reply_msg_update_note="";
    reply_docs_files ='';
    reply_docs_path = '';
    reply_admin_id = '';
    
    var showhidereply_note = document.getElementById('showhidereply_note');
    var notes_grp = document.getElementById('notes_grp');
    var previous_msg_notes = document.getElementById('previous_msg_notes');
        showhidereply_note.style.display = 'none';
       // previous_msg_notes.innerHTML = '';
}



var reply_msg_update_note = '';
var reply_msg_note_;
var reply_user_name_note = '';
var reply_color_note = '';
var reply_id_note = '';
var reply_docs_files ='';
var reply_docs_path = '';
var reply_admin_id = '';

function reply_msg_note(id) {
    
    //if edit popup open then hide 
      hide_edit_popup();
    
     showOptionsAction(id);
    
  var previous_msg_note = document.getElementById('previous_msg_note');
  var notes_grp_ = document.getElementById('notes_grp');
  var showhidereply_note = document.getElementById('showhidereply_note');
     
  var admin_id=admin_id_note;
    
        previous_msg_note.innerHTML = '';
  $.ajax({
  url: '<?= base_url("admin/admin_functions/chat_system_fetch_reply_note") ?>',
  method: 'GET',
  data: { id: id },
  success: function(response) {
    if(response){
        
         if(admin_id == response.admin_id && response.is_send_doc_request == null){
            var username='You';
            //alert(username);
        }else{
             var username=response.user_name;
        }
        console.log(response);
        var truncated_docs_note='';
        var truncatedMessage_note='';
        if(response.message != '' ){
         truncatedMessage_note = response.message.length > 370 ? response.message.substring(0,370) + '...' : response.message;
        var msg = `<b style="color: ${response.color}; font-size: 13px;">${username}</b> <br> ${truncatedMessage_note}`;
        $('#previous_msg_note').append(msg);
        }else{
        
        if(response.documents.endsWith('.png') || response.documents.endsWith('.jpg') || response.documents.endsWith('.jpeg')|| response.documents.endsWith('.heic')){
        // var path = base_url_note.trim() + response.documents_path.trim();
        var file_docs_name_reply = getFileExtension(response.documents);
        var file_docs_icon=`<span  class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon_image(file_docs_name_reply)}</span>`;
         truncated_docs_note = response.documents;
         reply_docs_path=response.documents_path;
        var msg = `<b style="color: ${response.color}; font-size: 13px;">${username}</b> <br>${file_docs_icon}<span class="cursor_"> ${truncated_docs_note} </span>`;
            $('#previous_msg_note').append(msg);
            
        }else{
        var file_docs_name_reply = getFileExtension(response.documents);
        var file_docs_icon=`<span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon(file_docs_name_reply)}</span>`;
        // var path_reply = base_url_note.trim() + response.documents_path.trim();
         truncated_docs_note = response.documents;
         reply_docs_path=response.documents_path;
        var msg = `<b style="color: ${response.color}; font-size: 13px;">${username}</b> <br>${file_docs_icon} <span class="cursor_"> ${truncated_docs_note} </span>`;
            $('#previous_msg_note').append(msg);
        }
        
        }

       //for add css when reply 
        showhidereply_note.style.display = 'block';
       $('#previous_msg_note').css({'border-left': '4px solid ' + response.color});

     //map global var
     
      reply_id_note=response.id;
      reply_msg_update_note=response.message;
      reply_msg_note_=truncatedMessage_note;
      reply_user_name_note=response.user_name;
      reply_color_note=response.color;
      reply_docs_files=truncated_docs_note;
      reply_docs_path=response.documents_path;
      reply_admin_id =response.admin_id;
     
    // console.log(reply_admin_id);
      previous_msg_note.setAttribute('data-value', currentValue + '');
      var currentValue = parseInt(previous_msg.getAttribute('data-value')) || '';
      previous_msg_note.setAttribute('data-value', response.id);
      previous_msg_note.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
      notes_grp_.focus();
    }
  },
  error: function(error) {
    console.error('Error:', error);
  }
});
}

function goto_up_note(element) {
    
   
    //#c8c8c8
  $("#" + element).css({
  //backgroundColor: "#FFCC01", 
   border: "2px solid #FFCC01"
});
  $("#" + element).get(0).scrollIntoView();
  
  setTimeout(function() {
    $("#" + element).css({
      //backgroundColor: "#ece9e9", 
       border: ""
    });
  }, 2000); // 2000 
}

function goto_up_note_docs(element) {
    
   
    //#c8c8c8
  $("#" + element).css({
  //backgroundColor: "#FFCC01", 
   border: "2px solid #FFCC01"
});
  $("#" + element).get(0).scrollIntoView();
  
  setTimeout(function() {
    $("#" + element).css({
      //backgroundColor: "#ece9e9", 
       border: "2px solid #c8c8c8"
    });
  }, 2000); // 2000 
}


$(document).ready(function(){
   $('body').click(function(event) { 
       console.log(event.target);
        if(event.target.id == "open_the_gallery_area" || event.target.id == "popup" || event.target.classList.contains("three_dots_action_btn")) 
            return;
            
        // Close the two collpase -> Mohsin
        close_options();
        hideOptionsAction();
    }); 
});
</script>

  

 

 