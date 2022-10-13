<?php if ($formModel->email): ?>
    <div class="callout callout-info no-icon no-subheader">
        <div class="header">
            <h3 class="oc-icon-envelope-o"><?= e($formModel->email) ?></h3>
        </div>
    </div>
<?php endif ?>