<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
});

Breadcrumbs::for('folders', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Folders', route('folder.index'));
});

Breadcrumbs::for('folder_create', function (BreadcrumbTrail $trail) {
    $trail->parent('folders');
    $trail->push('Create New Folder', route('folder.create'));
});

Breadcrumbs::for('images', function (BreadcrumbTrail $trail, $folder) {
    $trail->parent('folders');
    $trail->push($folder->name, route('folder.show', $folder->id));
});
