
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title><?= isset($page) ? $page : 'Dashboard' ?> - Aqato</title>
    <link rel="icon" type="image/x-icon" href="https://www.pngall.com/wp-content/uploads/2016/05/Kangaroo-PNG-File.png">

    <!-- <link rel="icon" type="image/x-icon" href="data:image/png;base64,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"> -->

    <!---------- header_scripts  ------------->
    <?= $this->include("widgets/header_scripts.php") ?>

    <!---------- admin_header  ------------->
    <!-- <= $this->include("widgets/admin_header.php") ?> -->
</head>

<style>
    .onhover_pointer{
        color: red !important;
    }
    .onhover_pointer:hover{
        cursor: pointer;
    }

    .pagetitle {
        margin-top: 10px;
    }

    tbody,
    td,
    tfoot,
    th,
    thead,
    tr {
        border-color: none;
        border-style: none;
    }

    .card-header .text-end {
        margin-left: 7px;

    }

    thead {
        border-top: 1px solid #ebebeb !important;
    }

    #cover-spin {
        position: fixed;
        width: 100%;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        background-color: rgba(251, 251, 251, 0.6);
        z-index: 9999;
        display: none;
    }

    #loader_img {
        position: fixed;
        left: 50%;
        top: 50%;
        pointer-events: none;
    }

    * {
        font-family: "Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif !important;
    }

    b {
        font-weight: 600 !important;
    }
</style>
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

<body class="bg-Ghostwhite">


    <div id="Internet_alert_box" style="display: none;" class="bg-danger text-center text-white p-1 w-100">
        <h3> There is no internet available. searching the internet... </h3>
    </div>

    <!---------- admin_sidebar UI ------------->
    <?= $this->include("widgets/admin_navbar.php") ?>

    <div style="display: flex;">
        <!---------- admin_sidebar UI ------------->
        <?= $this->include("widgets/admin_sidebar.php") ?>

        <!---------- main UI ------------->

        <?= $this->rendersection("main") ?>
        <?php 
        if (session()->has('admin_account_type')) {
            //   print_r($_SESSION);
               $admin_account_type =  session()->get('admin_account_type');
             //  echo $admin_account_type;
               if($admin_account_type == 'admin'){
                    ?>
                        
                    <!--chat_box_side_bar-->
                    <?= $this->include("widgets/admin_sidebar_right.php") ?>
          
                    <?php
               }
          }   
        ?>
    </div>

    <!---------- admin footer UI ------------->
    <!-- <= $this->include("widgets/admin_footer.php") ?> -->

    <!---------- footer_scripts ------------->
    <?= $this->include("widgets/footer_scripts.php") ?>

    <!---------- footer_scripts ------------->
    <?= $this->include("widgets/admin_footer.php") ?>
 <?= $this->include("widgets/footer.php") ?>
    <!-- on click Button Loader in full screen  add in Futter file   -->
    <div id="cover-spin" style="display: none;">
        <div id="loader_img">
            <img src="https://attc.aqato.com.au/public/assets/image/admin/loader.gif" style="width: 100px; height:auto">
        </div>
    </div>
    <!--<button onclick="__check_login_session()">Check Login</button>-->

    <!---------- custom_script -->
    <?= $this->rendersection("custom_script") ?>

    <?= $this->include("widgets/comman_scripts.php") ?>

    <!-- End #main -->
    <script>
        $(document).ready(function() {
            $('#mail_template_table').DataTable();
        });
        
        
        function __check_login_session(){
            $.get("<?= base_url() ?>/admin/check_user_login_ajax",function(res){
               console.log(res); 
               res = JSON.parse(res);
               if(res == false){
                   location.reload();
               }
            });
        }
        
        // Run Every 10 Sec
        setInterval(function() {__check_login_session()}, 10000);
        
        // Auto Logout Session Reading
        window.addEventListener('beforeunload', function(event) {
            // Make an AJAX call to update is_login to 0
            fetch('<?= base_url("admin/logout") ?>', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ is_login: 0 })
            });
        });
        
        
        
        
        
        // 
        
        function calling_date_recorder(){
            $.get("<?= base_url() ?>/make_date_store_init",function(res){
                console.log("Calling API");
            });
        }
        
        // Call Date Recorder
        
        calling_date_recorder();
        
        // Notification Code 
        
        let permission = Notification.permission;
        
        if(permission === "granted"){
        //   showNotification_show();
        } else if(permission === "default"){
          requestAndShowPermission();
        } else {
        //   alert("Use normal alert");
        }
        
        // // 
        // function requestAndShowPermission() {
        //     Notification.requestPermission(function (permission) {
        //         if (permission === "granted") {
        //             showNotification();
        //         }
        //     });
        // }
        
        // // 
        function showNotification(msg) {
          //if(document.visibilityState === "visible") {
             //  return;
          //   }
           
          console.log("here");
          let title = "Group Chat";
        //   let icon = 'https://homepages.cae.wisc.edu/~ece533/images/airplane.png';
          let body = msg;
          var notification = new Notification(title, { body });
          console.log(notification);
          notification.onclick = () => {
                notification.close();
                window.parent.focus();
          }
        }
        
         function showNotification_show() {
          //if(document.visibilityState === "visible") {
             //  return;
          //   }
           
          console.log("here");
          let title = "Group Chat";
        //   let icon = 'https://homepages.cae.wisc.edu/~ece533/images/airplane.png';
          let body = "dsadsad";
          var notification = new Notification(title, { body });
          console.log(notification);
          notification.onclick = () => {
                notification.close();
                window.parent.focus();
          }
        }
        
        // End of Notification code not proccedd because in mac required mac enable using setting
        
        
        // Localstorage concept for sound
        
        function setLocalSound(is_play = 0){
            localStorage.setItem("local_sound", is_play);
        }
        
        function getLocalSound(){
            var local_sound = localStorage.getItem("local_sound");
            local_sound = (local_sound == null) ? 0 : local_sound;
            // console.log(local_sound);
            return local_sound;
        }
        
        
        

        
        
    </script>




</body>

</html>