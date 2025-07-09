<?php

if (isset($show_said_bar)) {
} else {
    $show_said_bar = true;
}
if ($show_said_bar) {
    
?>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <style>
/*.sidebar_right {*/
/*    height: auto;*/
/*    position: fixed;*/
/*    right: 0;*/
/*    height: 86.5%;*/
/*    width: 100%;*/
/*    max-width: 300px !important;*/
/*    transition: all 0.3s;*/
/*    padding: 20px;*/
/*    top: 122px;*/
/*    scrollbar-width: thin;*/
/*    scrollbar-color: #aab7cf transparent;*/
/*    box-shadow: 0px 0px 20px rgba(1, 41, 112, 0.1);*/
/*    background-color: #fff;*/
/*        }*/
      

.sidebar_right{
    height: auto;
    position: fixed;
    right: 0rem;
    height: 81%;
    width: 394px !important;
    transition: all 0.3s;
    padding: 20px;
    top: 119px;
    scrollbar-width: thin;
    scrollbar-color: #aab7cf transparent;
    /*box-shadow: 0px 0px 20px rgba(1, 41, 112, 0.1);*/
    /*background-color: #fff;*/
    /*border: 1px solid white;*/
    border-radius: 10px;
}
@media (min-width: 1801px) {
    .sidebar_right {
        top: 132px !important;
    }
    
   }

        .shadow {
            box-shadow: none !important;
        }
        @media (max-width: 1199px) {
            .sidebar_right {
                left: -300px;
            }
        }
   
        .sidebar_right::-webkit-scrollbar {
            width: 5px;
            height: 8px;
            background-color: #fff;
        }

        .sidebar_right::-webkit-scrollbar-thumb {
            background-color: #aab7cf;
        }

        @media (max-width: 1199px) {
            .toggle-sidebar .sidebar {
                left: 0;
            }
        }

        @media (min-width: 1800px) {
             
            .toggle-sidebar #main,
            .toggle-sidebar #footer {
                margin-left: 0;
                background-color: red;
                
            }

            .toggle-sidebar .sidebar {
                left: -300px;
            }
        }
    </style>
    <style>
           .custom-background {
        background-color: #28a745; 
        color: #fff; 
        
    }
  
/*.chat {*/
/*       height: 95%;*/
/*    top: 0;*/
/*    position: absolute;*/
/*    bottom: 10px;*/
/*    left: 14.5%;*/
/*    z-index: 66;*/
/*    width: 86%;*/
/*}*/

.chat {
    height: 100%;
    top: 0;
    position: absolute;
    bottom: 10px;
    left: 0px;
    z-index: 66;
    width: 100%;
}
        }
.custom_footer{
    width: 296px;
    margin-left: 2px;
    height: 64px;
    position: relative;
    bottom: 0;
    
        }
.custom_tel{
     font-size: 39px;
    color: #28a745;
    transform: rotate(20deg);
    margin-left: -23px;
    left: 345px;
    bottom: -55px;
    position: absolute;
        }
.scroll_{
    position: relative;
    height: 650px; overflow-y: auto;
    overflow-x:hidden;

}        
/* width */
.scroll_::-webkit-scrollbar {
  width: 5px;
}

/* Track */
.scroll_::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px grey; 
  border-radius: 10px;
}
 
/* Handle */
.scroll_::-webkit-scrollbar-thumb {
  background: grey; 
  border-radius: 10px;
}

/* Handle on hover */
.scroll_::-webkit-scrollbar-thumb:hover {
  background: grey; 
}    

.scroll_chat{
    position: relative;
    overflow-y: auto;
    overflow-x:hidden;

}        
/* width */
.scroll_chat::-webkit-scrollbar {
  width: 1px;
}

/* Track */
.scroll_chat::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px grey; 
  border-radius: 10px;
}
 
/* Handle */
.scroll_chat::-webkit-scrollbar-thumb {
  background: grey; 
  border-radius: 10px;
}

/* Handle on hover */
.scroll_chat::-webkit-scrollbar-thumb:hover {
  background: grey; 
}    
.show_users::-webkit-scrollbar {
    display: none;
}
.show_users::-webkit-scrollbar-track {
    background-color: #f0f0f0;
}
.show_users::-webkit-scrollbar-thumb {
    background-color: #c0c0c0;
    border-radius: 10px;
}
.show_users:hover::-webkit-scrollbar {
    display: block;
}
@media (min-width: 1801px) {
    #main {
        margin-top: 104px !important;
    }
    
   }

    a{
      color:black;  
    }
    #chatbox {
    height: 40px;
    font-size: 18px;
    width: 100%;
    margin-left: -4px;
    resize: none;

    /*font-size: 10px;*/
    margin-left: 1px;
    width: 78%;
    padding: 6px 13px !important;
    border: none;
    box-shadow: none;
    /*border-radius: 10px 10px 0px 0px;*/
        }
        #chatbox::placeholder {
       color: #999; 
       font-style: italic; 
       font-size:18px;
}
       .custom-icon {
        width: 33px;
        height: 28px;
        background: #cbd7ca;
        border: 1px solid white;
        border-radius: 12px;
    
}
.custom_style_icon {
    background: #f5f6f7;
    width: 25px;
    text-align: center;
    border: 1px solid white;
    border-radius: 18px;
    height: 24px;
    margin-bottom: -12px;
    z-index: 3;
    margin-right: 0px;
    margin-top: 27px;
    
    
}
.custom_style_del{
    color:red;
    margin-top: 28px
}
.previous_msg{
   margin-left: 0px;
    width: 78.5%;
    margin-top: -4px;
    height: 54px;
    border-top: 2px solid #e9edefcc;
    border-radius: 7px;
    background: #e9edefcc;
    border-left: 2px solid #e9edefcc;
    border-right: 2px solid #e9edefcc;
    margin-bottom: 5px;
}
.cursor_{
    cursor:pointer;
}
.drag_files_chat{
    margin-left: 1px;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
    background-color: #FFFFFF;
    display: block;
    min-width: 78%;
    max-width: 78%;
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
       
    </style>
    <?php
     $current_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    ?>
        <?php   
  if (session()->has('admin_account_type')) {
    //   print_r($_SESSION);
       $admin_account_type =  session()->get('admin_account_type');
       $admin_id =  session()->get('admin_id');
       $admin_name=session()->get('admin_name');
       $admin_email=session()->get('admin_email');
       
           
  }     
//   echo $notification;
  $_fname= find_one_row('admin_account', 'id', $admin_id)->first_name;
  $_lname= find_one_row('admin_account', 'id', $admin_id)->last_name_chat;
  $get_Admin_fname=$_fname.$_lname;
  
  $admin_data=admin_data($admin_id);
  
?>
<?php $base_url=base_url(); ?>

<div>
    <input type="hidden" id="admin_id" value="<?=$admin_id;?>"> 
    <input type="hidden" id="get_Admin_fname" value="<?=$get_Admin_fname;?>"> 
    <input type="hidden" id="base_url" value="<?=$base_url;?>"> 
    
    </div>
<style>
    
    .img{
    width: 35px;
    height: 35px;
    border-radius: 25px;
    margin-left: 8px;
    margin-top: 5px;
    }
    .custom_badge{
    top: 37px;
    left: 37px;
    }
    .show_users{
    height: 350px;
    width: 310px;
    background: #f0f0f0;
    position: absolute;
    right: 15px;
    top: 45px;
    border-radius: 10px;
    z-index: 5;
    overflow-y: scroll;
    }
    #popup_chat {
        width: 196px;
    height: 83px;
    display: none;
    position: absolute;
    bottom: 17px; 
    right: -15px;
    transform: translate(-50%, -50%);
    padding: 15px;
    background-color: #dcd8d8;
    border: 2px solid #ccc;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 300px;
    border-radius: 10px;
        }
        .files_box_chat{
     border-width:2px;
     border-radius: 10px;
     margin: 5px;
     padding: 0px 4px 6px 4px;
     background-color: #ededed;
     list-style:none;
     width: 108%;
      }
</style>
 
                   
 </div>
    <aside id="sidebar_right" class="sidebar_right shadow mt-1 " style="display: none;">
          
                     <div class="card chat" id="chat_module" >
                        
                        <!--onmouseout="hideActiveDiv() onmouseover="showActiveDiv()""-->
        
                        <div class="card-header position-relative  d-flex justify-content-between align-items-center p-3" style="padding: 9px !important;">
                            <h5 class="mb-0">Group Chat </h5>
                           <button type="button" class="btn position-relative p-0" style="right:26%; top:-28%;width:18%;height:24px;border:none;">
                                <i onmouseover="show_active_logins()" onclick="show_active_logins()"style="color: #055837;cursor:pointer;font-size: 24px;" class=" ms-2 bi bi-people-fill"></i> 
                                <span onclick="show_active_logins()"  style="position: relative;top: -6px; padding: 4px;" class="badge text-bg-secondary" id="show_count"></span></button>
                            <button type="button" class="close" id="toggleButton_"  aria-label="Toggle_" onclick="Closechat();">
                                <span style="padding-right: 9px;margin-right: 7px;opacity: 18.5 !important;" class="btn-close" aria-hidden="true"></span>
                            </button>
                             <div class="p-2 text-center show_users" id="show_users" style="display:none;"></div>
                        </div>
                       
                        <!--<div><=$current_url?></div>-->
   <div   class="card-body scroll_ " id="chat_area" data-mdb-perfect-scrollbar="true" onscroll="remove_notification_count()" >
               <!--<p id="days_label" class="text-center mx-3 mb-0" style="color: #a2aab7;"></p>-->
            <div id="result">
               
            <div class="d-flex flex-row justify-content-start">
                
              <!--<img src="<=base_url('public/assets/chat/user1.jpg')?>" alt="User Image"style="width: 44px; height: 100%;>-->
              <div id="result_oponent"  onclick="click_anywhere_onchat()">
               
              </div>
            </div>
</div>

          </div>
      
  
         
  <div class="card-footer text-muted  custom_footer" id="custom_footer" >
      
  <!-- <div id="progress_chat" style="width: 83%;margin-left: -11px;display:none;"  class="progress mb-2" role="progressbar"  aria-valuenow="0">-->
  <!--<div id="progress_chat_bar_"   class="progress-bar progress-bar-striped progress-bar-animated bg-success"></div>-->
<!--</div>-->
  <!--         <div id="popup_chat"  >-->
  <!--  <p class="cursor_" style="line-height: 2px;" data-bs-toggle="modal" data-bs-target="#images_popup_chat"  onclick="hide_options_chat('images')"><i class="bi bi-file-image" ></i>&nbsp Images</p>-->
  <!--  <p class="cursor_" style="line-height: 2px;" data-bs-toggle="modal" data-bs-target="#images_popup_chat" onclick="hide_options_chat('docs')" ><i class="bi bi-file-earmark-text"></i>&nbsp Documents</p>-->
  <!--</div>-->
    <div style="display:none" class="row" id="showhidereply" height="15px"><div class="previous_msg" id="previous_msg"></div><button id="btn_close" class="btn-close" onclick="deleteDiv()" style="margin-top: 12px; margin-left: 14px "></button></div>
    <div style="display:none;position:relative;cursor: pointer;" class="row" id="show_img_chat_parent" height="15px"><div class="previous_msg" id="show_img_chat" style="margin-bottom: 3px;"></div>
    <span onclick="store_doc_files_chat()" id="btn_close" style="margin-top: 0px; margin-left: -7px; width: 10%;position: absolute; right: 12%; bottom: 11%;cursor: pointer;"><i style="font-size:30px;color: #28a745;" class="bi bi-arrow-up-circle-fill"></i></span>
    <button id="btn_close_docs" class="btn-close"  style="margin-top: 9px;margin-left: 14px; position: absolute;right: 3%;bottom: 35%;" onclick="hide_show_docs()"></button>
    </div>
     <div style="display:none" class="row" id="show_invalid_files" height="15px"><div style="height:37px;" class="previous_msg text-danger" id="show_invalid_files_msg">Please Select Valid Files</div><button id="btn_close" class="btn-close" onclick="show_invalid_files()" style="margin-top: 2px; margin-left: 14px "></button></div>
  <div class="row ">
      <p id="send_msg_" style="display:none;">Sending...</p>
 <!--<textarea class="form-control form-control-lg p-1 scroll_chat" id="chatbox" max_rows="5" placeholder="Type message" style="font-size: 18px; width: 94%; margin-left: 1px;"></textarea> -->
  <textarea class="form-control  p-1 scroll_chat" rows="1" ondragover="allowDrop_chat(event)"; ondrop="handleDrop_chat(event)";  oninput="autoResize(this)" onpaste="autoResize(this, 'yes')"  id="chatbox" placeholder="Type message"></textarea>
    <label for="chat_file">
  <i class="bi bi-plus" style="font-size: 3rem;cursor: pointer; position: absolute;left: 76.5%;bottom: -7px;"></i>
    </label>  
  <i onclick="chatbox();" class="bi bi-telegram custom_tel cursor_" id="custom_playing_before_trigger"></i>
  
  <div class="m-1" style="display:none;">
             <form id="uploadForm_chat" enctype="multipart/form-data">
             <input type="file" id="chat_file" name="chat_file[]" value="" class="form-control form-control-lg" multiple accept=".jpeg, .png, .jpg,.heic,.mp4,.docs,.pdf,.docx,.xlsx">
                                                                                                                              
              <input type="hidden" id="lastinsertedids_chat" name="lastinsertedids_chat[]" value=""class="form-control form-control-lg" >
             </form>
             <!--<span style="color:rgb(227 53 69);" id="validation_docs_chat"></span>-->
            </div>
              <div class="drag_files_chat" id="show_drag_files_chat">
                      <div class="fs-5" id="title_of_docs_chat">
                         
                   </div>
            </div>
</div>
        </div>
     <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
//   for show active users
       var admin_id_global=$("#admin_id").val();
       var get_Admin_fname=$("#get_Admin_fname").val();
       var base_url=$("#base_url").val();
       
     function show_active_logins(){
        var activeDiv = document.getElementById("show_users");
         
        if (activeDiv.style.display === "none") {
             check_active();
          //activeDiv.style.display = "block";
        } else {
          activeDiv.style.display = "none";
          while (activeDiv.firstChild) {
         activeDiv.removeChild(activeDiv.firstChild);
           }
        }
     }
    
        function click_anywhere_onchat() {
      var activeDiv = document.getElementById("show_users");
          activeDiv.style.display = "none";
           $('#show_users').html('');
          //console.log('sdfkhbvd');
  }

  function hideActiveDiv() {
    var activeDiv = document.getElementById("show_users");
        activeDiv.style.display = "none";
    // Remove all child elements (appended data)
    while (activeDiv.firstChild) {
        activeDiv.removeChild(activeDiv.firstChild);
    }
  }
        function autoResize(textarea, __isPaste = "") {
          hideActiveDiv();
            var chat_length = $("#chatbox").val();
            chat_length = chat_length.length;
            //console.log("Height = ",textarea.scrollHeight);
            //console.log("Lenght = ", chat_length);
           
            if(textarea.scrollHeight != 40){
              // Reset the textarea height to a small value
              textarea.style.height = 'auto';
              //console.log(textarea.scrollHeight);
              if(textarea.scrollHeight >= 147){
                textarea.style.height ='147px';
              }
              else{
                textarea.style.height = (textarea.scrollHeight) + 'px';
              }
            //console.log("run code");
            }
            else{
                textarea.style.height ='40px';
            }
        }
</script>
                   
           
<?php  }?>

   

    </aside>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
var userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

 var chatArea = document.getElementById('chat_area');

if (chatArea) {
    chatArea.addEventListener('scroll', remove_notification_count);
}

 
 function show_options_chat() {
        var popup = document.getElementById('popup_chat');
        popup.style.display = (popup.style.display === 'none' || popup.style.display === '') ? 'block' : 'none';
    }
   
function remove_notification_count() {
    var chatArea = document.getElementById('chat_area');
    if (chatArea) {
        var scrollPosition = chatArea.scrollTop;
        var maxScroll = chatArea.scrollHeight - chatArea.clientHeight;
        var msgCount = document.getElementById('msg_count');

        // Adjust the ratio based on your needs
        var scrollRatio = 0.95; // Example: 90% of the chat_area height

        if (scrollPosition >= maxScroll * scrollRatio) {
            if (msgCount) {
                 new_msg_received = 0;
                // msgCount.style.display = 'none';
                update_chat_aftershownotification();
                 
                //console.log('Message count is hidden.');
            }
        }
    }
}
//check all when page load 
 $(document).ready(function() {
      make_count_area();
      fetchData("","scroll");
      getChatHistory();
      check_count_of_active_users();
      
  var currentURL_ = window.location.href;
  var parts_ = currentURL_.split('/');
  var url_view_edit_ = parts_[7]; // view edit
  var pagetitle = document.querySelector(".pagetitle");
//   var main_ = document.querySelector(".main");
   var main_ = document.getElementById("main");
  if(url_view_edit_ == 'view_edit' || url_view_edit_ == 'all_documents' || url_view_edit_ == 'notes'){
      if(url_view_edit_ == 'notes'){
          main_.style.marginRight="-9px";
      }
  pagetitle.style.marginTop="-7px";  
  }else{
    pagetitle.style.marginTop="10px";
  }
          
                // getCurrentMessageCount();
                
        });
        
        
//scroll use for fetch data------------------   
        $('#chat_area').on('scroll', function () {
            // console.log($(this).scrollTop());
            if ($(this).scrollTop() < 50) {
                previous_date="";
                //daylabel_afterword="";
                // User scrolled to the top of the chat container
                // Load more messages
                setTimeout(() => {  
                    //console.log('World!'); 
                 fetchData("no_store_last_id");
                    
                }, 2000);
            }
        });
        
        
    
