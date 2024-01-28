<?php

Breadcrumbs::for('admin.payers', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('strings.backend.options.payers'), route('admin.payers'));
});
