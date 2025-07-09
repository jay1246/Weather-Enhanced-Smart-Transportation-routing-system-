<style>
    .footer {
        position: fixed;
        bottom: 0;
        font-size: 90%;
        width: 100%;
        height: 30px !important;
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
</style>
<footer class="footer bg-green text-white text-center">
    <div class="pt-1">
        Copyright © <?= date('Y') ?> Australian Qualifications & Training Overseas. All Rights Reserved.
    </div>
</footer>

<!-- on click Button Loader in full screen  add in Futter file   -->
<div id="cover-spin" style="display: none;">
    <div id="loader_img">
        <img src="https://attc.aqato.com.au/public/assets/image/admin/loader.gif" style="width: 100px; height:auto">
    </div>
</div>