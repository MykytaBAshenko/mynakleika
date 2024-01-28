<?php

Breadcrumbs::for('customer.dashboard', function ($trail) {
    $trail->push(__('strings.backend.dashboard.title'), route('customer.dashboard'));
});