// ------------------ for open and closed chat
        const chatCard = document.getElementById("sidebar_right");
        const toggleButton = document.getElementById("toggleButton");
        const avatar = document.getElementById("avatar");
        var activeDiv = document.getElementById("show_users");
        let isChatOpen = false;
        chatCard.style.display = "none";
        
            //toggleButton.addEventListener("click", function() {
            function Closechat(){
                var msg_count = document.getElementById('msg_count');
                 msg_count.style.display = 'none';
                 activeDiv.style.display = "none";
                new_msg_received = 0;
                // Close
                 showSpans();
                 storeHistoryChat('close');
            isChatOpen = !isChatOpen;
            chatCard.style.display = isChatOpen ? "block" : "none";
      //  });
      
      //for update chat 0
      update_chat_aftershownotification();
       
       
}
        //avatar.addEventListener("click", function() {
            // Open
            function openchat(){
            new_msg_received = 0;
            isChatOpen = true;
            chatCard.style.display = "block";
            if(scroll_on_off <= 10 ){
                setTimeout(() => {
                
                $('#chat_area').animate({scrollTop: $('#chat_area')[0].scrollHeight}, 1000);    
            },200);   
            }
             hideSpans();
             storeHistoryChat('open');
            }
        //});
 // ------------------ after click enter send msg     
    var inputElement = document.getElementById('chatbox');
    inputElement.addEventListener('keydown', function(event) {
    if (event.keyCode === 13) { 
        event.preventDefault(); 
        chatbox();
    }
});

// ------------------ check last chat open or not 
function getChatHistory() {
    $.ajax({
        method: "GET",
        url: "<?= base_url("admin/admin_functions/chat_system_getsession") ?>",
        contentType: "application/x-www-form-urlencoded",
        success: function(response) {
            //alert(response.operation);
            if (response.operation == 'open') {
                //alert('open');
            openchat();
            } else {
                //alert('closed');
            // Closechat();
            }
        },
        error: function(error) {
            console.error(error);
            // Handle the error here
        }
    });
}


// ------------------ store session for last chat..
function storeHistoryChat(operation){
  
     $.ajax({
        method: "POST",
        url: "<?= base_url("admin/admin_functions/chat_system_checksession") ?>",
        data: {
            operation
        },
        contentType: "application/x-www-form-urlencoded",
        success: function(response) {
        },
        error: function(error) {
            console.error(error);
        }
    });
 
}
 
// ------------------ this function for insert chat in database after insert show last msg
    function chatbox() {
     var chat =  $("#chatbox").val();
     $("#chatbox").val("");
     var input_resize = document.getElementById("chatbox");
     var previous_msg = document.getElementById('previous_msg');
     var admin_id = admin_id_global;
     var send_msg_ = document.getElementById('send_msg_');
     var currentValue_docs = $('#lastinsertedids_chat').val();
     //console.log(currentValue_docs);
         if(chat.trim() != ''){
        send_msg_.style.display="block";
          }
     if (chat.trim() !== "" || currentValue_docs != "") {
         play_sound_send();
    $.ajax({
        method: "POST",
        url: "<?= base_url("admin/admin_functions/chat_system") ?>",
        data: {
            chat: chat,
            admin_id: admin_id,
            reply_id:reply_id,
            reply_msg_update,
            reply_user_name,
            reply_color,
            docs_ids:currentValue_docs,
            reply_documets,
            reply_documets_path
            
        },
        contentType: "application/x-www-form-urlencoded",
        success: function(response) {
            
            send_msg_.style.display="none";
            
          var jsonResponse = JSON.parse(response);
            if(jsonResponse[0].documents == true || jsonResponse[0].message == true){
            // console.log('dfhsdavfhsdacdhfc');
                // alert('i am here');
                 //return;
                $('#show_drag_files_chat').hide();
                $('#title_of_docs_chat').html('');
                $('#show_img_chat_parent').css({'display':'none'});
                // $('#show_img_chat').text('');
                 $('#chat_file').val('');
                 $('#lastinsertedids_chat').val('');
                   $('#chatbox').css({
                     'border-radius': '10px',
                       });
            }
            
            if(response){
                
                // Reset The Counter
                $("#older_list").html("");
                // End
                
               reply_id='';
               reply_color='';
               reply_msg_update='';
               reply_user_name='';
               reply_documets='';
               reply_documets_path='';
               //fetchData_last(true);
               
               deleteDiv();
              input_resize.value="";
              $('#chat_area').animate({scrollTop: $('#chat_area')[0].scrollHeight}, 0);

                setTimeout(function() {
                  
                   input_resize.style.height="10px";
               
                }, 200); // 2000 
                // $('#title_of_docs_chat').html('');
             }
             
            //  console.log(response.documents);
            //  if (response.documents === true) {
            //      console.log('i am here');
            //      $('#show_drag_files_chat').html('');
                 
            //  }
             //return;
        },
        error: function(error) {
            console.error(error);
            // Handle the error here
            deleteDiv();
              input_resize.value="";
              $('#chat_area').animate({scrollTop: $('#chat_area')[0].scrollHeight}, 0);

                setTimeout(function() {
                  
                   input_resize.style.height="10px";
               
                }, 200); // 2000 
        }
    });
}
}

// ------------------ this function is use for automatic check msg by using per 5 seconds
  // setInterval(function() {
      
      // fetchData_last(false);

//  }, 400);

//  setInterval(function() {
//       make_count_area();
//  }, 500);
 
  // if(typeof(Worker) !== "undefined") {
  //   if(typeof(w) == "undefined") {
  //     w = new Worker("https://at.aqato.com.au/public/worker.js");
  //   }
  //   w.onmessage = function(event) {
  //     // document.getElementById("result").innerHTML = event.data;
  //     console.log("here");
  //     fetchData_last(false);
  //   };
  // } else {
  //   // document.getElementById("result").innerHTML = "Sorry, your browser does not support Web Workers...";
  // }

// ------------------ for delete reply div when user can have to send reply

function deleteDiv() {
    reply_id="";
    reply_msg_update="";
    reply_documets="";
    reply_documets_path="";
   // reply_user_name='';
    //reply_color='';
    var showhidereply = document.getElementById('showhidereply');
    var custom_footer = document.getElementById('custom_footer');
    var chatbox = document.getElementById('chatbox');
    var previousMsg = document.getElementById('previous_msg');

    showhidereply.style.display = 'none';
   // custom_footer.style.height = "63px";
    previousMsg.innerHTML = '';
}


 // ------------------ show reply icon on every chat msg
function showReplyIcon(element) {
    console.log("showReplyIcon");
  var replyIcon = element.querySelector('.custom_style_icon');
  //var deleteIcon = element.querySelector('.custom_style_del');
  var replyIcon_left =  document.getElementById("left_reply");
  if(replyIcon_left){
  replyIcon.style.display = '';
 // deleteIcon.style.display = '';
  replyIcon_left.style.marginTop = '38px';
  }
}


// ------------------ show reply icon on every chat msg
function hideReplyIcon(element) {
  var replyIcon = element.querySelector('.custom_style_icon');
 // var deleteIcon = element.querySelector('.custom_style_del');
   replyIcon.style.display = 'none';
   //deleteIcon.style.display = 'none';
}


// ------------------ This function use for reply the previous chat
var reply_msg_update='';
var reply_msg_;
var reply_user_name='';
var reply_color='';
var reply_id='';
var reply_documets='';
var reply_documets_path='';

function reply_msg(id) {
    console.log('reply msg ' + id);
  var previous_msg = document.getElementById('previous_msg');
  var textarea = document.getElementById('chatbox');
  var showhidereply = document.getElementById('showhidereply');
  var custom_footer = document.getElementById('custom_footer');
  var admin_id=admin_id_global;
  //custom_footer.style.height = "132px";
  showhidereply.style.display = '';
  previous_msg.innerHTML = '';
  $.ajax({
  url: '<?= base_url("admin/admin_functions/chat_system_fetch_reply") ?>',
  method: 'GET',
  data: { id: id },
  success: function(response) {
    if(response){
        if(admin_id == response.user_id){
            var username='You';
            //alert(username);
        }else{
             var username=response.user_name;
        }
         var msg;
         var truncatedMessage;
         var truncateddocuments;
        // console.log(response);
        if(response.message != '' && response.documents == ''){
        truncateddocuments='';    
        truncatedMessage = response.message.length > 35 ? response.message.substring(0,35) + '...' : response.message;
        msg = `<b style="color: ${response.color}; font-size: 13px;">${username}</b> <br> ${truncatedMessage}`;
        $('#previous_msg').append(msg);
        }else{
         truncatedMessage='';
         truncateddocuments = response.documents.length > 30 ? response.documents.substring(0,30) + '...' : response.documents;
         documents_append=`<b style="color: ${response.color}; font-size: 13px;">${username}</b> <br><span style="font-size:19px;">${check_icon_chat(getFileExtension(response.documents))}</span><span style="cursor:pointer;" data-toggle="tooltip" data-placement="top" title="${response.documents}">${truncateddocuments}</span>`;
         $('#previous_msg').append(documents_append);
            
        }
        
     
     //map global var
      reply_id=response.id;
      reply_msg_update=response.message;
      reply_msg_=truncatedMessage;
      reply_user_name=response.user_name;
      reply_color=response.color;
      reply_documets=truncateddocuments;
      reply_documets_path=response.documents_path
      //alert(reply_color);
      console.log('reply_documets-->' + reply_documets + reply_documets_path);
      previous_msg.setAttribute('data-value', currentValue + '');
      var currentValue = parseInt(previous_msg.getAttribute('data-value')) || '';
      previous_msg.setAttribute('data-value', response.id);
      previous_msg.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
      textarea.focus();
    }
  },
  error: function(error) {
    console.error('Error:', error);
  }
});
}

function formatTimestamp_day(timestamp) {
  const options = { day: 'numeric', month: 'short', year: 'numeric' };
  return new Date(timestamp).toLocaleString('en-US', options);
}

// ------------------ this function is for fetch all data 

var offset_record = 0;
var prevoius_offset_record = -1;
var record_fetch = 0;  
var last_msg__id = "";


// make count box
var scroll_on_off;
function make_count_area(){
    var msg_count = document.getElementById('msg_count');
    // console.log('hello');
    // return;
    $.get("<?= base_url("admin/admin_functions/notification_store") ?>",function(res){
        // console.log(res);
        scroll_on_off=res;
        if(res > 0){
           // console.log("notification = ",res);
           $("#msg_count").text(res); 
           $('#msg_count').addClass('bg-danger');
            msg_count.style.display = 'block';
            if(res > 10){
                record_fetch = res;
            }
        }else{
            record_fetch = 10;
           msg_count.style.display = 'none'; 
        }
       // console.log("record_fetch = ",record_fetch);
    });
}


