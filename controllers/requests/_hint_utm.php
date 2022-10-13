<?php if ($formModel->utm): ?>
    <div class="control-simplelist is-divided size-small" data-control="simplelist">
        <ul>
            <?php foreach ($formModel->utm as $key => $value): ?>
            <li><strong><?= $key ?></strong> - <?= e($value) ?>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>