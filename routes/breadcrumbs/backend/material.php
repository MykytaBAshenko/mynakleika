<?php

Breadcrumbs::for('admin.material.index', function ($trail) {
	$trail->parent('admin.dashboard');
    $trail->push(__('strings.backend.material.title'), route('admin.material.index'));
});

Breadcrumbs::for('admin.material.create', function ($trail) {
	$trail->parent('admin.material.index');
    $trail->push(__('strings.backend.material.create'), route('admin.material.create'));
});

Breadcrumbs::for('admin.material.edit', function ($trail, $material) {
    $trail->parent('admin.material.index');
    $trail->push(__('strings.backend.material.edit'), route('admin.material.edit', [$material->id]));;
});