//fetch all data
var previous_date="";
var check_fetch_run = "";
    async function fetchData(no_store_last_id = "", scroll = "") {
        //console.log("from scroll function");
        if(prevoius_offset_record == offset_record){
            //console.log("Same Record");
            return;
        }
        prevoius_offset_record = offset_record;
        //daylabel_afterword_last="";
        // console.log("Feth = ",record_fetch,"offset=>",offset_record);
         try {
     const response = await $.ajax({
            // $.ajax({
                url: '<?= base_url("admin/admin_functions/chat_system_fetch") ?>', 
                method: 'POST',
                data:{
                    userTimezone,
                    record_fetch,
                    offset_record,
                    admin_id:admin_id_global,
                },
            });
            
            console.log(response);
            // return;
            
                 offset_record += record_fetch;
                 //await response;
                   //console.log(<=base_url()?>);
                   var first_record = 0;
                  //var  label_text_date = response[response.length - 1]="";
               response.forEach(function(item) {
                   if(response == null){  
                       return;
                   }
                  // console.log(item);
                  if(first_record == 0){
                      previous_date = item.date_label;
                  }
                  var label_text_date="";
                   if(previous_date != item.date_label){
                         label_text_date = previous_date;
                         previous_date = item.date_label;
                            }
                
                    //console.log(label_text_date);
                        
            //--------------do not touch this code----------//                   
                   if(no_store_last_id == ""){
                       if(first_record == 0){
                       last_msg__id = item.id;
                       //alert(last_msg__id);
                       first_record = 2;
                       }
                   }
                   
                    var user_name_org=item.user_name;
                   if(get_Admin_fname == item.user_name){
                         user_name_org = 'You';
                     }
                   
                   //console.log(item.userid);
                   var reply_change=item.reply_user_name;
                //   console.log("admin_id = ", '<= $get_Admin_fname ?>');
                   
                   //console.log("item = ", user_name_org + item.id + '--->' + get_Admin_fname);
                  if(get_Admin_fname == item.reply_user_name){
                         reply_change = 'You';
                          
                     }
              
            //   if (<= $admin_id ?> == 1) {
            //     delete_chat = `<i onclick="delete_chat(${item.id});" class="bi bi-trash-fill custom_style_del" style="display:none;"></i>`;
            //   }else{
            //       var delete_chat='';
            //   }
            //  console.log(item.reply_user_name);
             //console.log(reply_change);
             var base_=base_url;
             var popup="";
                      var show_action_permission = "";
                        if (admin_id_global == 1) {
                            show_action_permission = `<p class="cursor_" style="line-height: 5px;" onclick="for_delete_message(${item.id})">Delete</p>`;
                        }
            //for global today/yesterday label
            var id=item.id;
            var daylabel='<p id="days_label" class="text-center mx-3 mb-0" style="color: #a2aab7;">'+label_text_date+'</p>';
              // console.log("label=>",daylabel);
              //alert(daylabel #a2aab7);
              //start the dynamic messages/docs chat
             if(item.message != '' && item.documents == '' || (item.reply_documents != '' && item.message != '')){
                  
                  
           if (item.reply_msg != '') {
               //console.log('--->' + item.reply_msg + item.id);
                var truncate_msg = item.reply_msg.length > 35 ? item.reply_msg.substring(0,35) + '...' : item.reply_msg;
               //alert('fdsbgsdf');
        var width = 'width:90%;';
        var para_reply=`background-color: #d9fdd3;border-top-left-radius: 3px;border-top-right-radius: 3px;border-bottom: 0px;
                        margin-left: -1px;`
        var msg_add_left = `
        <div  class="d-flex justify-content-start message-container cursor_" style="margin-left:19px;width: 19rem; margin-top:-15px;margin-bottom: -20px">
        <i onclick="reply_msg(${item.id });" class="bi bi-reply-fill custom_style_icon" style="display:none;"></i>
        <p onclick="goto_up('target'+ ${item.reply_id})" data-target-id="target${item.reply_id}"  class="small p-2 mb-1  mt-3 text-start" style="${para_reply}${width}max-width: 90%;background-color:#d9fdd3;border: 8px solid #f5f6f7;">
            <span class="small d-block text-start" style="font-size: 11px;float:left;font-weight: bold;color:${item.reply_color}">${reply_change}&nbsp;</span>
          <br>  ${truncate_msg}
            </p>
         </div>
           `;
           
           var msg_add_right=`<div  class="d-flex justify-content-end message-container cursor_" style="width: 19rem;margin-left: 53px; margin-top: -14px;  margin-bottom: -20px">
        <i onclick="reply_msg(${item.id });" class="bi bi-reply-fill custom_style_icon" style="display:none;"></i>
        <p onclick="goto_up('target'+ ${item.reply_id})" data-target-id="target${item.reply_id}" class="small p-2 mb-1  mt-3 text-start" style="${para_reply}width:90%;background-color: #e9edefcc;border: 8px solid #d9fdd3;">
            <span class="small d-block text-start" style="font-size: 11px;float:left;font-weight: bold;color:${item.reply_color}">${reply_change}&nbsp;</span>
          <br> ${truncate_msg}
            </p>
         </div>`;
           var border='';
           var border_para_main=`border-bottom-left-radius: 9px;border-bottom-right-radius: 9px;`;
        }else if(item.reply_documents != ''){
            
               var reply_parameter=",'docs'";
                  if(item.reply_documents_path.endsWith('.png') || item.reply_documents_path.endsWith('.jpg') || item.reply_documents_path.endsWith('.jpeg') || item.reply_documents_path.endsWith('.heic')){
                  reply_parameter=",'images'";
                  }
            
          var file_docs_name = getFileExtension(item.reply_documents_path);
          //console.log(file_docs_name + item.id);
          var path = base_.trim()+ "/" + item.reply_documents.trim();
          var truncate_docs = item.reply_documents.length > 23 ? item.reply_documents.substring(0,23) + '...' : item.reply_documents;
               //alert('fdsbgsdf');
        var width = 'width:90%;';
        var para_reply=`background-color: #d9fdd3;border-top-left-radius: 3px;border-top-right-radius: 3px;border-bottom: 0px;
                        margin-left: -1px;`
        var msg_add_left = `
        <div  class="d-flex justify-content-start message-container cursor_" style="margin-left:19px;width: 19rem; margin-top:-15px;margin-bottom: -20px">
        <i onclick="reply_msg(${item.id });"  class="bi bi-reply-fill custom_style_icon" style="display:none;"></i>
        <p onclick="goto_up('docs_reply'+ ${item.reply_id}${reply_parameter})" data-target-id="target${item.reply_id}"  class="small p-2 mb-1  mt-3 text-start" style="${para_reply}${width}max-width: 90%;background-color:#d9fdd3;border: 8px solid #f5f6f7;">
            <span class="small d-block text-start" style="font-size: 11px;float:left;font-weight: bold;color:${item.reply_color}">${reply_change}&nbsp;</span>
          <br><span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon_chat(file_docs_name)}</span>
                <span style="font-size: 15px;" data-toggle="tooltip" data-placement="top" title="${item.reply_documents}">${truncate_docs}</span>
                </p>
         </div>
           `;
           
           var msg_add_right=`<div  class="d-flex justify-content-end message-container cursor_" style="width: 19rem;margin-left: 53px; margin-top: -14px;  margin-bottom: -20px">
        <i onclick="reply_msg(${item.id });" class="bi bi-reply-fill custom_style_icon" style="display:none;"></i>
        <p onclick="goto_up('docs_reply'+ ${item.reply_id}${reply_parameter})" data-target-id="target${item.reply_id}" class="small p-2 mb-1  mt-3 text-start" style="${para_reply}width:90%;background-color: #e9edefcc;border: 8px solid #d9fdd3;">
            <span class="small d-block text-start" style="font-size: 11px;float:left;font-weight: bold;color:${item.reply_color}">${reply_change}&nbsp;</span>
          <br><span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon_chat(file_docs_name)}</span>
                <span  style="font-size: 15px;" data-toggle="tooltip" data-placement="top" title="${item.reply_documents}">${truncate_docs}</span> 
            </p>
         </div>`;
           var border='';
           var border_para_main=`border-bottom-left-radius: 9px;border-bottom-right-radius: 9px;`;  
        }
        else {
            var msg_add_left = '';
            var width = ' ';
            msg_add_right='';
            var border='rounded-3';
            var border_para_main='';
        }
                  
                  
    //  right_div

 var paragraph = `${msg_add_right}
<div  id="target${item.id}"  class="d-flex justify-content-end message-container" style="width: 19rem; margin-left: 53px; margin-top: -7px;" onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
   
  <i onclick="reply_msg(${item.id});" class="bi bi-reply-fill custom_style_icon" style="display:none;"></i>
  <p  class="small p-2 mb-1 ${border} mt-2 text-start cursor_" style="${width}${border_para_main}max-width: 90%;background-color:#d9fdd3;"> ${item.message}
    <span class="small d-block text-end" style="font-size: 10px; margin-left: auto; font-style: bold;">
      <i>${formatTimestamp(item.created_at)}</i>
    </span>
  </p>
</div>
   ${daylabel}
   `;
    
               
    // divleft
                var paragraph_ = `    ${msg_add_left}
                
      <div   id="target${item.id }" class="d-flex justify-content-start message-container" style="margin-left: -12px;width: 19rem; margin-top:-15px;position:relative;" onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
      <img   src="${base_}${item.profileimg_path}"alt="avatar 1" style="width: 30px;height: 30px;margin-top: 19px; border-radius: 25px;" ROHIT>  
        <p  class="${border} small p-2  mb-1  mt-3 text-start cursor_" style="${width}${border_para_main}background-color: #f5f6f7;max-width: 90%;">
         <span class="small d-block text-start" style="font-size: 11px; margin-left: auto;font-weight: bold;color:${item.color};">${item.user_name}</span>
        ${item.message }<br><i class="ms-2" style="float: right;font-size: 10px;">${formatTimestamp(item.created_at)}</i></p>
         <i onclick="reply_msg(${item.id });" id="left_reply" class="bi bi-reply-fill custom_style_icon" style="display:none;margin-right: -27px;"></i>
        
      </div> ${daylabel}
    `;
                    
        var wrapper_reply_start = `<div class="wrapper_parent_reply">`;
        var wrapper_reply_end = `</div>`;
        
        
             }else if(item.message != '' && item.documents != ''){
            
           
            var wrapper_reply_start = `<div class="wrapper_parent_reply" onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)" >`;
            var wrapper_reply_end = `</div>`;
            var file_docs_name = getFileExtension(item.documents);
            var path = base_url+ "/" + item.documents_path;
            var doc_name_show = item.documents.length > 50 ? item.documents.substring(0,50) + '...' : item.documents;
            popup=`right: 64px;top: -10px;padding: 11px 3px 0px 8px;`;
             
             var paragraph=`    <div RP id="target_${item.id}" class="message-container" style="margin: 12px 26px -6px 32px;  max-width: 91%; min-width: 91%;" onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
                <div id="text_area${item.id}" class="d-flex position-relative justify-content-end">
                <i onclick="reply_msg(${item.id});" class="bi bi-reply-fill custom_style_icon" style="display:none;position: absolute;left: 0px;top: -20px;"></i>
                    <div id="target_${item.id}" class="d-flex align-items-center" style="border: 2px solid #d9ecd6;/* border-radius: 10px; */padding-left: 6px;padding-top: 5px;background: #d9fdd3;position: relative;width: 296px;border-top-left-radius: 10px;border-top-right-radius: 10px;/* margin-left: 0px; */margin-right: 2px;">
                        <span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon_chat(file_docs_name)}</span>
                        <p data-toggle="tooltip" data-placement="top" title="${item.documents}" class="d-inline font-weight-bold mr-3" style="width: auto; width: 84%; margin-top: 9px; margin-left: 6px; overflow: hidden; text-overflow: ellipsis; padding-right: 5px;">
                            <a href="${path}" target="_blank">${doc_name_show}</a><br>
                            
                        </p>
                        <span class="d-inline" style="font-size: 28px; margin-top: -8px; margin-right: 9px; color: #918b8b;">
                            <a href="${path}" download="${item.documents}">
                                <i class="bi bi-arrow-down-circle"></i>
                            </a>
                        </span>
                    </div>
                    
                </div> 
                <div id="target${item.id}" style="margin: -2px 26px 8px 28px;max-width: 91%;min-width: 91%;border: 2px solid #d9ecd6;padding-left: 6px;padding-top: 5px;background: #d9fdd3;position: relative;border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;"> ${item.message} <i class="ms-2" style="float: right; font-size: 10px; position: absolute; right: 7px; bottom: 2px;">${formatTimestamp(item.created_at)}</i></div>
            </div>`;
            
            
                var paragraph_=`    <div id="target${item.id}" class="message-container" style="margin: 2px 0px -5px -14px; max-width: 91%; min-width: 91%;" onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
                <div id="text_area${item.id}" class="d-flex position-relative justify-content-start">
                <img   src="${base_}${item.profileimg_path}"alt="avatar 1" style="width: 30px;height: 30px;margin-top: 6px; border-radius: 25px;">  
                    <div id="target${item.id}" class="d-flex align-items-center" style="border: 2px solid #c8c8c8;/* border-radius: 10px; */padding-left: 6px;padding-top: 5px;background: #f5f6f7;position: relative;width: 296px;border-top-left-radius: 10px;border-top-right-radius: 10px;/* margin-left: 0px; */margin-right: 2px;">
                        <span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon_chat(file_docs_name)}</span>
                        <p data-toggle="tooltip" data-placement="top" title="${item.documents}" class="d-inline font-weight-bold mr-3" style="width: auto; width: 84%; margin-top: 9px; margin-left: 6px; overflow: hidden; text-overflow: ellipsis; padding-right: 5px;">
                            <a href="${path}" target="_blank">${doc_name_show}</a><br>
                            
                        </p>
                        <span class="d-inline" style="font-size: 28px; margin-top: -8px; margin-right: 9px; color: #918b8b;">
                            <a href="${path}" download="${item.documents}">
                                <i class="bi bi-arrow-down-circle"></i>
                            </a>
                        </span>
                    </div>
                     <i onclick="reply_msg(${item.id});" class="bi bi-reply-fill custom_style_icon" style="display:none;position: absolute;top: -23px;right: -28px;"></i>
                </div> 
                <div id="target${item.id}" style="margin: -2px 26px 8px 30px;max-width: 90.2%;min-width: 90.2%;border: 2px solid #c8c8c8;padding-left: 6px;padding-top: 5px;background: #f5f6f7;position: relative;border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;"> ${item.message} <i class="ms-2" style="float: right; font-size: 10px; position: absolute; right: 7px; bottom: 2px;">${formatTimestamp(item.created_at)}</i></div>
            </div>`;
            
           
             }
             else if(item.reply_documents != '' && item.documents  != ''){
                 
              // console.log('reply_docs else if --->' + item.reply_documents + item.id);
               //rohit_doc
               
             
               if(item.reply_documents){
                var file_docs_name = getFileExtension(item.reply_documents_path);
                var file_docs_name_org = getFileExtension(item.documents);
                var path = base_.trim()+ "/" + item.reply_documents.trim();
                var truncate_docs = item.reply_documents.length > 25 ? item.reply_documents.substring(0,25) + '...' : item.reply_documents;
                var truncate_docs_org = item.documents.length > 50 ? item.documents.substring(0,50) + '...' : item.documents;

               //alert('fdsbgsdf');
                var width_upper_container_image_right='width: 19rem;margin-left: 53px;';
                var width_upper_container_image_left='margin-left:19px;width: 19rem;';
                var reply_parameter=",'docs'";
                  if(item.documents.endsWith('.png') || item.documents.endsWith('.jpg') || item.documents.endsWith('.jpeg') || item.documents.endsWith('.heic')){
                  reply_parameter=",'images'";
                  width_upper_container_image_right=' width: 14rem;margin-left: 131px;';
                  width_upper_container_image_left='margin-left:19px;width: 14rem;';
                  truncate_docs = item.reply_documents.length > 15 ? item.reply_documents.substring(0,15) + '...' : item.reply_documents;
                  }
               console.log(reply_parameter + item.documents);
            //   return;
        var width = 'width:90%;';
        var para_reply=`background-color: #d9fdd3;border-top-left-radius: 3px;border-top-right-radius: 3px;border-bottom: 0px;
                        margin-left: -1px;`
        var msg_add_left = `
        <div  class="d-flex justify-content-start message-container cursor_" style="${width_upper_container_image_left} margin-top:-15px;margin-bottom: -20px">
        <i onclick="reply_msg(${item.id });" class="bi bi-reply-fill custom_style_icon" style="display:none;"></i>
        <p onclick="goto_up('docs_reply'+ ${item.reply_id}${reply_parameter})" data-target-id="target${item.reply_id}"  class="small p-2 mb-1  mt-3 text-start" style="${para_reply}${width}max-width: 90%;background-color:#d9fdd3;border: 8px solid #f5f6f7;">
            <span class="small d-block text-start" style="font-size: 11px;float:left;font-weight: bold;color:${item.reply_color}">${reply_change}&nbsp;</span>
          <br><span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon_chat(file_docs_name)}</span>
                <span style="font-size: 15px;" data-toggle="tooltip" data-placement="top" title="${item.reply_documents}">${truncate_docs}</span>
                </p>
         </div>
           `;
           
           var msg_add_right=`<div  class="d-flex justify-content-end message-container cursor_" style="${width_upper_container_image_right} margin-top: -14px;  margin-bottom: -20px">
        <i onclick="reply_msg(${item.id });" class="bi bi-reply-fill custom_style_icon" style="display:none;"></i>
        <p onclick="goto_up('docs_reply'+ ${item.reply_id}${reply_parameter})" data-target-id="target${item.reply_id}" class="small p-2 mb-1  mt-3 text-start" style="${para_reply}width:90%;background-color: #e9edefcc;border: 8px solid #d9fdd3;">
            <span class="small d-block text-start" style="font-size: 11px;float:left;font-weight: bold;color:${item.reply_color}">${reply_change}&nbsp;</span>
          <br><span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon_chat(file_docs_name)}</span>
                <span  style="font-size: 15px;" data-toggle="tooltip" data-placement="top" title="${item.reply_documents}">${truncate_docs}</span> 
            </p>
         </div>`;
           var border='';
           var border_para_main=`border-bottom-left-radius: 9px;border-bottom-right-radius: 9px;`;  
        }
        else {
            var msg_add_left = '';
            var width = ' ';
            msg_add_right='';
            var border='rounded-3';
            var border_para_main='';
        }
                  
    //when image reply with image 
    if(item.documents.endsWith('.png') || item.documents.endsWith('.jpg') || item.documents.endsWith('.jpeg') || item.documents.endsWith('.heic')){
          
                var file_docs_name = getFileExtension(item.documents);
                var file_docs_name_org = getFileExtension(item.documents);
                var path = base_.trim()+ "/" + item.documents_path.trim();
                var truncate_docs = item.documents.length > 25 ? item.documents.substring(0,25     ) + '...' : item.documents;
                var truncate_docs_org = item.documents.length > 50 ? item.documents.substring(0,50) + '...' : item.documents;
          
          
         // console.log('reply docs--->' + item.documents_path + item.id);
              var paragraph = `${msg_add_right}
           
    <div Rohit_img_with_img id="target${item.id}"  class="d-flex justify-content-end message-container" style="margin-left: 131px;margin-top: -7px;position: relative;width: 63%;" onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
       
      <i onclick="reply_msg(${item.id});" class="bi bi-reply-fill custom_style_icon" style="display:none;position:absolute;top:50%;left:0;"></i>
      
      <div  class="small p-2 mb-1 ${border} mt-2 text-start cursor_" style="${width}${border_para_main}max-width: 90%;background-color:#d9fdd3;"> 
       <span class="small d-block text-start" style="font-size: 11px;float:left;font-weight: bold;color:${item.color}">${user_name_org}&nbsp;</span>
          <br>
          <div class="row">
      <div class="col-8"><span style="font-size: 15px;margin-left: -2px;" data-toggle="tooltip" data-placement="top" title="${item.documents}"><a href="${path}" target="_blank"><img id="docs_reply${item.id}"  src="${path}" width="191px" height="145px" style="border: 2px solid #c8c8c8;border-radius: 10px;position:relative;"></a></span></div>
                      </span></div>
          </div>
        <i class="ms-2" style="float: right;font-size: 10px;position: absolute;bottom: 14px;left: 74%;color:black;">${formatTimestamp(item.created_at)}</i></p>
                </div>
        
      </p>
    </div>
       ${daylabel}
       `;
    
               
    // divleft for message to docs
                var paragraph_ = `${msg_add_left}
           
    <div Rohit_img_with_img  id="target${item.id}"  class="d-flex justify-content-end message-container" style="margin-left: -5px;margin-top: -7px;position: relative;width: 63%;;" onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
        <img   src="${base_}${item.profileimg_path}"alt="avatar 1" style="width: 30px;height: 30px;margin-top: 19px; border-radius: 25px;">  
      <i onclick="reply_msg(${item.id});" class="bi bi-reply-fill custom_style_icon" style="display:none;position: absolute;top: 50%;right: -25px;"></i>
      
      <div  class="small p-2 mb-1 ${border} mt-2 text-start cursor_" style="${width}${border_para_main}max-width: 90%;background-color:#f5f6f7;"> 
       <span class="small d-block text-start" style="font-size: 11px;float:left;font-weight: bold;color:${item.color}">${user_name_org}&nbsp;</span>
          <br>
          <div class="row">
      <div class="col-8"><span style="font-size: 15px;margin-left: -2px;" data-toggle="tooltip" data-placement="top" title="${item.documents}"><a href="${path}" target="_blank"><img id="docs_reply${item.id}"  src="${path}" width="191px" height="145px" style="border: 2px solid #c8c8c8;border-radius: 10px;position:relative;"></a></span></div>
                      </span></div>
          </div>
        <i class="ms-2" style="float: right;font-size: 10px;position: absolute;bottom: 14px;left: 74%;color:black;">${formatTimestamp(item.created_at)}</i></p>
                </div>
        
      </p>
    </div>
       ${daylabel}
       `;
            }
            
            else{
        //  right_div for docs to docs
    //console.log(check_icon_chat(file_docs_name)+ item.id);
     var paragraph = `${msg_add_right}
    <div  id="target${item.id}"  class="d-flex justify-content-end message-container" style="width: 19rem; margin-left: 53px; margin-top: -7px;" onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
       
      <i onclick="reply_msg(${item.id});" class="bi bi-reply-fill custom_style_icon" style="display:none;"></i>
      
      <div id="docs_reply${item.id}"  class="small p-2 mb-1 ${border} mt-2 text-start cursor_" style="${width}${border_para_main}max-width: 90%;background-color:#d9fdd3;"> 
       <span class="small d-block text-start" style="font-size: 11px;float:left;font-weight: bold;color:${item.color}">${user_name_org}&nbsp;</span>
          <br>
          <div class="row">
          <div class="col-2"><span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon_chat(file_docs_name_org)}</span></div>
          <div class="col-8 text-start"><div style="font-size: 15px;margin-top:11px;" data-toggle="tooltip" data-placement="top" title="${item.documents}"><a href="${path}" target="_blank">${truncate_docs_org}</a></div></div>
          <div class="col-2"><span class="d-inline" style="font-size: 28px;margin-top: 0px;margin-right: 9px;color: #918b8b;float: right;">
                    <a href="${path}" download="${path}">
                        <i class="bi bi-arrow-down-circle text-dark"></i>
                    </a>
                    </span></div>
          </div>
        <i class="ms-2" style="float: right;font-size: 10px;">${formatTimestamp(item.created_at)}</i></p>
                </div>
        
      </p>
    </div>
       ${daylabel}
       `;
    
               
    // divleft for docs to docs
                var paragraph_ = `    ${msg_add_left}
                
      <div   id="target${item.id }" class="d-flex justify-content-start message-container" style="margin-left: -12px;width: 19rem; margin-top:-15px;position: relative;" onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
      <img   src="${base_}${item.profileimg_path}"alt="avatar 1" style="width: 30px;height: 30px;margin-top: 19px; border-radius: 25px;">  
        <div id="docs_reply${item.id}"  style="${width}${border_para_main}background-color: #f5f6f7;max-width: 90%;">
        <p  class="${border} small p-2 mb-1 text-start cursor_" >
         <span class="small d-block text-start" style="font-size: 11px; margin-left: auto;font-weight: bold;color:${item.color};">${user_name_org}</span>
      </p>
      <div class="row " style="margin-top:-12px;">
      <div class="col-2 " style="font-size: 28px;"> <span style="margin-left:5px;">${check_icon_chat(file_docs_name_org)}</span></div>
      <div class="col-8"><span style="font-size: 15px;" data-toggle="tooltip" data-placement="top" title="${item.documents}"><a href="${path}" target="_blank">${truncate_docs_org}</a></span></div>
      <div class="col-2 "><span class="d-inline" style="font-size: 28px;color: #918b8b;float: right;margin-right: 9px;">
                    <a href="${path}" download="${item.documents}">
                        <i class="bi bi-arrow-down-circle text-dark"></i>
                    </a>
                </span> </div>
                          
      </div>    
        <i class="ms-2" style="float: right;font-size: 10px;">${formatTimestamp(item.created_at)}</i>
          </div>
         <i onclick="reply_msg(${item.id });" id="left_reply" class="bi bi-reply-fill custom_style_icon" style="display:none;position: absolute;right: -26px;"></i>
      </div> ${daylabel}
    `;
            }
            
            //end doc with docs
        var wrapper_reply_start = `<div class="wrapper_parent_reply" style="margin-bottom:5px;">`;
        var wrapper_reply_end = `</div>`;
        
        
             }
             else if(item.reply_msg != '' && item.documents  != ''){

               var width_upper_container="";
               var margin_for_upper_container="margin-left: 53px;";
                if(item.documents.endsWith('.png') || item.documents.endsWith('.jpg') || item.documents.endsWith('.jpeg') || item.documents.endsWith('.heic')){
                width_upper_container='width:63%;';
                margin_for_upper_container='margin-left: 131px;';
                    
                }

                //message reply with docs/images
                var file_docs_name = getFileExtension(item.documents);
                var file_docs_name_org = getFileExtension(item.documents);
                var path = base_.trim()+ "/" + item.documents_path.trim();
                var truncate_docs = item.documents.length > 25 ? item.documents.substring(0,25     ) + '...' : item.documents;
                var truncate_docs_org = item.documents.length > 50 ? item.documents.substring(0,50) + '...' : item.documents;
                 
                     if (item.reply_msg != '') {
             //  console.log('--->' + item.reply_msg + item.id);
                var truncate_msg = item.reply_msg.length > 35 ? item.reply_msg.substring(0,35) + '...' : item.reply_msg;
               //alert('fdsbgsdf');
       
        var width = 'width:90%;';
        var para_reply=`background-color: #d9fdd3;border-top-left-radius: 3px;border-top-right-radius: 3px;border-bottom: 0px;
                        margin-left: -1px;`
        var msg_add_left = `
        <div  class="d-flex justify-content-start message-container cursor_" style="margin-left:19px;width: 19rem; margin-top:-15px;margin-bottom: -20px;${width_upper_container}">
        <i onclick="reply_msg(${item.id });" class="bi bi-reply-fill custom_style_icon" style="display:none;"></i>
        <p onclick="goto_up('target'+ ${item.reply_id})" data-target-id="target${item.reply_id}"  class="small p-2 mb-1  mt-3 text-start" style="${para_reply}${width}max-width: 90%;background-color:#d9fdd3;border: 8px solid #f5f6f7;">
            <span class=" cursor_ small d-block text-start" data-toggle="tooltip" data-placement="top" title="${item.reply_msg}" style="font-size: 11px;float:left;font-weight: bold;color:${item.reply_color}">${reply_change}&nbsp;</span>
          <br>  ${truncate_msg}
            </p>
         </div>
           `;
           
           var msg_add_right=`<div class="d-flex justify-content-end message-container cursor_" style="width: 19rem; margin-top: -14px;  margin-bottom: -20px;${width_upper_container} ${margin_for_upper_container}">
        <i onclick="reply_msg(${item.id });" class="bi bi-reply-fill custom_style_icon" style="display:none;"></i>
        <div onclick="goto_up('target'+ ${item.reply_id})" data-target-id="target${item.reply_id}" class="small p-2 mb-1  mt-3 text-start" style="${para_reply}width:90%;background-color: #e9edefcc;border: 8px solid #d9fdd3;">
            <span data-toggle="tooltip" data-placement="top" title="${item.reply_msg}"  class="cursor_ small d-block text-start" style="font-size: 11px;float:left;font-weight: bold;color:${item.reply_color}">${reply_change}&nbsp;</span>
          <br> ${truncate_msg}
            </div>
         </div>`;
           var border='';
           var border_para_main=`border-bottom-left-radius: 9px;border-bottom-right-radius: 9px;`;
        }
        else {
            var msg_add_left = '';
            var width = ' ';
            msg_add_right='';
            var border='rounded-3';
            var border_para_main='';
        }

     //return;
           
               //  right_div for message to docs
       if(item.documents.endsWith('.png') || item.documents.endsWith('.jpg') || item.documents.endsWith('.jpeg') || item.documents.endsWith('.heic')){
           
           var paragraph = `${msg_add_right}
           
    <div  id="target${item.id}"  class="d-flex justify-content-end message-container" style="margin-left: 131px;margin-top: -7px;position: relative;width: 63%;;" onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
       
      <i onclick="reply_msg(${item.id});" class="bi bi-reply-fill custom_style_icon" style="display:none;position:absolute;top:50%;left:0;"></i>
      
      <div  class="small p-2 mb-1 ${border} mt-2 text-start cursor_" style="${width}${border_para_main}max-width: 90%;background-color:#d9fdd3;"> 
       <span class="small d-block text-start" style="font-size: 11px;float:left;font-weight: bold;color:${item.color}">${user_name_org}&nbsp;</span>
          <br>
          <div class="row">
      <div class="col-8"><span style="font-size: 15px;margin-left: -2px;" data-toggle="tooltip" data-placement="top" title="${item.documents}"><a href="${path}" target="_blank"><img id="docs_reply${item.id}" src="${path}" width="191px" height="145px" style="border: 2px solid #c8c8c8;border-radius: 10px;position:relative;"></a></span></div>
                      </span></div>
          </div>
        <i class="ms-2" style="float: right;font-size: 10px;position: absolute;bottom: 14px;left: 74%;color:black;">${formatTimestamp(item.created_at)}</i></p>
                </div>
        
      </p>
    </div>
       ${daylabel}
       `;
    
               
    // divleft for message to docs
                var paragraph_ = `${msg_add_left}
           
    <div  id="target${item.id}"  class="d-flex justify-content-end message-container" style="margin-left: -5px;margin-top: -7px;position: relative;width: 63%;;" onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
        <img   src="${base_}${item.profileimg_path}"alt="avatar 1" style="width: 30px;height: 30px;margin-top: 19px; border-radius: 25px;">  
      <i onclick="reply_msg(${item.id});" class="bi bi-reply-fill custom_style_icon" style="display:none;position: absolute;top: 50%;right: -25px;"></i>
      
      <div  class="small p-2 mb-1 ${border} mt-2 text-start cursor_" style="${width}${border_para_main}max-width: 90%;background-color:#f5f6f7;"> 
       <span class="small d-block text-start" style="font-size: 11px;float:left;font-weight: bold;color:${item.color}">${user_name_org}&nbsp;</span>
          <br>
          <div class="row">
      <div class="col-8"><span style="font-size: 15px;margin-left: -2px;" data-toggle="tooltip" data-placement="top" title="${item.documents}"><a href="${path}" target="_blank"><img id="docs_reply${item.id}" src="${path}" width="191px" height="145px" style="border: 2px solid #c8c8c8;border-radius: 10px;position:relative;"></a></span></div>
                      </span></div>
          </div>
        <i class="ms-2" style="float: right;font-size: 10px;position: absolute;bottom: 14px;left: 74%;color:black;">${formatTimestamp(item.created_at)}</i></p>
                </div>
        
      </p>
    </div>
       ${daylabel}
       `;
    
           
           
       }else{
           
     var paragraph = `${msg_add_right}
    <div  id="target${item.id}"  class="d-flex justify-content-end message-container" style="width: 19rem; margin-left: 53px; margin-top: -7px;" onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
       
      <i onclick="reply_msg(${item.id});" class="bi bi-reply-fill custom_style_icon" style="display:none;"></i>
      
      <div id="docs_reply${item.id}" class="small p-2 mb-1 ${border} mt-2 text-start cursor_" style="${width}${border_para_main}max-width: 90%;background-color:#d9fdd3;"> 
       <span class="small d-block text-start" style="font-size: 11px;float:left;font-weight: bold;color:${item.color}">${user_name_org}&nbsp;</span>
          <br>
          <div class="row">
          <div class="col-2"><span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon_chat(file_docs_name_org)}</span></div>
          <div class="col-8 text-start"><div style="font-size: 15px;margin-top:11px;" data-toggle="tooltip" data-placement="top" title="${item.documents}"><a href="${path}" target="_blank">${truncate_docs_org}</a></div></div>
          <div class="col-2"><span class="d-inline" style="font-size: 28px;margin-top: 0px;margin-right: 9px;color: #918b8b;float: right;">
                    <a href="${path}" download="${path}">
                        <i class="bi bi-arrow-down-circle text-dark"></i>
                    </a>
                    </span></div>
          </div>
        <i class="ms-2" style="float: right;font-size: 10px;">${formatTimestamp(item.created_at)}</i></p>
                </div>
        
      </p>
    </div>
       ${daylabel}
       `;
    
               
    // divleft for message to docs
                var paragraph_ = `    ${msg_add_left}
                
      <div   id="target${item.id }" class="d-flex justify-content-start message-container" style="margin-left: -12px;width: 19rem; margin-top:-15px;position: relative;" onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
      <img   src="${base_}${item.profileimg_path}"alt="avatar 1" style="width: 30px;height: 30px;margin-top: 19px; border-radius: 25px;">  
        <div id="docs_reply${item.id}" style="${width}${border_para_main}background-color: #f5f6f7;max-width: 90%;">
        <p  class="${border} small p-2 mb-1 text-start cursor_" >
         <span class="small d-block text-start" style="font-size: 11px; margin-left: auto;font-weight: bold;color:${item.color};">${user_name_org}</span>
      </p>
      <div class="row " style="margin-top:-12px;">
      <div class="col-2 " style="font-size: 28px;"> <span style="margin-left:5px;">${check_icon_chat(file_docs_name_org)}</span></div>
      <div class="col-8"><span style="font-size: 15px;" data-toggle="tooltip" data-placement="top" title="${item.documents}"><a href="${path}" target="_blank">${truncate_docs_org}</a></span></div>
      <div class="col-2 "><span class="d-inline" style="font-size: 28px;color: #918b8b;float: right;margin-right: 9px;">
                    <a href="${path}" download="${item.documents}">
                        <i class="bi bi-arrow-down-circle text-dark"></i>
                    </a>
                </span> </div>
                          
      </div>    
        <i class="ms-2" style="float: right;font-size: 10px;">${formatTimestamp(item.created_at)}</i>
          </div>
         <i onclick="reply_msg(${item.id });" id="left_reply" class="bi bi-reply-fill custom_style_icon" style="display:none;position: absolute;right: -26px;"></i>
      </div> 
      <br>
      ${daylabel}
    `;
             
       }       
       
        var wrapper_reply_start = `<div class="wrapper_parent_reply" style="margin-bottom:5px;">`;
        var wrapper_reply_end = `</div>`;
        
             
             
                 
                 
                 
             }
             else{
                 
             
                  var wrapper_reply_start = ``;
                  var wrapper_reply_end = ``;
                //  console.log(base_);
                  var file_docs_name = getFileExtension(item.documents);
                  var path = base_.trim()+ "/" + item.documents_path.trim();
                 // console.log(path);
                   popup=`right: 64px;top: -10px;padding: 11px 3px 0px 8px;`;
                    var doc_name_show = item.documents.length > 46 ? item.documents.substring(0,46) + '...' : item.documents;
                    
                     //console.log(item);
                    if(item.documents.endsWith('.png') || item.documents.endsWith('.jpg') || item.documents.endsWith('.jpeg') || item.documents.endsWith('.heic')){
                                            //for same user
                   var paragraph = `
        <div id="target${item.id}" class="message-container" style="margin: -7px 0px 6px 32px; max-height: 150px; max-width: 91%; min-width: 91%;"onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
           
            <div id="text_area${item.id}" class="d-flex position-relative justify-content-end">
            <i onclick="reply_msg(${item.id});" class="bi bi-reply-fill  custom_style_icon" style="display:none;"></i>
                <div  class="d-flex align-items-center" style="padding-top: 5px; position: relative; ">
                      <a data-toggle="tooltip" data-placement="top" title="${item.documents}" href="${path}"  target="_blank" >
                            <img id="docs_reply${item.id}"  src="${path}" width="191px" height="145px" style="border: 2px solid #c8c8c8;border-radius: 10px;"></a>
        <i class="ms-2" style="float: right; font-size: 10px; position: absolute; right: 7px; bottom: 2px;color:white;">${formatTimestamp(item.created_at)}</i>

                </div>
            </div> 
        </div>
`;
//for diffrent uset
                   var paragraph_ = `
                    
                    <div id="target${item.id}" class="message-container" style="margin: -1px 0px 8px -14px; max-height: 150px; max-width: 91%; min-width: 91%;"onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
                        <div id="text_area${item.id}" class="d-flex position-relative justify-content-start">
                        <img   src="${base_}${item.profileimg_path}"alt="avatar 1" style="width: 30px;height: 30px;margin-top: 6px; border-radius: 25px;">  
                            <div  class="d-flex align-items-center" style="padding-top: 5px; position: relative; ">
                                  <a data-toggle="tooltip" data-placement="top" title="${item.documents}" href="${path}"  target="_blank" >
                                        <img id="docs_reply${item.id}" src="${path}" width="191px" height="145px" style="border: 2px solid #c8c8c8;border-radius: 10px;"></a>
                                <i class="ms-2" style="float: right; font-size: 10px; position: absolute; right: 7px; bottom: 2px;color:white;">${formatTimestamp(item.created_at)}</i>
                            </div>
                            <i onclick="reply_msg(${item.id});" class="bi bi-reply-fill custom_style_icon" style="display:none;"></i>
                        </div> 
                    </div>
                `;
                                    }else{
                    
                    //for same user
                   var paragraph = `
    <div id="target${item.id}" class="message-container" style="margin: 5px 26px 8px 32px; max-height: 150px; max-width: 91%; min-width: 91%;"onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
        <div id="text_area${item.id}" class="d-flex position-relative justify-content-end">
        <i onclick="reply_msg(${item.id});" class="bi bi-reply-fill custom_style_icon" style="display:none;position: absolute;left: 0px;top: -20px;"></i>
            <div id="docs_reply${item.id}" class="d-flex align-items-center" style="border: 2px solid #d9ecd6; border-radius: 10px; padding-left: 6px; padding-top: 5px; background: #d9fdd3; position: relative; width: 300px;">
                <span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon_chat(file_docs_name)}</span>
                <p data-toggle="tooltip" data-placement="top" title="${item.documents}" class="d-inline font-weight-bold mr-3" style="width: auto; width: 84%; margin-top: 9px; margin-left: 6px; overflow: hidden; text-overflow: ellipsis; padding-right: 5px;">
                    <a href="${path}" target="_blank">${doc_name_show}</a><br>
                    <i class="ms-2" style="float: right; font-size: 10px; position: absolute; right: 7px; bottom: 2px;">${formatTimestamp(item.created_at)}</i>
                </p>
                <span class="d-inline" style="font-size: 28px; margin-top: -8px; margin-right: 9px; color: #918b8b;">
                    <a href="${path}" download="${item.documents}">
                        <i class="bi bi-arrow-down-circle text-dark"></i>
                    </a>
                </span>
            </div>
        </div> 
    </div>
`;
//for diffrent uset
                   var paragraph_ = `
                    
    <div id="target${item.id}" class="message-container" style="margin: 5px 26px 8px -14px; max-height: 97px; max-width: 91%; min-width: 91%;"onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
        <div id="text_area${item.id}" class="d-flex position-relative justify-content-start">
        <img   src="${base_}${item.profileimg_path}"alt="avatar 1" style="width: 30px;height: 30px;margin-top: 6px; border-radius: 25px;">  
            <div id="docs_reply${item.id}" class="d-flex align-items-center" style="border: 2px solid #cbcbcb; border-radius: 10px; padding-left: 6px; padding-top: 5px; background: #f5f6f7; position: relative; width: 300px;">
                <span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon_chat(file_docs_name)}</span>
                <p data-toggle="tooltip" data-placement="top" title="${item.documents}" class="d-inline font-weight-bold mr-3" style="width: auto; width: 84%; margin-top: 9px;overflow: hidden; text-overflow: ellipsis; padding-right: 5px;">
                    <a href="${path}" target="_blank">${doc_name_show}</a><br>
                    <i class="ms-2" style="float: right; font-size: 10px;position: absolute; right: 7px; bottom: 2px;">${formatTimestamp(item.created_at)}</i>
                </p>
                <i onclick="reply_msg(${item.id});" class="bi bi-reply-fill custom_style_icon" style="display:none;position: absolute;top: -23px;right: -28px;"></i>
                <span class="d-inline" style="font-size: 28px; margin-top: -8px; margin-right: 9px; color: #918b8b;">
                    <a href="${path}" download="${item.documents}">
                        <i class="bi bi-arrow-down-circle text-dark"></i>
                    </a>
                </span>
            </div>
        </div> 
    </div>
`;


                    }           
             
        }
        
        //this is for normal images/docs/videos
       // console.log("Here", item);
       // console.log(item.user_id+"=="+admin_id_global);
       
                  if (item.user_id == admin_id_global) {
                            $('#result_oponent').prepend(wrapper_reply_start+paragraph+wrapper_reply_end);
                            
                        } else {
                            $('#result_oponent').prepend(wrapper_reply_start+paragraph_+wrapper_reply_end);
                        }
                        
       
       first_record++;
       //console.log(previous_date  +'--->'+label_text_date);
     });
     
      var daylabel_afterword='<p id="days_label" class="text-center mx-3 mb-0" style="color: #a2aab7;">'+previous_date+'</p>';
      $('#result_oponent').prepend(daylabel_afterword);
      check_fetch_run = "yes";
      console.log("HHerees");
      // Fetching
      fetchData_last(false);
      console.log("Scrolling toward down");
      // End

      previous_date = "";
      if(scroll != ""){
         // console.log('scrolling');
          $('#chat_area').animate({scrollTop: $('#chat_area')[0].scrollHeight},0);
      }


       } catch (error) {
      console.error(error.responseText);
  }
    }   
        
