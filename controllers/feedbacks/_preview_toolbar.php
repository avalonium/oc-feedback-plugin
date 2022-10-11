<div class="btn-group">
    <a href="<?= Backend::url('avalonium/feedback/feedbacks') ?>"
       class="btn btn-default oc-icon-chevron-left"><?= __('Return') ?></a>
</div>

<div class="btn-group">
    <?= Form::button(__('Process'), [
        'class' => 'btn btn-success oc-icon-check',
        'data-control' => 'popup',
        'data-handler' => 'onLoadProcessFeedbackForm'
    ]) ?>
    <?= Form::button(__('Cancel'), [
        'class' => 'btn btn-warning oc-icon-times',
        'data-request' => 'onCancel',
        'data-request-confirm' => 'Are you sure you want to cancel this Feedback?'
    ]) ?>
</div>