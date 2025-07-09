<div class="keyword-wrapper">
    <?php
    $keywords = findDataByTable("mail_template_keyword");
    foreach ($keywords as $keyword) {
    ?>
        <div class="keyword border my-2 rounded">
            <input type="button" value="<?= $keyword->name ?>" class="btn" />
        </div>
    <?php
    }
    ?>
</div>