//--------------------------------delete chat by super admin
// function delete_chat(id){
//       $.ajax({
//         method: "POST",
//         url: "<= base_url("admin/admin_functions/delete_chat_") ?>",
//         data: {
//             id
//         },
//         contentType: "application/x-www-form-urlencoded",
//         success: function(response) {
//             if(response){
//             }
    
//         },
//         error: function(error) {
//             console.error(error);
//             // Handle the error here
//         }
//     });
// }
// ------------------convert time to am pm
function formatTimestamp(timestamp) {
            var date = new Date(timestamp);
            //console.log(date);
            var timeString = date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            return timeString;
        }
        
// ----------------->fetch data by lastinsertedid<-----------------     
   var new_msg_received = 0;
   var daylabel_afterword_last="";

  //  Start
  let fetchDataRunning = false;

  async function fetchData_last(sendByUser = true) {

    if (fetchDataRunning) {
        // If fetchData_last is already running, wait for it to finish and return
        return;
    }


    fetchDataRunning = true;

    //console.log("Check Fetch Run = ", check_fetch_run);

    if (check_fetch_run == "") {
        return;
    }

    var check_looping = 1;

    var input_resize = document.getElementById("chatbox");
    input_resize.setAttribute("placeholder", "Type message");

    try {
        const response_one = await fetchDataFromServer(userTimezone, last_msg__id);

        //console.log("Last Message = ", last_msg__id);

        if (response_one && response_one.length > 0) {
            response_one.forEach(response => {
                // console.log(response);
                // Start
              if(response != null || response != ''){
              
              var lastItem = response;
            
               //console.log(lastItem);
               
               //return;
              var truncate_msg_last = lastItem.reply_msg.length > 28 ? lastItem.reply_msg.substring(0,28) + '...' : lastItem.reply_msg;
              var self_reply= lastItem.reply_user_name;
             if(get_Admin_fname == lastItem.reply_user_name){
                 self_reply ='You';
              }
              
              var user_name_org=lastItem.user_name;
                   if(get_Admin_fname == lastItem.user_name){
                         user_name_org = 'You';
                     }
                     
             daylabel_afterword_last='<p id="days_label" class="text-center mx-3 mb-0" style="color: #a2aab7;">'+lastItem.date_label+'</p>';
          
              var para_reply=`background-color: #d9fdd3;border-top-left-radius: 3px;border-top-right-radius: 3px;border-bottom: 0px;
               margin-left: -1px;`
               
                      var popup="";
                      var show_action_permission = "";
                        if (admin_id_global == 1) {
                            show_action_permission = `<p class="cursor_" style="line-height: 5px;" onclick="for_delete_message(${lastItem.id})">Delete</p>`;
                        }
              
              var base_=base_url;
              
             if(lastItem.message != '' && lastItem.documents == '' || (lastItem.reply_documents != '' && lastItem.message != '')){
            if (lastItem.reply_msg != '') {
             var width='width:100%;';
       var msg_add = `<div  class="d-flex justify-content-end message-container cursor_" style="width: 19rem;margin-left: 53px; margin-top: -14px;  margin-bottom: -20px">
      <i onclick="reply_msg(${lastItem.id });" class="bi bi-reply-fill custom_style_icon" style="display:none;"></i>
      <p  onclick="goto_up('target'+ ${lastItem.reply_id})" id="target${lastItem.reply_id}" class="small p-2 mb-1  mt-3 text-start" style="${para_reply}width:90%;background-color: #e9edefcc;border: 8px solid #d9fdd3;">
          <span class="small d-block text-start" style="font-size: 11px;float:left;font-weight: bold;color:${lastItem.reply_color}">${self_reply} &nbsp;</span>
          <br>${truncate_msg_last}
          </p>
       </div>`;
         var msg_add_right_single = `
      <div  class="d-flex justify-content-start message-container cursor_" style="margin-left:19px;width: 19rem; margin-top:-15px;margin-bottom: -20px">
      <i onclick="reply_msg(${lastItem.id });" class="bi bi-reply-fill custom_style_icon" style="display:none;"></i>
      <p onclick="goto_up('target'+ ${lastItem.reply_id})" data-target-id="target${lastItem.reply_id}"  class="small p-2 mb-1  mt-3 text-start" style="${para_reply}${width}max-width: 90%;background-color:#d9fdd3;border: 8px solid #f5f6f7;">
          <span class="small d-block text-start" style="font-size: 11px;float:left;font-weight: bold;color:${lastItem.reply_color}">${lastItem.reply_user_name}&nbsp;</span>
          <br>${truncate_msg_last}
          </p>
       </div>
         `;
         var border='';
         var border_para_main=`border-bottom-left-radius: 9px;border-bottom-right-radius: 9px;`;
          } else {
              var msg_add = '';
              var width='';
              msg_add_right_single='';
          var border='rounded-3';
          var border_para_main='';
          }
       
        
           
           
           //for reply doc/image/video
               if (lastItem.reply_documents != '') {
               var file_docs_name = getFileExtension(lastItem.reply_documents_path);
               var path = base_.trim()+ "/" + lastItem.reply_documents.trim();
                var truncate_docs = lastItem.reply_documents.length > 23 ? lastItem.reply_documents.substring(0,23) + '...' : lastItem.reply_documents;
               //alert('fdsbgsdf');
               
               var reply_parameter=",'docs'";
                  if(lastItem.reply_documents_path.endsWith('.png') || lastItem.reply_documents_path.endsWith('.jpg') || lastItem.reply_documents_path.endsWith('.jpeg') || lastItem.reply_documents_path.endsWith('.heic')){
                  reply_parameter=",'images'";
                  }
                  
        var width = 'width:90%;';
        var para_reply=`background-color: #d9fdd3;border-top-left-radius: 3px;border-top-right-radius: 3px;border-bottom: 0px;
                        margin-left: -1px;`
        var msg_add_right_single = `
        <div  class="d-flex justify-content-start message-container cursor_" style="margin-left:19px;width: 19rem; margin-top:-15px;margin-bottom: -20px">
        <i onclick="reply_msg(${lastItem.id });" class="bi bi-reply-fill custom_style_icon" style="display:none;"></i>
        <p onclick="goto_up('docs_reply'+ ${lastItem.reply_id}${reply_parameter})" data-target-id="target${lastItem.reply_id}"  class="small p-2 mb-1  mt-3 text-start" style="${para_reply}${width}max-width: 90%;background-color:#d9fdd3;border: 8px solid #f5f6f7;">
            <span class="small d-block text-start" style="font-size: 11px;float:left;font-weight: bold;color:${lastItem.reply_color}">${lastItem.reply_user_name}&nbsp;</span>
          <br><span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon_chat(file_docs_name)}</span>
                <span style="font-size: 15px;" data-toggle="tooltip" data-placement="top" title="${lastItem.reply_documents}">${truncate_docs}</span>
                </p>
         </div>
           `;
           
           var msg_add=`<div  class="d-flex justify-content-end message-container cursor_" style="width: 19rem;margin-left: 53px; margin-top: -14px;  margin-bottom: -20px">
        <i class="bi bi-reply-fill custom_style_icon" style="display:none;"></i>
        <p onclick="goto_up('docs_reply'+ ${lastItem.reply_id}${reply_parameter})" data-target-id="target${lastItem.reply_id}" class="small p-2 mb-1  mt-3 text-start" style="${para_reply}width:90%;background-color: #e9edefcc;border: 8px solid #d9fdd3;">
            <span class="small d-block text-start" style="font-size: 11px;float:left;font-weight: bold;color:${lastItem.reply_color}">${lastItem.reply_user_name}&nbsp;</span>
          <br><span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon_chat(file_docs_name)}</span>
                <span  style="font-size: 15px;" data-toggle="tooltip" data-placement="top" title="${lastItem.reply_documents}">${truncate_docs}</span> 
            </p>
         </div>`;
           var border='';
           var border_para_main=`border-bottom-left-radius: 9px;border-bottom-right-radius: 9px;`;
        } else {
            // var msg_add_left = '';
            // var width = ' ';
            // msg_add_right='';
            // var border='rounded-3';
            // var border_para_main='';
        }
           
           
          //console.log(msg_add_right_single);
          //RIGHT SIDE DIV
          var paragraph = `${daylabel_afterword_last} ${msg_add}
   <div id="target${lastItem.id }" class="d-flex justify-content-end message-container" style="width:19rem; margin-left: 53px;margin-top:-15px;" onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
  <i onclick="reply_msg(${lastItem.id });" class="bi bi-reply-fill custom_style_icon" style="display:none;left: 0px;top: -20px;"></i>
    
     <p  class="small p-2  mb-1  mt-3 text-start cursor_ ${border}" style="${width}${border_para_main} background-color: #d9fdd3;max-width: 90%;">${lastItem.message }
       <span class="small d-block text-end" style="font-size: 11px;margin-left: auto;font-style: italic;"><i>${formatTimestamp(lastItem.created_at)}</i></span>
      </p>
    </div>
`;
      //left side div
      
            var paragraph_ = `${daylabel_afterword_last}  ${msg_add_right_single}
    <div id="target${lastItem.id }"  class="d-flex justify-content-start message-container" style="margin-left: -12px;width: 19rem; margin-top:-15px;" onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
    
     <img   src="${base_}${lastItem.profileimg_path}"alt="avatar 1" style="width: 30px;height: 30px;margin-top: 19px; border-radius: 25px;position: relative;">
      <p  class="small p-2  mb-1  mt-3 text-start cursor_  ${border}" style="${width}${border_para_main}background-color: #f5f6f7;max-width: 90%;">
       <span class="small d-block text-start" style="font-size: 11px; margin-left: auto;font-weight: bold;color:${lastItem.color};">${lastItem.user_name}</span>
      ${lastItem.message }<br><i class="ms-2" style="float: right;font-size: 10px;">${formatTimestamp(lastItem.created_at)}</i></p>
       <i onclick="reply_msg(${lastItem.id });" id="left_reply" class="bi bi-reply-fill custom_style_icon" style="display:none;right: -26px;"></i>
    </div>
  `; 
  
             }else if(lastItem.message != '' && lastItem.documents != ''){

            var wrapper_reply_start = `<div class="wrapper_parent_reply" onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)" >`;
            var wrapper_reply_end = `</div>`;
            var file_docs_name = getFileExtension(lastItem.documents);
            var path = base_url+ "/" + lastItem.documents_path;
            var doc_name_show = lastItem.documents.length > 50 ? lastItem.documents.substring(0,50) + '...' : lastItem.documents;
            popup=`right: 64px;top: -10px;padding: 11px 3px 0px 8px;`;
             
              var paragraph=`    <div  id="target${lastItem.id}" class="message-container" style="margin: 12px 26px -6px 32px;  max-width: 91%; min-width: 91%;" onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
                <div id="text_area${lastItem.id}" class="d-flex position-relative justify-content-end">
                <i onclick="reply_msg(${lastItem.id});" class="bi bi-reply-fill custom_style_icon" style="display:none;position: absolute;left: 0px;top: -20px;"></i>
                    <div id="target${lastItem.id}" class="d-flex align-items-center" style="border: 2px solid #d9ecd6;/* border-radius: 10px; */padding-left: 6px;padding-top: 5px;background: #d9fdd3;position: relative;width: 296px;border-top-left-radius: 10px;border-top-right-radius: 10px;/* margin-left: 0px; */margin-right: 2px;">
                        <span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon_chat(file_docs_name)}</span>
                        <p data-toggle="tooltip" data-placement="top" title="${lastItem.documents}" class="d-inline font-weight-bold mr-3" style="width: auto; width: 84%; margin-top: 9px; margin-left: 6px; overflow: hidden; text-overflow: ellipsis; padding-right: 5px;">
                            <a href="${path}" target="_blank">${doc_name_show}</a><br>
                            
                        </p>
                        <span class="d-inline" style="font-size: 28px; margin-top: -8px; margin-right: 9px; color: #918b8b;">
                            <a href="${path}" download="${lastItem.documents}">
                                <i class="bi bi-arrow-down-circle"></i>
                            </a>
                        </span>
                    </div>
                    
                </div> 
                <div id="target${lastItem.id}" style="margin: -2px 26px 8px 28px;max-width: 91%;min-width: 91%;border: 2px solid #d9ecd6;padding-left: 6px;padding-top: 5px;background: #d9fdd3;position: relative;border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;"> ${lastItem.message} <i class="ms-2" style="float: right; font-size: 10px; position: absolute; right: 7px; bottom: 2px;">${formatTimestamp(lastItem.created_at)}</i></div>
            </div>`;
            
            
                var paragraph_=`    <div id="target${lastItem.id}" class="message-container" style="margin: 2px 0px -5px -14px; max-width: 91%; min-width: 91%;" onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
                <div id="text_area${lastItem.id}" class="d-flex position-relative justify-content-start">
                <img   src="${base_}${lastItem.profileimg_path}"alt="avatar 1" style="width: 30px;height: 30px;margin-top: 6px; border-radius: 25px;">  
                    <div id="target${lastItem.id}" class="d-flex align-items-center" style="border: 2px solid #c8c8c8;/* border-radius: 10px; */padding-left: 6px;padding-top: 5px;background: #f5f6f7;position: relative;width: 296px;border-top-left-radius: 10px;border-top-right-radius: 10px;/* margin-left: 0px; */margin-right: 2px;">
                        <span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon_chat(file_docs_name)}</span>
                        <p data-toggle="tooltip" data-placement="top" title="${lastItem.documents}" class="d-inline font-weight-bold mr-3" style="width: auto; width: 84%; margin-top: 9px; margin-left: 6px; overflow: hidden; text-overflow: ellipsis; padding-right: 5px;">
                            <a href="${path}" target="_blank">${doc_name_show}</a><br>
                            
                        </p>
                        <span class="d-inline" style="font-size: 28px; margin-top: -8px; margin-right: 9px; color: #918b8b;">
                            <a href="${path}" download="${lastItem.documents}">
                                <i class="bi bi-arrow-down-circle"></i>
                            </a>
                        </span>
                    </div>
                     <i onclick="reply_msg(${lastItem.id});" class="bi bi-reply-fill custom_style_icon" style="display:none;position: absolute;top: -23px;right: -28px;"></i>
                </div> 
                <div id="target${lastItem.id}" style="margin: -2px 26px 8px 30px;max-width: 90.2%;min-width: 90.2%;border: 2px solid #c8c8c8;padding-left: 6px;padding-top: 5px;background: #f5f6f7;position: relative;border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;"> ${lastItem.message} <i class="ms-2" style="float: right; font-size: 10px; position: absolute; right: 7px; bottom: 2px;">${formatTimestamp(lastItem.created_at)}</i></div>
            </div>`;
            
             
             }
             else if(lastItem.reply_documents != '' && lastItem.documents  != ''){
           // console.log('doc reply with docs' + lastItem.reply_documents + lastItem.id);
            
            if(lastItem.reply_documents){
                var file_docs_name = getFileExtension(lastItem.reply_documents_path);
                var file_docs_name_org = getFileExtension(lastItem.documents);
                var path = base_.trim()+ "/" + lastItem.reply_documents.trim();
                var truncate_docs = lastItem.reply_documents.length > 25 ? lastItem.reply_documents.substring(0,25     ) + '...' : lastItem.reply_documents;
                var truncate_docs_org = lastItem.documents.length > 50 ? lastItem.documents.substring(0,50) + '...' : lastItem.documents;

             var width_upper_container_image_right='width: 19rem;margin-left: 53px;';
             var width_upper_container_image_left='margin-left:19px;width: 19rem;';
             var reply_parameter=",'docs'";
                  if(lastItem.documents.endsWith('.png') || lastItem.documents.endsWith('.jpg') || lastItem.documents.endsWith('.jpeg') || lastItem.documents.endsWith('.heic')){
                  reply_parameter=",'images'";
                  width_upper_container_image_right=' width: 14rem;margin-left: 131px;';
                  width_upper_container_image_left='margin-left:19px;width: 14rem;';
                  truncate_docs = lastItem.reply_documents.length > 15 ? lastItem.reply_documents.substring(0,15) + '...' : lastItem.reply_documents;
                  }


        var width = 'width:90%;';
        var para_reply=`background-color: #d9fdd3;border-top-left-radius: 3px;border-top-right-radius: 3px;border-bottom: 0px;
                        margin-left: -1px;`
        var msg_add_left = `
        <div  class="d-flex justify-content-start message-container cursor_" style="${width_upper_container_image_left} margin-top:-15px;margin-bottom: -20px">
        <i onclick="reply_msg(${lastItem.id });" class="bi bi-reply-fill custom_style_icon" style="display:none;"></i>
        <p onclick="goto_up('docs_reply'+ ${lastItem.reply_id}${reply_parameter})" data-target-id="target${lastItem.reply_id}"  class="small p-2 mb-1  mt-3 text-start" style="${para_reply}${width}max-width: 90%;background-color:#d9fdd3;border: 8px solid #f5f6f7;">
            <span class="small d-block text-start" style="font-size: 11px;float:left;font-weight: bold;color:${lastItem.reply_color}">${self_reply}&nbsp;</span>
          <br><span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon_chat(file_docs_name)}</span>
                <span style="font-size: 15px;" data-toggle="tooltip" data-placement="top" title="${lastItem.reply_documents}">${truncate_docs}</span>
                </p>
         </div>
           `;
           
           var msg_add_right=`<div  class="d-flex justify-content-end message-container cursor_" style="${width_upper_container_image_right} margin-top: -14px;  margin-bottom: -20px">
        <i onclick="reply_msg(${lastItem.id });" class="bi bi-reply-fill custom_style_icon" style="display:none;"></i>
        <p onclick="goto_up('docs_reply'+ ${lastItem.reply_id}${reply_parameter})" data-target-id="target${lastItem.reply_id}" class="small p-2 mb-1  mt-3 text-start" style="${para_reply}width:90%;background-color: #e9edefcc;border: 8px solid #d9fdd3;">
            <span class="small d-block text-start" style="font-size: 11px;float:left;font-weight: bold;color:${lastItem.reply_color}">${self_reply}&nbsp;</span>
          <br><span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon_chat(file_docs_name)}</span>
                <span  style="font-size: 15px;" data-toggle="tooltip" data-placement="top" title="${lastItem.reply_documents}">${truncate_docs}</span> 
            </p>
         </div>`;
           var border='';
           var border_para_main=`border-bottom-left-radius: 9px;border-bottom-right-radius: 9px;`;  
        }
        else {
            var msg_add_left = '';
            var width = ' ';
            msg_add_right='';
            var border='rounded-3';
            var border_para_main='';
        }
                  
                  
                  
                  //when image reply with image 
    if(lastItem.documents.endsWith('.png') || lastItem.documents.endsWith('.jpg') || lastItem.documents.endsWith('.jpeg') || lastItem.documents.endsWith('.heic')){
          
                var file_docs_name = getFileExtension(lastItem.documents);
                var file_docs_name_org = getFileExtension(lastItem.documents);
                var path = base_.trim()+ "/" + lastItem.documents_path.trim();
                var truncate_docs = lastItem.documents.length > 25 ? lastItem.documents.substring(0,25     ) + '...' : lastItem.documents;
                var truncate_docs_org = lastItem.documents.length > 50 ? lastItem.documents.substring(0,50) + '...' : lastItem.documents;
          
          
          //console.log('reply docs--->' + lastItem.documents_path + lastItem.id);
              var paragraph = `${msg_add_right}
           
    <div Rohit_img_with_img id="target${lastItem.id}"  class="d-flex justify-content-end message-container" style="margin-left: 131px;margin-top: -7px;position: relative;width: 63%;" onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
       
      <i onclick="reply_msg(${lastItem.id});" class="bi bi-reply-fill custom_style_icon" style="display:none;position:absolute;top:50%;left:0;"></i>
      
      <div  class="small p-2 mb-1 ${border} mt-2 text-start cursor_" style="${width}${border_para_main}max-width: 90%;background-color:#d9fdd3;"> 
       <span class="small d-block text-start" style="font-size: 11px;float:left;font-weight: bold;color:${lastItem.color}">${user_name_org}&nbsp;</span>
          <br>
          <div class="row">
      <div class="col-8"><span style="font-size: 15px;margin-left: -2px;" data-toggle="tooltip" data-placement="top" title="${lastItem.documents}"><a href="${path}" target="_blank"><img id="docs_reply${lastItem.id}" src="${path}" width="191px" height="145px" style="border: 2px solid #c8c8c8;border-radius: 10px;position:relative;"></a></span></div>
                      </span></div>
          </div>
        <i class="ms-2" style="float: right;font-size: 10px;position: absolute;bottom: 14px;left: 74%;color:black;">${formatTimestamp(lastItem.created_at)}</i></p>
                </div>
        
      </p>
    </div>
       ${daylabel_afterword_last}
       `;
    
               
    // divleft for message to docs
                var paragraph_ = `${msg_add_left}
           
    <div Rohit_img_with_img  id="target${lastItem.id}"  class="d-flex justify-content-end message-container" style="margin-left: -5px;margin-top: -7px;position: relative;width: 63%;;" onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
        <img   src="${base_}${lastItem.profileimg_path}"alt="avatar 1" style="width: 30px;height: 30px;margin-top: 19px; border-radius: 25px;">  
      <i onclick="reply_msg(${lastItem.id});" class="bi bi-reply-fill custom_style_icon" style="display:none;position: absolute;top: 50%;right: -25px;"></i>
      
      <div  class="small p-2 mb-1 ${border} mt-2 text-start cursor_" style="${width}${border_para_main}max-width: 90%;background-color:#f5f6f7;"> 
       <span class="small d-block text-start" style="font-size: 11px;float:left;font-weight: bold;color:${lastItem.color}">${user_name_org}&nbsp;</span>
          <br>
          <div class="row">
      <div class="col-8"><span style="font-size: 15px;margin-left: -2px;" data-toggle="tooltip" data-placement="top" title="${lastItem.documents}"><a href="${path}" target="_blank"><img id="docs_reply${lastItem.id}" src="${path}" width="191px" height="145px" style="border: 2px solid #c8c8c8;border-radius: 10px;position:relative;"></a></span></div>
                      </span></div>
          </div>
        <i class="ms-2" style="float: right;font-size: 10px;position: absolute;bottom: 14px;left: 74%;color:black;">${formatTimestamp(lastItem.created_at)}</i></p>
                </div>
        
      </p>
    </div>
       ${daylabel_afterword_last}
       `;
            }
    else{              
                  
        //  right_div for docs to docs
    //console.log(check_icon_chat(file_docs_name)+ lastlastItem.id);
     var paragraph = `${msg_add_right}
    <div  id="target${lastItem.id}"  class="d-flex justify-content-end message-container" style="width: 19rem; margin-left: 53px; margin-top: -7px;" onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
       
      <i onclick="reply_msg(${lastItem.id});" class="bi bi-reply-fill custom_style_icon" style="display:none;"></i>
      
      <div id="docs_reply${lastItem.id}" class="small p-2 mb-1 ${border} mt-2 text-start cursor_" style="${width}${border_para_main}max-width: 90%;background-color:#d9fdd3;"> 
       <span class="small d-block text-start" style="font-size: 11px;float:left;font-weight: bold;color:${lastItem.color}">${user_name_org}&nbsp;</span>
          <br>
          <div class="row">
          <div class="col-2"><span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon_chat(file_docs_name_org)}</span></div>
          <div class="col-8 text-start"><div style="font-size: 15px;margin-top:11px;" data-toggle="tooltip" data-placement="top" title="${lastItem.documents}"><a href="${path}" target="_blank">${truncate_docs_org}</a></div></div>
          <div class="col-2"><span class="d-inline" style="font-size: 28px;margin-top: 0px;margin-right: 9px;color: #918b8b;float: right;">
                    <a href="${path}" download="${path}">
                        <i class="bi bi-arrow-down-circle text-dark"></i>
                    </a>
                    </span></div>
          </div>
        <i class="ms-2" style="float: right;font-size: 10px;">${formatTimestamp(lastItem.created_at)}</i></p>
                </div>
        
      </p>
    </div>
       ${daylabel_afterword_last}
       `;
    
               
    // divleft for docs to docs
                var paragraph_ = `    ${msg_add_left}
                
      <div   id="target${lastItem.id }" class="d-flex justify-content-start message-container" style="margin-left: -12px;width: 19rem; margin-top:-15px;position: relative;" onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
      <img   src="${base_}${lastItem.profileimg_path}"alt="avatar 1" style="width: 30px;height: 30px;margin-top: 19px; border-radius: 25px;">  
        <div id="docs_reply${lastItem.id}" style="${width}${border_para_main}background-color: #f5f6f7;max-width: 90%;">
        <p  class="${border} small p-2 mb-1 text-start cursor_" >
         <span class="small d-block text-start" style="font-size: 11px; margin-left: auto;font-weight: bold;color:${lastItem.color};">${user_name_org}</span>
      </p>
      <div class="row " style="margin-top:-12px;">
      <div class="col-2 " style="font-size: 28px;"> <span style="margin-left:5px;">${check_icon_chat(file_docs_name_org)}</span></div>
      <div class="col-8"><span style="font-size: 15px;" data-toggle="tooltip" data-placement="top" title="${lastItem.documents}"><a href="${path}" target="_blank">${truncate_docs_org}</a></span></div>
      <div class="col-2 "><span class="d-inline" style="font-size: 28px;color: #918b8b;float: right;margin-right: 9px;">
                    <a href="${path}" download="${lastItem.documents}">
                        <i class="bi bi-arrow-down-circle text-dark"></i>
                    </a>
                </span> </div>
                          
      </div>    
        <i class="ms-2" style="float: right;font-size: 10px;">${formatTimestamp(lastItem.created_at)}</i>
          </div>
         <i onclick="reply_msg(${lastItem.id });" id="left_reply" class="bi bi-reply-fill custom_style_icon" style="display:none;position: absolute;right: -26px;"></i>
      </div> ${daylabel_afterword_last}
    `;
    
    }
                    
        var wrapper_reply_start = `<div class="wrapper_parent_reply" style="margin-bottom:5px;">`;
        var wrapper_reply_end = `</div>`;
        
         //console.log(paragraph_ + paragraph);
         
             }
             else if(lastItem.reply_msg != '' && lastItem.documents  != ''){
                
                
                
                
                
               var width_upper_container="";
               var margin_for_upper_container="margin-left: 53px;";
                if(lastItem.documents.endsWith('.png') || lastItem.documents.endsWith('.jpg') || lastItem.documents.endsWith('.jpeg') || lastItem.documents.endsWith('.heic')){
                width_upper_container='width:63%;';
                margin_for_upper_container='margin-left: 131px;';
                    
                }

                //message reply with docs/images
                var file_docs_name = getFileExtension(lastItem.documents);
                var file_docs_name_org = getFileExtension(lastItem.documents);
                var path = base_.trim()+ "/" + lastItem.documents_path.trim();
                var truncate_docs = lastItem.documents.length > 25 ? lastItem.documents.substring(0,25     ) + '...' : lastItem.documents;
                var truncate_docs_org = lastItem.documents.length > 50 ? lastItem.documents.substring(0,50) + '...' : lastItem.documents;
                 
                     if (lastItem.reply_msg != '') {
             //  console.log('--->' + item.reply_msg + item.id);
                var truncate_msg = lastItem.reply_msg.length > 35 ? lastItem.reply_msg.substring(0,35) + '...' : lastItem.reply_msg;
               //alert('fdsbgsdf');
       
        var width = 'width:90%;';
        var para_reply=`background-color: #d9fdd3;border-top-left-radius: 3px;border-top-right-radius: 3px;border-bottom: 0px;
                        margin-left: -1px;`
        var msg_add_left = `
        <div  class="d-flex justify-content-start message-container cursor_" style="margin-left:19px;width: 19rem; margin-top:-15px;margin-bottom: -20px;${width_upper_container}">
        <i onclick="reply_msg(${lastItem.id });" class="bi bi-reply-fill custom_style_icon" style="display:none;"></i>
        <p onclick="goto_up('target'+ ${lastItem.reply_id})" data-target-id="target${lastItem.reply_id}"  class="small p-2 mb-1  mt-3 text-start" style="${para_reply}${width}max-width: 90%;background-color:#d9fdd3;border: 8px solid #f5f6f7;">
            <span class=" cursor_ small d-block text-start" data-toggle="tooltip" data-placement="top" title="${lastItem.reply_msg}" style="font-size: 11px;float:left;font-weight: bold;color:${lastItem.reply_color}">${self_reply}&nbsp;</span>
          <br>  ${truncate_msg}
            </p>
         </div>
           `;
           
           var msg_add_right=`<div class="d-flex justify-content-end message-container cursor_" style="width: 19rem; margin-top: -14px;  margin-bottom: -20px;${width_upper_container} ${margin_for_upper_container}">
        <i onclick="reply_msg(${lastItem.id });" class="bi bi-reply-fill custom_style_icon" style="display:none;"></i>
        <div onclick="goto_up('target'+ ${lastItem.reply_id})" data-target-id="target${lastItem.reply_id}" class="small p-2 mb-1  mt-3 text-start" style="${para_reply}width:90%;background-color: #e9edefcc;border: 8px solid #d9fdd3;">
            <span data-toggle="tooltip" data-placement="top" title="${lastItem.reply_msg}"  class="cursor_ small d-block text-start" style="font-size: 11px;float:left;font-weight: bold;color:${lastItem.reply_color}">${self_reply}&nbsp;</span>
          <br> ${truncate_msg}
            </div>
         </div>`;
           var border='';
           var border_para_main=`border-bottom-left-radius: 9px;border-bottom-right-radius: 9px;`;
        }
        else {
            var msg_add_left = '';
            var width = ' ';
            msg_add_right='';
            var border='rounded-3';
            var border_para_main='';
        }

     //return;
           
               //  right_div for message to docs
       if(lastItem.documents.endsWith('.png') || lastItem.documents.endsWith('.jpg') || lastItem.documents.endsWith('.jpeg') || lastItem.documents.endsWith('.heic')){
           
           var paragraph = `${msg_add_right}
           
    <div  id="target${lastItem.id}"  class="d-flex justify-content-end message-container" style="margin-left: 131px;margin-top: -7px;position: relative;width: 63%;;" onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
       
      <i onclick="reply_msg(${lastItem.id});" class="bi bi-reply-fill custom_style_icon" style="display:none;position:absolute;top:50%;left:0;"></i>
      
      <div  class="small p-2 mb-1 ${border} mt-2 text-start cursor_" style="${width}${border_para_main}max-width: 90%;background-color:#d9fdd3;"> 
       <span class="small d-block text-start" style="font-size: 11px;float:left;font-weight: bold;color:${lastItem.color}">${user_name_org}&nbsp;</span>
          <br>
          <div class="row">
      <div class="col-8"><span style="font-size: 15px;margin-left: -2px;" data-toggle="tooltip" data-placement="top" title="${lastItem.documents}"><a href="${path}" target="_blank"><img id="docs_reply${lastItem.id}" src="${path}" width="191px" height="145px" style="border: 2px solid #c8c8c8;border-radius: 10px;position:relative;"></a></span></div>
                      </span></div>
          </div>
        <i class="ms-2" style="float: right;font-size: 10px;position: absolute;bottom: 14px;left: 74%;color:black;">${formatTimestamp(lastItem.created_at)}</i></p>
                </div>
        
      </p>
    </div>
       ${daylabel_afterword_last}
       `;
    
               
    // divleft for message to docs
                var paragraph_ = `${msg_add_left}
           
    <div  id="target${lastItem.id}"  class="d-flex justify-content-end message-container" style="margin-left: -5px;margin-top: -7px;position: relative;width: 63%;;" onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
        <img   src="${base_}${lastItem.profileimg_path}"alt="avatar 1" style="width: 30px;height: 30px;margin-top: 19px; border-radius: 25px;">  
      <i onclick="reply_msg(${lastItem.id});" class="bi bi-reply-fill custom_style_icon" style="display:none;position: absolute;top: 50%;right: -25px;"></i>
      
      <div  class="small p-2 mb-1 ${border} mt-2 text-start cursor_" style="${width}${border_para_main}max-width: 90%;background-color:#f5f6f7;"> 
       <span class="small d-block text-start" style="font-size: 11px;float:left;font-weight: bold;color:${lastItem.color}">${user_name_org}&nbsp;</span>
          <br>
          <div class="row">
      <div class="col-8"><span style="font-size: 15px;margin-left: -2px;" data-toggle="tooltip" data-placement="top" title="${lastItem.documents}"><a href="${path}" target="_blank"><img id="docs_reply${lastItem.id}"  src="${path}" width="191px" height="145px" style="border: 2px solid #c8c8c8;border-radius: 10px;position:relative;"></a></span></div>
                      </span></div>
          </div>
        <i class="ms-2" style="float: right;font-size: 10px;position: absolute;bottom: 14px;left: 74%;color:black;">${formatTimestamp(lastItem.created_at)}</i></p>
                </div>
        
      </p>
    </div>
       ${daylabel_afterword_last}
       `;
    
           
           
       }else{
           
     var paragraph = `${msg_add_right}
    <div  id="target${lastItem.id}"  class="d-flex justify-content-end message-container" style="width: 19rem; margin-left: 53px; margin-top: -7px;" onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
       
      <i onclick="reply_msg(${lastItem.id});" class="bi bi-reply-fill custom_style_icon" style="display:none;"></i>
      
      <div  id="docs_reply${lastItem.id}" class="small p-2 mb-1 ${border} mt-2 text-start cursor_" style="${width}${border_para_main}max-width: 90%;background-color:#d9fdd3;"> 
       <span class="small d-block text-start" style="font-size: 11px;float:left;font-weight: bold;color:${lastItem.color}">${user_name_org}&nbsp;</span>
          <br>
          <div class="row">
          <div class="col-2"><span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon_chat(file_docs_name_org)}</span></div>
          <div class="col-8 text-start"><div style="font-size: 15px;margin-top:11px;" data-toggle="tooltip" data-placement="top" title="${lastItem.documents}"><a href="${path}" target="_blank">${truncate_docs_org}</a></div></div>
          <div class="col-2"><span class="d-inline" style="font-size: 28px;margin-top: 0px;margin-right: 9px;color: #918b8b;float: right;">
                    <a href="${path}" download="${path}">
                        <i class="bi bi-arrow-down-circle text-dark"></i>
                    </a>
                    </span></div>
          </div>
        <i class="ms-2" style="float: right;font-size: 10px;">${formatTimestamp(lastItem.created_at)}</i></p>
                </div>
        
      </p>
    </div>
       ${daylabel_afterword_last}
       `;
    
               
    // divleft for message to docs
                var paragraph_ = `    ${msg_add_left}
                
      <div   id="target${lastItem.id }" class="d-flex justify-content-start message-container" style="margin-left: -12px;width: 19rem; margin-top:-15px;position: relative;" onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
      <img   src="${base_}${lastItem.profileimg_path}"alt="avatar 1" style="width: 30px;height: 30px;margin-top: 19px; border-radius: 25px;">  
        <div id="docs_reply${lastItem.id}" style="${width}${border_para_main}background-color: #f5f6f7;max-width: 90%;">
        <p  class="${border} small p-2 mb-1 text-start cursor_" >
         <span class="small d-block text-start" style="font-size: 11px; margin-left: auto;font-weight: bold;color:${lastItem.color};">${user_name_org}</span>
      </p>
      <div class="row " style="margin-top:-12px;">
      <div class="col-2 " style="font-size: 28px;"> <span style="margin-left:5px;">${check_icon_chat(file_docs_name_org)}</span></div>
      <div class="col-8"><span style="font-size: 15px;" data-toggle="tooltip" data-placement="top" title="${lastItem.documents}"><a href="${path}" target="_blank">${truncate_docs_org}</a></span></div>
      <div class="col-2 "><span class="d-inline" style="font-size: 28px;color: #918b8b;float: right;margin-right: 9px;">
                    <a href="${path}" download="${lastItem.documents}">
                        <i class="bi bi-arrow-down-circle text-dark"></i>
                    </a>
                </span> </div>
                          
      </div>    
        <i class="ms-2" style="float: right;font-size: 10px;">${formatTimestamp(lastItem.created_at)}</i>
          </div>
         <i onclick="reply_msg(${lastItem.id });" id="left_reply" class="bi bi-reply-fill custom_style_icon" style="display:none;position: absolute;right: -26px;"></i>
      </div> 
      <br>
      ${daylabel_afterword_last}
    `;
             
       }       
       
        var wrapper_reply_start = `<div class="wrapper_parent_reply" style="margin-bottom:5px;">`;
        var wrapper_reply_end = `</div>`;
        
             
              
                 
             }
             else{
                 
                
                  var file_docs_name = getFileExtension(lastItem.documents);
                  var path = base_url+ "/" + lastItem.documents_path;
                   popup=`right: 64px;top: -10px;padding: 11px 3px 0px 8px;`;
                    var doc_name_show = lastItem.documents.length > 50 ? lastItem.documents.substring(0,50) + '...' : lastItem.documents;
                    if(lastItem.documents.endsWith('.png') || lastItem.documents.endsWith('.jpg') || lastItem.documents.endsWith('.jpeg') || lastItem.documents.endsWith('.heic')){
              //for same user  for image
                   var paragraph = `
        <div id="target${lastItem.id}" class="message-container" style="margin: -4px 0px 6px 32px; max-height: 150px; max-width: 91%; min-width: 91%;" onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
            <div id="text_area${lastItem.id}" class="d-flex position-relative justify-content-end">
            <i onclick="reply_msg(${lastItem.id });"  class="bi bi-reply-fill custom_style_icon" style="display:none;"></i>
                <div  class="d-flex align-items-center" style="padding-top: 5px; position: relative; ">
                      <a data-toggle="tooltip" data-placement="top" title="${lastItem.documents}" href="${path}"  target="_blank" >
                            <img id="docs_reply${lastItem.id}" src="${path}" width="191px" height="145px" style="border: 2px solid #c8c8c8;border-radius: 10px;"></a>
            <i class="ms-2" style="float: right; font-size: 10px; position: absolute; right: 7px; bottom: 2px;color:white;">${formatTimestamp(lastItem.created_at)}</i>
                </div>
            </div> 
        </div>
`;
        //for diffrent user for image
        //console.log(base_url);
                   var paragraph_ = `
                    
                    <div id="target${lastItem.id}" class="message-container" style="margin: -7px 25px 6px -13px; max-height: 150px; max-width: 91%; min-width: 91%;" onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
                        <div id="text_area${lastItem.id}" class="d-flex position-relative justify-content-start">
                     
                <img   src="${base_url}${lastItem.profileimg_path}"alt="avatar 1" style="width: 30px;height: 30px;margin-top: 6px; border-radius: 25px;">  
                            <div  class="d-flex align-items-center" style="padding-top: 5px; position: relative; ">
                                  <a data-toggle="tooltip" data-placement="top" title="${lastItem.documents}" href="${path}"  target="_blank" >
                                        <img id="docs_reply${lastItem.id}" src="${path}" width="191px" height="145px" style="border: 2px solid #c8c8c8;border-radius: 10px;"></a>
                                  <i class="ms-2" style="float: right; font-size: 10px; position: absolute; right: 7px; bottom: 2px;color:white;">${formatTimestamp(lastItem.created_at)}</i>
                            </div>
                            <i onclick="reply_msg(${lastItem.id});" class="bi bi-reply-fill custom_style_icon" style="display:none;"></i>
                        </div> 
                    </div>
                `;
                    }else{
                          var paragraph = `
                      <div id="target${lastItem.id}" class="message-container" style="margin: 5px 26px 8px 32px; max-height: 97px; max-width: 91%; min-width: 91%;" onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
                <div id="text_area${lastItem.id}" class="d-flex position-relative justify-content-end">
                <i  onclick="reply_msg(${lastItem.id });" class="bi bi-reply-fill custom_style_icon" style="display:none;position: absolute;left: 0px;top: -20px;"></i>
                    <div id="docs_reply${lastItem.id}" class="d-flex align-items-center" style="border: 2px solid #d9ecd6; border-radius: 10px; padding-left: 6px; padding-top: 5px; background: #d9fdd3; position: relative; width: 300px;">
                        <span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon_chat(file_docs_name)}</span>
                        <p data-toggle="tooltip" data-placement="top" title="${lastItem.documents}" class="d-inline font-weight-bold mr-3" style="width: auto; width: 84%; margin-top: 9px; margin-left: 6px; overflow: hidden; text-overflow: ellipsis; padding-right: 5px;">
                            <a href="${path}" target="_blank">${doc_name_show}</a><br>
                            <i class="ms-2" style="float: right; font-size: 10px; position: absolute; right: 7px; bottom: 2px;">${formatTimestamp(lastItem.created_at)}</i>
                        </p>
                        <span class="d-inline" style="font-size: 28px; margin-top: -8px; margin-right: 9px; color: #918b8b;">
                            <a href="${path}" download="${lastItem.documents}">
                                <i class="bi bi-arrow-down-circle"></i>
                            </a>
                        </span>
                    </div>
                </div> 
            </div>
                `; 
                 
                 var paragraph_ = `
                      <div id="target${lastItem.id}" class="message-container" style="margin: 5px 26px 8px -14px; max-height: 97px; max-width: 90%; min-width: 90%;" onmouseout="hideReplyIcon(this)" onmouseover="showReplyIcon(this)">
                <div id="text_area${lastItem.id}" class="d-flex position-relative justify-content-start">
                    
                    <img   src="${base_url}${lastItem.profileimg_path}"alt="avatar 1" style="width: 30px;height: 30px;margin-top: 6px; border-radius: 25px;"> 
                    <div id="docs_reply${lastItem.id}" class="d-flex align-items-center" style="border: 2px solid #cbcbcb; border-radius: 10px; padding-left: 6px; padding-top: 5px; background: #f5f6f7; position: relative; width: 300px;">
                        <span class="d-inline" style="font-size: 28px; margin-top: -3px;">${check_icon_chat(file_docs_name)}</span>
                        <p data-toggle="tooltip" data-placement="top" title="${lastItem.documents}" class="d-inline font-weight-bold mr-3" style="width: auto; width: 84%; margin-top: 9px;overflow: hidden; text-overflow: ellipsis; padding-right: 5px;">
                            <a href="${path}" target="_blank">${doc_name_show}</a><br>
                            <i class="ms-2" style="float: right; font-size: 10px; position:absolute;right: 5px;bottom: 0;">${formatTimestamp(lastItem.created_at)}</i>
                        </p>
                        <i onclick="reply_msg(${lastItem.id})" class="bi bi-reply-fill custom_style_icon" style="display:none;position: absolute;right: -26px;top: -26px;"></i>
                        <span class="d-inline" style="font-size: 28px; margin-top: -8px; margin-right: 9px; color: #918b8b;">          
                            <a href="${path}" download="${lastItem.documents}">
                                <i class="bi bi-arrow-down-circle"></i>
                            </a>
                        </span>
                    </div>
                    
                </div> 
            </div>
                `;    
                
                
                    }
  
        }
       if(last_msg__id != lastItem.id){
           var msg_count = document.getElementById('msg_count');
           
            if (lastItem.user_id == admin_id_global) {
            $('#result_oponent').append(paragraph);
             $('#chat_area').animate({scrollTop: $('#chat_area')[0].scrollHeight}, 0);
            } else{
                new_msg_received++;
                
                //console.log(notification);
                // msg_count.style.display = 'block';
               // console.log(new_msg_received);
              //   $('#msg_count').text(new_msg_received);
              //   $('#msg_count').addClass('bg-danger');
                  
                 $('#result_oponent').append(paragraph_);
            }
            // if(check_looping == 0){
            //   last_msg__id = lastItem.id; 
            //   check_looping++;
            // }
            
                
       }        
         
           }
                  // End

              });


              
              console.log("Last Message = ", last_msg__id);
                
              last_msg__id = response_one[0].id;

        }

        if (new_msg_received != 0) {
            play_sound();
            new_msg_received = 0;
        }
        make_count_area();
        setTimeout(async () => {
            fetchDataRunning = false;
            await fetchData_last(false);
        }, 500);

       // console.log("Running Last Function");
    } catch (error) {
        console.error(error);
        fetchDataRunning = false;
        // If an error occurs, clear the flag to allow future attempts
        setTimeout(() => {
            fetchData_last(false);
        }, 500);
    }
}

