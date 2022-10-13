<?php if ($formModel->message): ?>
    <div class="callout callout-success no-icon no-subheader">
        <div class="header">
            <h3 class="oc-icon-comment-o"><?= e($formModel->message) ?></h3>
        </div>
    </div>
<?php endif ?>