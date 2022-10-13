<div class="scoreboard-item title-value">
    <h4><?= __('Number') ?></h4>
    <p><?= e($formModel->number) ?></p>
    <p class="description"><?= __('Created') ?>: <?= e($formModel->created_at) ?></p>
</div>

<div class="scoreboard-item title-value">
    <h4><?= __('Name') ?></h4>
    <p><?= e($formModel->name) ?></p>
    <p class="description"><?= __('IP address') ?>: <?= e($formModel->ip_address) ?></p>
</div>