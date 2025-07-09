    <!------------------------ Comman script for all page  ------------------->

    <!-- user for text validation  -->
    <script>
        function __check__form__validation(that, isAlphabet) {
            var msg = true;
            if (that.type == "email") {
                var emailString = $(that).val();
                $(that).val(emailString.toLowerCase());
            }
            if (that.type == "email" && isAlphabet == true) {
                msg = validEmailCheckForm(that);
                console.log("Email");
                return msg;
            }
            if (isAlphabet) {
                console.log("Alpha");
                if (checkValidAlpha(that, that.value) == false) {
                    console.log("Form Checking False");
                    msg = false;
                }
            }
            return msg;
        }

        function checkValidAlpha(that, string) {
            removeErrorMsg(that);
            if (string == "") {
                return true;
            }
            var result = /^[a-zA-Z ]+$/.test(string);
            if (result == false) {
                includeErrorMsg(that, "Don't use any number or special symbols");
            }
            checkValidity();
            return result;
        }

        function includeErrorMsg(that, msgText) {
            $(that).after(`
            <input type='hidden' class='__valid_check_form' value='1'>
            <p class='text-danger'>${msgText}</p>`);
        }

        function removeErrorMsg(that) {
            $(that).next().remove();
            $(that).next().remove();
        }

        function checkValidity() {
            if ($(".__valid_check_form").length > 0) {
                $("#action_validation_btn").attr("disabled", true);
            } else {
                $("#action_validation_btn").removeAttr("disabled");
            }
        }

        function validEmailCheckForm(input) {
            var msg = true;
            removeErrorMsg(input);
            if (input.value != "") {
                var validRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
                if (input.value.match(validRegex)) {
                    // 

                } else {
                    // $(input).css("border", "1px solid red");
                    email_error = true;
                    includeErrorMsg(input, "Invalid Email !");
                    msg = false;
                }
            } else {
                // $(input).css("border", "1px solid #ced4da");

            }
            checkValidity();
            return msg;
        }
    </script>




    <!-- Stage 1 > all page form on save and exit click  -->
    <script>
        function checkInternetConnection() {
            var status = navigator.onLine;
            if (status) {
                $('body').css('pointer-events', '');
                $('#Internet_alert_box').hide(200);
                // console.log('Internet Available !!');
            } else {
                $('body').css('pointer-events', 'none');
                $('#Internet_alert_box').show(100);
                console.log('No internet Available !!');
            }
            setTimeout(function() {
                checkInternetConnection();
            }, 1000);
        }
        $(document).ready(function() {
            checkInternetConnection();
        });
    </script>


    <!-- custome alert popup for all website  -->
    <div id="custom_alert_popup_div" style="display: none;"> </div>
    <script>
        function custom_alert_popup_show(header = '', body_msg, close_btn_text = 'ok', close_btn_css = 'btn-info', other_btn = false, other_btn_name = '', other_btn_class = '', other_btn_id = '',cancel_id ='') {
            var msg_header = ``;
            if (header.length > 2) {
                msg_header = `<div class="modal-header">` + header + ` </div>`;
            }
            var msg_close_btn = `<button type="button" id="` + cancel_id+ `" onclick="custom_alert_popup_close('')"  class="btn ` + close_btn_css + `" data-bs-dismiss="modal">` + close_btn_text + ` </button>`;
            var msg_btn = ``;
            if (other_btn) {
                msg_btn = ` <button type="button" class="btn ` + other_btn_class + `"  onclick="custom_alert_popup_close('` + other_btn_id + `')"  id="` + other_btn_id + `">` + other_btn_name + `</button>`;
            }
            $('#custom_alert_popup_div').show(50);
            var msg = `
                     <div class="modal  show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true" role="dialog" style="display: block;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            ` + msg_header + `
                                <div class="modal-body">
                                ` + body_msg + `
                                </div>
                                <div class="modal-footer" style="padding:0px">
                                 ` + msg_close_btn + `
                                ` + msg_btn + `
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-backdrop fade show"></div>`;
            $('#custom_alert_popup_div').html(msg);
        }

        function custom_alert_popup_close(other_btn_id) {
            if (other_btn_id.length > 2) {
                $('#custom_alert_popup_div').hide(10);
                return true;
            }
            $('#custom_alert_popup_div').hide(10);
            return false;
        }
        // custom_alert_popup_show(header = 'alert', body_msg = "sorry gile noasdsa", close_btn_text = 'no', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'HJ12');

        // $("#HJ12").click(function() {
        //     console.log("--------: " + custom_alert_popup_close('HJ12'));

        // })
    </script>