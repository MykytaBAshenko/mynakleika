<?php

Breadcrumbs::for('admin.dashboard', function ($trail) {
    $trail->push(__('strings.backend.dashboard.title'), route('admin.dashboard'));
});

require __DIR__.'/material.php';
require __DIR__.'/option.php';
require __DIR__.'/auth.php';
require __DIR__.'/log-viewer.php';
require __DIR__.'/payer.php';