function fetchDataFromServer(userTimezone, last_msg__id) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '<?= base_url("admin/admin_functions/last_one_data_fetch") ?>',
            method: 'POST',
            data: {
                userTimezone,
                last_msg__id
            },
            success: function (response) {
                resolve(response);
            },
            error: function (xhr, status, error) {
                reject(error);
            }
        });
    });
}


  // End
        

//----------store notification-----//
var notify=0;
    // function notification_store(){
        
    //     $.ajax({
            
    //      url: '<= base_url("admin/admin_functions/notification_store") ?>', 
    //      method: 'POST',
    //      data:{
    //          admin_id:<=$admin_id?>,
          
    //       },
    //     success: function(response) {
    //                  //console.log(response);
    //                 //   if(response.notification != 0 ){
    //                 //  notify=response.notification;
    //                 //  console.log(notify);
    //                 //   $('#msg_count').text(notify);
    //                 //   $('#msg_count').addClass('bg-danger');
    //                 //  }
    //              },
    //              });
    // }

//after scroll and closed chat update 0 for same id
    function update_chat_aftershownotification(){
        
        $.ajax({
            
         url: '<?= base_url("admin/admin_functions/update_chat_aftershownotification") ?>', 
         method: 'POST',
         data:{
             admin_id:admin_id_global,
          
          },
        success: function(response) {
                     
                      
                 },
                 });
    }
