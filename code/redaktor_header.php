<div class="starter-template">
    <h1>LOGOS POLYTECHNIKOS</h1>

    <?php if(!empty($zprava)){ ?>
        <div class="alert alert-<?php echo $kod_zpravy; ?> alert-dismissible text-center">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <b> <?php echo $zprava; ?> </b>
        </div>
    <?php } $zprava = ''; $kod_zpravy = ''; ?>
</div>
