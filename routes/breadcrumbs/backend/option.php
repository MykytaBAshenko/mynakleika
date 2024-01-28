<?php

Breadcrumbs::for('admin.option.print', function ($trail) {
	$trail->parent('admin.dashboard');
    $trail->push(__('strings.backend.options.print'), route('admin.option.print'));
});

Breadcrumbs::for('admin.option.cost', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('strings.backend.options.cost'), route('admin.option.cost'));
});

Breadcrumbs::for('admin.option.self-legal-entities', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('strings.backend.options.self-legal-entities'), route('admin.option.self-legal-entities'));
});