// ----------------->when received msg this for notification sound<----------------- 
 function play_sound() {
    var audio = new Audio();
    audio.src = "<?= base_url('public/chat_notification/Iphone Notification.mp3') ?>";
    audio.type = "audio/ogg";
    // audio.play();
    console.log(' audio played');
    
  }
  
  //when send msg 
  function play_sound_send() {
    var audio = new Audio();
    audio.src = "<?=base_url('public/chat_notification/google_glass_message.mp3')?>";
    audio.type = "audio/ogg";
    // audio.play();
    console.log(' audio played');
  }
  // ----------------->this for scroll to parent msg<----------------- 
  
 

function goto_up(element,images) {
    // console.log(element);
   
    //  console.log(images);
    // return;
    if(images == 'images'){
       $("#" + element).css({
  //backgroundColor: "rgb(146 247 135)", 
   border: "3px solid #FFCC01"
});
  $("#" + element).get(0).scrollIntoView();
  
   setTimeout(function() {
    $("#" + element).css({
     // backgroundColor: "#e9edefcc", 
      border: '2px solid #cbcbcb'
    });
  }, 1000); // 2000   
    }else if(images == 'docs'){
    var cssValue = $('#' + element).css('border');
  $("#" + element).css({
  //backgroundColor: "rgb(146 247 135)", 
   border: "3px solid #FFCC01"
});
  $("#" + element).get(0).scrollIntoView();
  
   setTimeout(function() {
    $("#" + element).css({
     // backgroundColor: "#e9edefcc", 
      border: cssValue
    });
  }, 1000); // 2000 
  
    }
    else{
     $("#" + element).find("p").css({
  //backgroundColor: "rgb(146 247 135)", 
  border: "2px solid #FFCC01"
});
  $("#" + element).get(0).scrollIntoView();
  
   setTimeout(function() {
    $("#" + element).find("p").css({
     // backgroundColor: "#e9edefcc", 
      border: ""
    });
  }, 1000); // 2000    
    }
}





