<div class="btn-group">
    <a href="<?= Backend::url('avalonium/feedback/requests') ?>"
       class="btn btn-default oc-icon-chevron-left"><?= __('Return') ?></a>
</div>

<div class="btn-group">
    <?= Form::button(__('Process'), [
        'class' => 'btn btn-success oc-icon-check',
        'data-request' => 'onProcess',
        'data-request-confirm' => 'Are you sure you want to process this request?'
    ]) ?>
    <?= Form::button(__('Cancel'), [
        'class' => 'btn btn-warning oc-icon-times',
        'data-request' => 'onCancel',
        'data-request-confirm' => 'Are you sure you want to cancel this request?'
    ]) ?>
</div>