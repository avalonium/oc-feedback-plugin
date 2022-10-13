<?php if ($formModel->utm): ?>
    <div class="control-simplelist is-divided size-small mb-0" data-control="simplelist">
        <ul class="mb-0">
            <?php foreach ($formModel->utm as $key => $value): ?>
            <li><strong><?= $key ?></strong> - <?= e($value) ?>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>