// ----------------->this is use to hide span design purpose<----------------- 
  function hideSpans() {
         //for show tooltip
   var navLinks = document.querySelectorAll(".nav-link");
   var tooltips = ["Dashboard", "Application Manager", "Interview Bookings","Practical Bookings","Applicant / Agent","Staff Management","Occupation Manager","Locations","Verification","Archive","Mail Template","Offline Files","Admin Functions"];
   navLinks.forEach(function(linkElement, index) {
    var tooltipValue = tooltips[index % tooltips.length];
    linkElement.setAttribute("data-toggle", "tooltip");
    linkElement.setAttribute("data-placement", "top");
    linkElement.setAttribute("title", tooltipValue);
});

  var currentURL = window.location.href;
  var parts = currentURL.split('/');
  
  var url_view_edit = parts[7]; // view edit
  var interview_booking=parts[4];
  //alert(interview_booking);
 //all code align for css and closed open chat box. 
  var sidebar = document.getElementById("sidebar");
  var sidebar_right = document.querySelector(".sidebar_right");
  var section = document.querySelector(".section");
  var main = document.getElementById("main");
  var spans = sidebar.getElementsByTagName("span");
 
   
  for (var i = 0; i < spans.length; i++) {
    spans[i].style.display = "none";
  }
  sidebar.style.width = "90px";
  main.style.padding = "20px 30px";
  main.style.transition = "all 0.3s";
  main.style.width = "100%";
  main.style.marginTop = "88px !important";
// sidebar.style.height="78%";
 var sidebarWidth = 90; 
var chatWidth = 390;  
if(url_view_edit == 'notes'){
   var totalWidthMain = window.innerWidth - (sidebarWidth + chatWidth) + 14; 
}else if(interview_booking = 'interview_booking' ){
var totalWidthMain = window.innerWidth - (sidebarWidth + chatWidth)-5; 
//alert(totalWidthMain);
}
else{
   var totalWidthMain = window.innerWidth - (sidebarWidth + chatWidth) + 10; 
}
//alert(window.innerWidth);
  if (window.innerWidth >= 1400) {
    main.style.marginLeft = "83px";
    main.style.width = totalWidthMain +15+ "px";  
  }
  //check condition for view and update url
  if(url_view_edit == 'view_edit' || url_view_edit == 'all_documents' || url_view_edit == 'notes'){
      main.classList.remove('w-100');
      //section.style.width ="84%";
      if (window.innerWidth) {
          if(url_view_edit == 'all_documents'){
               main.style.marginLeft = "73px";
      main.style.width = totalWidthMain + 35 + "px";
          }else{
      main.style.marginLeft = "73px";
      main.style.width = totalWidthMain + 18 + "px";  
          }
  }
  }
}

// ----------------->this is use to show span design purpose<----------------- 
function showSpans() {
    
    //for  hide tooltip
  var navLinks = document.querySelectorAll(".nav-link");

// Iterate through each element and remove tooltip attributes
navLinks.forEach(function(linkElement) {
    linkElement.removeAttribute("data-toggle");
    linkElement.removeAttribute("data-placement");
    linkElement.removeAttribute("title");
});


   var currentURL = window.location.href;
  var parts = currentURL.split('/');
  var url_view_edit = parts[7]; // view edit
  //check url
 //all code align for css and closed open chat box. 
  var section = document.querySelector(".section");
  var main = document.getElementById("main");
  var sidebar = document.getElementById("sidebar");
  var spans = sidebar.getElementsByTagName("span");
  for (var i = 0; i < spans.length; i++) {
    spans[i].style.display = "";
  }
  sidebar.style.width = "18%";
//   section.style.width ="100%";
  main.style.padding = "20px 30px";
  main.style.transition = "all 0.3s";
  main.style.width = "100%";
  main.style.marginLeft = "303px";
  main.style.marginTop = "116px !important";
  
  if(url_view_edit == 'view_edit'){
     
      section.style.width ="100%";
  }
} 


function check_count_of_active_users(){
      $.ajax({
         url: '<?= base_url("admin/admin_functions/check_active") ?>', 
         method: 'GET',
         success: function(response) { 
              var count=0;
         response.forEach(function(adminData) {
             count++;
         });
         $('#show_count').text(count);
             
                  },
                 });
}


 function check_active(){
         var activeDiv = document.getElementById("show_users");
        
        $.ajax({
         url: '<?= base_url("admin/admin_functions/check_active") ?>', 
         method: 'GET',
         success: function(response) {
              activeDiv.style.display = "block";
         //console.log(response);  
         var count=0;
         response.forEach(function(adminData) {
             console.log(adminData);
             count++;
         var path=adminData.profileimg_path;
         var bg=(adminData.is_active === 'yes') ? 'bg-success' : 'bg-danger';
         if(adminData.is_active === 'yes'){
             var icon=`<i data-toggle="tooltip" data-placement="top" title="Online" style="color:#198754;font-size: 13px;position:relative;bottom:3px;" class="bi bi-circle-fill"></i>`;
         }else{
             var icon=`<i data-toggle="tooltip" data-placement="top" title="Offline" style="color:gray;font-size: 13px;position:relative;bottom:3px;" class="bi bi-clock-fill"></i>`; 
         }
         if(adminData.id == 1 || adminData.id == 2){
          var admin_name=adminData.first_name;   
         }else{
          var admin_name=adminData.first_name + " " + adminData.last_name; 
         }
         
        // console.log(admin_name);
         var html_show=`
         <div class="text-start">
         <div class="position-relative">
            <img src="${path}" style="cursor:pointer;" alt="avatar" class="mb-1 img d-inline">
            <span style="padding: 5px;cursor:pointer;" class="  position-absolute translate-middle  custom_badge">${icon} </span>
            
             <p class="d-inline ms-2">${admin_name}</p>
        </div>
       
        </div>
        `;
             $('#show_users').append(html_show);
    });          
    
           $('#show_count').text(count);
                 },
                 });
    }
    
    
//var evtSource = new EventSource("<= base_url("admin/admin_functions/check_date") ?>");

             //evtSource.onopen = function() {
			//	console.log("Connection to server opened.");
			 // };

		//	evtSource.onmessage = function(e) {
		     //textContent = "message: " + e.data;
			//console.log(textContent);
			//};

