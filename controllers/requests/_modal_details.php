<?php if (!$this->fatalError): ?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="popup">×</button>
    </div>

    <div class="modal-body">
        <div class="control-simplelist is-divided is-scrollable size-small" data-control="simplelist">
            <ul>
                <?php foreach ($details as $key => $value): ?>
                <li><strong><?= $key ?></strong> - <?= e($value) ?>
                    <?php endforeach ?>
            </ul>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="popup"><?= e(trans('backend::lang.form.close')) ?></button>
    </div>

<?php else: ?>

    <div class="modal-body">
        <p class="flash-message static error"><?= e($this->fatalError) ?></p>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="popup"><?= e(trans('backend::lang.form.close')) ?></button>
    </div>

<?php endif ?>