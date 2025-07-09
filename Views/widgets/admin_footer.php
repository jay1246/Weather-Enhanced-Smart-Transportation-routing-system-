<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(".text_editor").summernote({
        height: 400,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['height', ['height']],
            //   ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']],
        ]
    });
</script>

<script>
    (function() {
        "use strict";

        /**
         * Easy selector helper function
         */
        const select = (el, all = false) => {
            el = el.trim()
            if (all) {
                return [...document.querySelectorAll(el)]
            } else {
                return document.querySelector(el)
            }
        }
        /**
         * Easy event listener function
         */
        const on = (type, el, listener, all = false) => {
            if (all) {
                select(el, all).forEach(e => e.addEventListener(type, listener))
            } else {
                select(el, all).addEventListener(type, listener)
            }
        }


        /**
         * Sidebar toggle
         */
        if (select('.toggle-sidebar-btn')) {
            // console.log(select('.toggle-sidebar-btn'));
            on('click', '.toggle-sidebar-btn', function(e) {
                select('body').classList.toggle('toggle-sidebar')
            })
        }

        const datatables = select('.display', true)
        datatables.forEach(datatable => {
            new simpleDatatables.DataTable(datatable);
        })

        $('.display').DataTable();

    })();


    // $(document).ready(function () {
    // });
</script>

</script>

    <style>
           .custom-background {
        background-color: #28a745; 
        color: #fff; 
    }
    </style>
    
          <!--    <img-->
          <!--      src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp"-->
          <!--      alt="avatar 3"-->
          <!--      style="    width: 60px;-->
          <!--                 height: 60px;-->
          <!--                 position: fixed;-->
          <!--                 cursor: pointer;-->
          <!--                 bottom: 10px;-->
          <!--                 left: 40px;-->
          <!--                 object-fit: cover;"-->
          <!--      id="avatar"-->
          <!--      onclick="myFunction()">-->
                
          <!--          <div class="card" id="chat2" style="position: fixed;-->
          <!--                                              bottom: 10px;-->
          <!--                                              left: 10px;-->
          <!--                                              display: block;-->
          <!--                                              z-index: 66;">-->
          <!--              <div class="card-header d-flex justify-content-between align-items-center p-3">-->
          <!--                  <h5 class="mb-0">Chat</h5>-->
          <!--                  <button type="button" class="close" id="toggleButton" aria-label="Toggle">-->
          <!--                      <span aria-hidden="true">&times;</span>-->
          <!--                  </button>-->
          <!--              </div>-->
          <!--                    <div class="card-body" data-mdb-perfect-scrollbar="true" style="position: relative; height: 400px">-->

          <!--  <div class="d-flex flex-row justify-content-start">-->
          <!--      <div>-->
          <!--    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp"-->
          <!--      alt="avatar 1" style="width: 45px; height: 45%;">-->
          <!--      </div>-->
          <!--      <div style="font-size: 10px; margin-top: 56px; margin-left:-31px;-->
          <!--       color: #a2aab7;">rohit-->
                    
          <!--      </div>-->
          <!--    <div>-->
          <!--      <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">Hi</p>-->
          <!--      <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">How are you ...???-->
          <!--      </p>-->
          <!--      <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">What are you doing-->
          <!--        tomorrow?</p>-->
          <!--    </div>-->
          <!--  </div>-->

          <!--  <div class="divider d-flex align-items-center mb-4">-->
          <!--    <p class="text-center mx-3 mb-0" style="color: #a2aab7;">Today</p>-->
          <!--  </div>-->

          <!--  <div class="d-flex flex-row justify-content-end mb-4 pt-1"> -->
          <!-- <div style="font-size: 9px; -->
          <!--           margin-top: 48px;-->
          <!--           margin-right: -195px; color: #a2aab7;">meenu-->
          <!--      </div>-->
          <!--    <div>-->
          <!--      <p class="small p-2 me-3 mb-1 text-white rounded-3 custom-background">Hiii, I'm good.</p>-->
          <!--       <p class="small p-2 me-3 mb-1 text-white rounded-3 custom-background">How are you doing?</p>               -->
          <!--    </div>-->
          <!--    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp"-->
          <!--      alt="avatar 1" style="width: 45px; height: 100%;">-->
          <!--  </div>-->
          <!--</div>-->
          <!--       <div class="card-footer text-muted d-flex justify-content-start align-items-center p-3">-->
          <!--  <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp"-->
          <!--    alt="avatar 3" style="width: 40px; height: 100%;">-->
          <!--  <input type="text" class="form-control form-control-lg" id="exampleFormControlInput1"-->
          <!--    placeholder="Type message">-->
          <!--  <a class="ms-1 text-muted" href="#!"><i class="fas fa-paperclip"></i></a>-->
          <!--  <a class="ms-3 text-muted" href="#!"><i class="fas fa-smile"></i></a>-->
          <!--  <a class="ms-3" href="#!"><i class="fas fa-paper-plane"></i></a>-->
          <!--</div>-->
          
          <!--          </div>-->


   <script>
//         const chatCard = document.getElementById("chat2");
//         const toggleButton = document.getElementById("toggleButton");
//         const avatar = document.getElementById("avatar");
//         let isChatOpen = false;
//         chatCard.style.display = "none";
//             toggleButton.addEventListener("click", function() {
//             isChatOpen = !isChatOpen;
//             chatCard.style.display = isChatOpen ? "block" : "none";
//         });

//         avatar.addEventListener("click", function() {
//             isChatOpen = true;
//             chatCard.style.display = "block";
//         });
//     </script>

