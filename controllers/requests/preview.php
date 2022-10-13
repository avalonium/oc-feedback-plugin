<?php if (!$this->fatalError): ?>

    <div class="scoreboard">
        <div data-control="toolbar">
            <?= $this->makePartial('preview_scoreboard') ?>
        </div>
    </div>

    <div class="form-buttons">
        <div class="loading-indicator-container">
            <?= $this->makePartial('preview_toolbar') ?>
        </div>
    </div>

    <?= $this->formRenderPreview() ?>

<?php else: ?>

    <p class="flash-message static error"><?= e($this->fatalError) ?></p>
    <p><a href="<?= Backend::url('avalonium/feedback/requests') ?>" class="btn btn-default"><?= e(trans('backend::lang.form.return_to_list')) ?></a></p>

<?php endif ?>
