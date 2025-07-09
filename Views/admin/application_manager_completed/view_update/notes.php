
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <?php   
  if (session()->has('admin_account_type')) {
       $admin_account_type =  session()->get('admin_account_type');
    
       $admin_id =  session()->get('admin_id');
       $admin_name=session()->get('admin_name');
       $admin_email=session()->get('admin_email');
  }     
  
?>

           <?php   if (session()->has('admin_account_type')) {?>

<section style="background-color: #e9ecef; margin-top: 3px;">
  <div class="container py-5">
       
    <div class="row">
        
        <div class="card" id="chat3" style="border-radius: 0px;">
          <div class="card-body">
            <div class="row">
              <div class="col-md-12 col-lg-12 col-xl-12">
                <div class="pt-3 pe-3" data-mdb-perfect-scrollbar="true"
                 style="position: relative; max-height: 400px; width: 100%; overflow: auto; margin-top: -2px; ">
                  <div class="d-flex flex-row justify-content-start">
                
                     
                  <div id="result_notes" >
                   </div>
                    </div>
                  </div>

                
         
        
         
                   </div>
                </div>
                 <div class="text-muted d-flex justify-content-start align-items-center pe-3 pt-3 mt-2">
                 <input type="text" class="form-control form-control-lg" id="notes" placeholder="Add Comment" style="font-size: 16px;">
                 <svg  xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="green" class="bi bi-send" viewBox="0 0 16 16" style="margin-left: 10px;" onclick="notes()">
                 <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                 </svg>
                </div>
              </div>
            </div>
          </div>
        
      </div>
    </div>
  </div>
</section>

<?php  }?>
<script>



function notes() {
    var notes = document.getElementById("notes").value;
    var pointer_id = <?= $pointer_id ?>;
    alert(pointer_id);

    $.ajax({
        method: "POST",
        url: "<?= base_url("admin/admin_functions/notes") ?>",
        data: {
            notes: notes,
            pointer_id: pointer_id
        },
        contentType: "application/x-www-form-urlencoded",
        success: function(response) {
            if (response) {
                //   fetchData_last();
                document.getElementById("notes").value = "";
            }
        },
        error: function(error) {
            console.error(error);
        }
    });
}

$(document).ready(function() {
    fetchnotes();
});

function fetchnotes() {
    $.ajax({
        url: '<?= base_url("admin/admin_functions/notes_fetch") ?>',
        method: 'GET',
        success: function(response) {
            response.forEach(function(item) {
                var notespara = `
                    <div class="d-flex flex-row justify-content-between align-items-center" style="position: relative; max-height: 400px; width: 100%; overflow: auto; margin-top: -2px;">
                        <div class="d-flex flex-row align-items-center">
                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp" alt="avatar 1" style="width: 44px; height: 37%; margin-top: -2px;">
                            <p class="small p-2 mb-1 rounded-3 mt-3 text-start" style="background-color: #f8f8f8;">${item.message }
                                <span class="small d-block text-end" style="font-size: 9px; margin-top: 1px; margin-left: auto; font-style: italic;">${formatTimestamp(item.created_at)}</span>
                            </p>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                &#8942;
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="base_url("admin/admin_functions/notes_fetch") " onclick="editNote(${item.id})">Edit</a>
                                <a class="dropdown-item" href="base_url("admin/admin_functions/notes_fetch") " onclick="deleteNote(${item.id})">Delete</a>
                            </div>
                        </div>
                    </div>
                `;

                $('#result_notes').append(notespara);
            });
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

function editNote(noteId) {
    console.log('Edit Note:', noteId);
}

function deleteNote(noteId) {
    console.log('Delete Note:', noteId);
}


     function fetchnotes_last() {
            $.ajax({
                url: '<?= base_url("admin/admin_functions/notes_fetch") ?>', 
                method: 'GET',
             success: function(response) {
            if (response.length > 0) {
                var lastItem = response.pop();
                                var notespara = `
   
                 style="position: relative; max-height: 400px; width: 100%; overflow: auto; margin-top: -2px; ">${lastItem.message }

                  <div class="d-flex flex-row justify-content-start">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp"
                alt="avatar 1" style="width: 44px; height: 37%; margin-top: -18px;">
                      <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">${formatTimestamp(lastItem.created_at)}
                        </p>
  </div>
`;
  
               if (lastItem.pointer_id == <?= $pointer_id ?>) {
                            $('#result_notes').append(notespara);
                        } else {
                            $('#result_notes').append(notespara);
                        }
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
            });
        } 
      
 
 function editMessage(messageId) {
    // Assuming you have a prompt or modal to get the new message content
    var newMessage = prompt("Enter the new message:");

    // Perform an AJAX request to update the message on the server
    $.ajax({
        method: "POST",
        url: "/update_message", // Replace with your server endpoint
        data: {
            messageId: messageId,
            newMessage: newMessage
        },
        success: function(response) {
            // Update the message content on the client side
            $(`[data-message-id="${messageId}"] .message-text`).text(newMessage);
        },
        error: function(error) {
            console.error(error);
        }
    });
}

 
       
</script>

  



 