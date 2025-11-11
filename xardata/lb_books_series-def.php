<?php

$object = [
    'objectid' => 0,
    'name' => 'lb_books_series',
    'label' => 'Library Books Series',
    'moduleid' => 18257,
    'itemtype' => 7,
    'module_id' => 18257,
    'template' => '',
    'datastore' => 'relational',
    'table' => 'books_series_link',
    'dbConnIndex' => 1,
    'config'
    => [
        'dbConnIndex' => 1,
        'dbConnArgs' => '["Xaraya\\\\Modules\\\\Library\\\\UserApi","getDbConnArgs"]',
    ],
    'class' => 'Xaraya\\Modules\\Library\\LibraryLinkObject',
    'filepath' => 'modules/library/class/link.php',
    'sources'
    => [
        'books_series_link' => 'books_series_link',
    ],
];
$properties = [];
$properties[] = [
    'name' => 'id',
    'label' => 'Id',
    'type' => '21',
    'id' => 1,
    'defaultvalue' => null,
    'source' => 'books_series_link.id',
    'status' => 1,
    'seq' => 1,
    'validation' => '',
    'configuration' => '',
];
$properties[] = [
    'name' => 'book',
    'label' => 'Book',
    'type' => '18281',
    'id' => 2,
    'defaultvalue' => 'dataobject:lb_books.title',
    'source' => 'books_series_link.book',
    'status' => 1,
    'seq' => 2,
    'validation' => '',
    'configuration' => '',
];
$properties[] = [
    'name' => 'series',
    'label' => 'Series',
    'type' => '18281',
    'id' => 3,
    'defaultvalue' => 'dataobject:lb_series.name',
    'source' => 'books_series_link.series',
    'status' => 1,
    'seq' => 3,
    'validation' => '',
    'configuration' => '',
];
$object['propertyargs'] = $properties;
return $object;