// 			evtSource.onerror = function() {
// 				console.log("EventSource failed.");
// 			};
function show_invalid_files(){
    $('#show_invalid_files').css({'display':'none'});
}
function allowDrop_chat(event) {
        event.preventDefault();
   }

 function handleDrop_chat(event) {
    
    event.preventDefault();
        //for uploads only valid files
        var chat_file = document.getElementById('chat_file');
        
        var files = event.dataTransfer.files;
        //for allowed types files
        var allowedTypes = ["jpeg", "png", "jpg","heic","mp4","docs","pdf","docx","xlsx"];
        var filteredFiles = Array.from(files).filter(function(file) {
            var fileType = file.name.split('.').pop().toLowerCase();
            return allowedTypes.includes(fileType);
        });
         //make array for all files with > 5mb for show errors 
        var dataTransfer = new DataTransfer();
        filteredFiles.reverse();
        filteredFiles.forEach(function(file) {
            dataTransfer.items.add(file);
        });
        if (filteredFiles.length > 0) {
         Show_ondrags_files_chat_before_insert(dataTransfer.files);
         //   chat_file.files = dataTransfer.files;
        }
    //      console.log(dataTransfer.files);
    // return;
        
     //make array for all files with < 5mb for upload       
     let files_new = dataTransfer.files;
     let filteredFiles_new = Array.from(files_new).filter(file => file.size < 5000000);
     let newDataTransfer = new DataTransfer();
     filteredFiles_new.forEach(file => {
          newDataTransfer.items.add(file);
        });
        //add this files into input type files
        chat_file.files = newDataTransfer.files;
       if (filteredFiles_new.length > 0) {
         store_doc_files_chat();
        }else{
            $('#show_invalid_files').css({'display':''});
            
            //show_invalid_files_msg
        }
       //store_doc_files_chat();
       //console.log(chat_file.files);
       //for submit form and hide the input type file
      // var txt="";
      
      if($("#chatbox").val() == '') {
        if_drag_files=true;
    //   $('#progress_chat').css({'display': 'block'});
       $('#progress_chat_bar_').width('0%');
        //$('#uploadButton').click();
        
        $('#chat_file').css('display', 'none');
        }

        
   
}

function Show_ondrags_files_chat_before_insert(response){
   
   
    var fileList = response;
    var response = Array.from(fileList);
    // if(noarray == 'noarray'){
    //     response= [fileList];
    // }
    
    var html = ' <ol  class="error_show_files"> <div class="row" style="margin-left: -26px;margin-right: 6px;" id="child_docs_static">  ';
    var count=0;
    var valid_count=0;
    var html_child='';
    response.forEach(function(response_data, index) {
        count++;
         
        //  console.log(count);
        var fileSizeInMB = response_data.size / (1024 * 1024);
        var msg='';
        
        var check_size=true;
        if(fileSizeInMB < 5){
            valid_count++;
            // console.log('when_drags->' + valid_count)
        }
        var hide_show='visibility: hidden;';
        if (fileSizeInMB > 5) {
            hide_show='';
            check_size=false;
            msg='This file size exceeds 5 MB';
            } 
            // console.log(fileSizeInMB.toFixed(2), 'MB');
            var html_progress;
            var error_for_invalid_files='';
            if(check_size  == true){
                error_for_invalid_files='';
               html_progress=`
               <div style="height: 14px;margin-top: -3px;width: 106%;margin-left: 9px;display:none;" id="progress_chat${valid_count}"   class="progress mb-2" role="progressbar"  aria-valuenow="0">
               <div id="progress_chat_bar_${valid_count}"   class="progress-bar progress-bar-striped progress-bar-animated bg-success"></div>
               </div>`; 
            }else{
                error_for_invalid_files='error_show_hide';
                html_progress=`<div style="margin-left: 9px;margin-top: -7px;font-size: 16px;font-style: italic;" class="text-danger">${msg}</div>`;
            }
           var doc_name_limit = response_data.name.length > 30 ? response_data.name.substring(0,30) + '...' : response_data.name;
      
         var fileExtension = getFileExtension(response_data.name);
            html += `<div id="static_show_docs_id${valid_count}" class="col-12 ${error_for_invalid_files}"  data-toggle="tooltip" data-placement="top" title="${response_data.name}" style="padding:0px;border-radius:8px;margin-left:-16px;">
                     <li class="border border-1 border-secondary files_box_chat" style="cursor:pointer;font-size: 15px;font-weight:bold;padding-top:5px;border-radius: 5px;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;text-transform:capitalize;">
                      ${doc_name_limit}
                      <button id="btn_remove${index}" value="${index}" style="display:inline-block;float: right;font-size: 12px;margin-top: 1px;${hide_show}" class="btn-close btn-sm" onclick="removeFile_chat(this,${index})"></button></li>
                    
                     ${html_progress}
                     </div>`;

          html_child += `<div id="static_show_docs_id${valid_count}" class="col-12 ${error_for_invalid_files}"    data-toggle="tooltip" data-placement="top" title="${response_data.name}" style="padding:0px;border-radius:8px;margin-left:-16px;">
                     <li class="border border-1 border-secondary files_box_chat" style="cursor:pointer;font-size: 15px;font-weight:bold;padding-top:5px;border-radius: 5px;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                      ${doc_name_limit}
                      <button id="btn_remove${index}" value="${index}" style="display:inline-block;float: right;font-size: 12px;margin-top: 1px;${hide_show}" class="btn-close btn-sm" onclick="removeFile_chat(this,${index})"></button></li>
                     
                      ${html_progress}
                     </div>`;
         
     });
  html += '</div></ol>';
//  <button id="btn_remove${index}" value="${index}" style="display:inline-block;float: right;font-size: 12px;margin-top: 1px;" class="btn-close btn-sm" onclick="removeFile_chat(this,${index})"></button></li>
//   $('#progress_chat').css({'display': 'none'});
//   $('#progress_chat_bar_').attr('aria-valuenow', 0);
//   $('#progress_chat_bar_').width('0%');
//   $('#progress_chat_bar_').text('0%');

  $('#show_drag_files_chat').show();
  //console.log(html);
  //console.log('i am hererererere');
  //$('#show_drag_files_chat').css({' margin-bottom':'-21px'});
 
  var currentValue_of_input = $('#lastinsertedids_chat').val();
   //console.log('value -->' + currentValue_of_input);
   if(currentValue_of_input != ''){
       //console.log('value -->if')
       $('#child_docs_static').append(html_child);
   }else{
      // console.log('value -->else')
       $('#title_of_docs_chat').append(html);
   }
  
  // console.log('i am here');
     $('#chatbox').css({
        'border-bottom-width': '0',
        'border-bottom-left-radius': '0px',
        'border-bottom-right-radius': '0px'
    });
    
 
   // if_drag_files=false;
   // console.log(if_drag_files);
    // $('#showhidereply_note').css({'display':'block'});
}


document.getElementById('chat_file').addEventListener('change', function() {
    
  
    // $('#show_img_chat_parent').css({'display':'block'});
    var files = $('#chat_file')[0].files;
    // var file = this.files[0]; 
    // console.log(files);
    // return;
    if (files) {
         Show_ondrags_files_chat_before_insert(files);
        //  return;
         //   chat_file.files = dataTransfer.files;
        }
    // if (files) {
    //     $('#show_img_chat').text(files.name); 
    //     $('#chat_file_val').val(files.name); 
    // }
    // Store the Document after select -> Mohsin
      store_doc_files_chat();
});

function hide_show_docs(){
     $('#show_img_chat_parent').css({'display':'none'});
     $('#show_img_chat').text('');
     $('#chat_file').val('');
     
}
// var lastinsertedids_chat;
// function store_doc_files_chat() {
//     var form_chat = document.getElementById('uploadForm_chat');
//     var formData = new FormData(form_chat);

//         formData.append('userTimezone', userTimezone);
//         formData.append('admin_id', admin_id_global);
   
   
//     var files_all = $('#chat_file')[0].files; 
//     var new_array_files = Array.from(files_all);
//     var currentValue = $('#lastinsertedids_chat').val();
// //for upload files one by one for show progress bar code by Rohit
//     var count_progress_id=0;
//     new_array_files.forEach(function(file) {
//          count_progress_id++;
//         //  console.log('when_upload->' + count_progress_id);
//           $('#progress_chat' + count_progress_id).css({'display': 'block'});
         
//         formData.append('file', file);
//         $.ajax({
//         method: "POST",
//         url: "<= base_url("admin/admin_functions/store_doc_files_chat") ?>",
//         data: formData,
//         processData: false, 
//         contentType: false, 
//           xhr: function() {
//         var xhr = new window.XMLHttpRequest();
//         xhr.upload.addEventListener('progress', function(e) {
//             if (e.lengthComputable) {
//                 var percentComplete = Math.round((e.loaded / e.total) * 100);
//                 $('#progress_chat_bar_' + count_progress_id).width(percentComplete + '%');
//                 $('#progress_chat_bar_' + count_progress_id).text(percentComplete + '%');
//                 $('#progress_chat_bar_' + count_progress_id).attr('aria-valuenow', percentComplete);
//             }
//         }, false);
//         return xhr;
//     },
//         success: function(response) {
//             // console.log(response);
//             // return;
//             if(response.data){
//                 hide_show_docs();
//                 Show_ondrags_files_chat(response.data);
//                 lastinsertedids_chat = response.lastinsertedids_chat;
//                 // $('.error_show_files').remove();
//                 $('#static_show_docs_id' + count_progress_id).remove();
//                 // console.log(count_progress_id);
//                 //$('#lastinsertedids_chat').val(lastinsertedids_chat);
//                 try {
//                     var currentArray = currentValue ? JSON.parse(currentValue) : [];
//                     var updatedArray = currentArray.concat(lastinsertedids_chat);
//                     $('#lastinsertedids_chat').val(JSON.stringify(updatedArray));
//                 } catch (error) {
//                     console.error('Error occurred while processing the current value:', error);
//                 }
//             }
            
//         },
//         error: function(xhr, status, error) {
//             console.error(error);
//         }
//     }); 
//     });
// }
var lastinsertedids_chat;

function store_doc_files_chat() {
    var form_chat = document.getElementById('uploadForm_chat');
    var formData = new FormData(form_chat);

    formData.append('userTimezone', userTimezone);
    formData.append('admin_id', admin_id_global);

    var files_all = $('#chat_file')[0].files; 
    var new_array_files = Array.from(files_all).filter(file => file.size < 5 * 1024 * 1024);
    // console.log('old_value'+ currentValue);
    var count_progress_id = 0;
      //Array_start_here
      new_array_files.forEach(function(file, index) {
    var currentValue = $('#lastinsertedids_chat').val();
      console.log(currentValue);
    var count_progress_id = index + 1; 
    // new_array_files.forEach(function(file) {
    //     count_progress_id++;
        // alert(count_progress_id);
        $('#progress_chat' + count_progress_id).css({'display': 'block'});
        formData.append('file', file);

        $.ajax({
            method: "POST",
            url: "<?= base_url("admin/admin_functions/store_doc_files_chat") ?>",
            data: formData,
            processData: false, 
            contentType: false, 
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        var percentComplete = Math.round((e.loaded / e.total) * 100);
                        $('#progress_chat_bar_' + count_progress_id).width(percentComplete + '%');
                        $('#progress_chat_bar_' + count_progress_id).text(percentComplete + '%');
                        $('#progress_chat_bar_' + count_progress_id).attr('aria-valuenow', percentComplete);
                    }
                }, false);
                return xhr;
            },
            success: function(response) {
                if(response.data){
                    hide_show_docs();
                    Show_ondrags_files_chat(response.data);
                    // lastinsertedids_chat = response.lastinsertedids_chat;
                    // console.log('last_id',lastinsertedids_chat);
                    $('#static_show_docs_id' + count_progress_id).remove();
                    $('.error_show_hide').remove();
                    try {
             var lastinsert_chat = response.lastinsertedids_chat;
             var currentValue = $('#lastinsertedids_chat').val();
             var currentArray = currentValue ? JSON.parse(currentValue) : [];
             currentArray.push(lastinsert_chat);
             $('#lastinsertedids_chat').val(JSON.stringify(currentArray));
                    } catch (error) {
                        console.error('Error occurred while processing the current value:', error);
                    }
                }
                
            },
            error: function(xhr, status, error) {
                console.error(error);
                // Handle errors here
            }
        }); 
        
    });
}


function Show_ondrags_files_chat(response){
   // console.log(response);
   // return;
    var html = ' <ol id="older_list"> <div class="row" style="margin-left: -26px;margin-right: 6px;" id="child_docs">  ';
    var count=0;
    var html_child='';
    
     response.forEach(function(response_data) {
        count++;
         // var doc_name_limit;
           var doc_name_limit = response_data.documents.length > 30 ? response_data.documents.substring(0,30) + '...' : response_data.documents;
        //  if(innerWidth <= 1920 && innerWidth >= 1800){
        //      var doc_name_limit = response_data.documents.length > 50 ? response_data.documents.substring(0,50) + '...' : response_data.documents;
        //  }else if(innerWidth <= 1800 && innerWidth >= 1600){
        //      var doc_name_limit =response_data.documents.length > 40 ? response_data.documents.substring(0,40) + '...' : response_data.documents;
        //  }else if(innerWidth <= 1600 && innerWidth >= 1450){
        //      var doc_name_limit =response_data.documents.length > 30 ? response_data.documents.substring(0,30) + '...' : response_data.documents;
        //  }
        //  else{
        //     var doc_name_limit =response_data.documents.length > 20 ? response_data.documents.substring(0,20) + '...' : response_data.documents; 
        //  }
         var fileExtension = getFileExtension(response_data.documents);
            html += `<div class="col-12"  data-toggle="tooltip" data-placement="top" title="${response_data.documents}" style="padding:0px;border-radius:8px;margin-left:-16px;">
                     <li class="border border-1 border-secondary files_box_chat" style="cursor:pointer;font-size: 15px;font-weight:bold;padding-top:5px;border-radius: 5px;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;text-transform:capitalize;">
                      ${doc_name_limit}
                     <button id="btn_remove${response_data.id}" value="${response_data.id}" style="display:inline-block;float: right;font-size: 12px;margin-top: 1px;" class="btn-close btn-sm" onclick="removeFile_chat(this,${response_data.id})"></button></li></div>`;

          html_child += `<div class="col-12"  data-toggle="tooltip" data-placement="top" title="${response_data.documents}" style="padding:0px;border-radius:8px;margin-left:-16px;">
                     <li class="border border-1 border-secondary files_box_chat" style="cursor:pointer;font-size: 15px;font-weight:bold;padding-top:5px;border-radius: 5px;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                      ${doc_name_limit}
                     <button id="btn_remove${response_data.id}" value="${response_data.id}" style="display:inline-block;float: right;font-size: 12px;margin-top: 1px;" class="btn-close btn-sm" onclick="removeFile_chat(this,${response_data.id})"></button></li></div>`;
         
     });
  html += '</div></ol>';

  $('#progress_chat').css({'display': 'none'});
  $('#progress_chat_bar_').attr('aria-valuenow', 0);
  $('#progress_chat_bar_').width('0%');
  $('#progress_chat_bar_').text('0%');

  $('#show_drag_files_chat').show();
  //console.log(html);
  //console.log('i am hererererere');
  //$('#show_drag_files_chat').css({' margin-bottom':'-21px'});
 
  var currentValue_of_input = $('#lastinsertedids_chat').val();
   //console.log('value -->' + currentValue_of_input);
   if(currentValue_of_input != ''){
       //console.log('value -->if')
       $('#child_docs').append(html_child);
   }else{
      // console.log('value -->else')
       $('#title_of_docs_chat').append(html);
   }
  
  // console.log('i am here');
     $('#chatbox').css({
        'border-bottom-width': '0',
        'border-bottom-left-radius': '0px',
        'border-bottom-right-radius': '0px'
    });
    
 
   // if_drag_files=false;
   // console.log(if_drag_files);
    // $('#showhidereply_note').css({'display':'block'});
}

function getFileExtension(filename) {
    return filename.split('.').pop();
}

function removeFile_chat(button,id) {
    //console.log(id);
    
    var val_of_lastinsertedids_chat = $('#lastinsertedids_chat').val();
    var idsArray = val_of_lastinsertedids_chat ? JSON.parse(val_of_lastinsertedids_chat) : [];
    var indexToRemove = idsArray.indexOf(id);
    if (indexToRemove !== -1) {
        idsArray.splice(indexToRemove, 1);
    }
    $('#lastinsertedids_chat').val(JSON.stringify(idsArray));
     $.ajax({
    method:"POST",
    url:"<?= base_url("admin/admin_functions/delete_chat_single") ?>",
    data:{id},
    success: function(response) {
        console.log(response);
    if(response){
       $(button).closest('div').remove();  
        updateFileInput_chat();
       
    }    
        
    },
     });
   
    
}
function updateFileInput_chat() {
    var titleElement = $('#title_of_docs_chat');
    var filesCount = titleElement.find('ol li').length;
    if (filesCount === 0) {
        $('#lastinsertedids_chat').val('');
        $('#chat_file').val('');
        // $('#images_popup').modal('hide');
        $('#chat_file').css('display', 'block');
        $('#show_drag_files_chat').hide();
         $('#older_list').each(function() {
            $(this).remove();
        });
        $('#chatbox').css({
        'border-radius': '10px',
    });
    }
}

function check_icon_chat(icon_type) {
    
    console.log(icon_type);
    var icon = "";
    if (icon_type === 'pdf' || icon_type === 'Pdf' || icon_type === 'PDF') {
        icon = "<i style='color:#f34646;'  class='bi bi-file-earmark-pdf-fill'></i>";
    } else if (icon_type === 'xls' || icon_type === 'xlsx' || icon_type === 'xlsm' || icon_type === 'xlsb' || icon_type === 'xltx' || icon_type === 'xltm') {
        icon = "<i style='color:#055837c9;' class='bi bi-file-earmark-excel-fill'></i>";
    } else if (icon_type === 'mp3') {
        icon = "<i class='bi bi-file-earmark-mp3'></i>";
    } else if (icon_type === 'mp4') {
        icon = "<i class='bi bi-file-earmark-play-fill'></i></i>";
    } else if(icon_type == 'png' || icon_type == 'jpg' || icon_type == 'jpeg' || icon_type == 'heic'){
        icon = '<i style="color:#6eab7f;"  class="bi bi-file-image"></i>';  
    }else{
        icon = "<i style='color:#3b8fe7;' class='bi bi-file-earmark-word-fill'></i>";
    }
    //console.log(icon_type); // This line will not be executed if placed after the return statement
    return icon;
}
function check_icon_image(icon_type) {
    var icon = "";
    if (icon_type === 'png' || icon_type === 'jpg' || icon_type === 'jpeg' || icon_type === 'heic') {
        icon = '<i style="color:#6eab7f;"  class="bi bi-file-image"></i>';     
    }
    return icon;
}
    </script>