<?php

$object = [
    'objectid' => 0,
    'name' => 'lb_books_authors',
    'label' => 'Library Books Authors',
    'moduleid' => 18257,
    'itemtype' => 3,
    'module_id' => 18257,
    'template' => '',
    'datastore' => 'relational',
    'table' => 'books_authors_link',
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
        'books_authors_link' => 'books_authors_link',
    ],
];
$properties = [];
$properties[] = [
    'name' => 'id',
    'label' => 'Id',
    'type' => '21',
    'id' => 1,
    'defaultvalue' => null,
    'source' => 'books_authors_link.id',
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
    'source' => 'books_authors_link.book',
    'status' => 1,
    'seq' => 2,
    'validation' => '',
    'configuration' => '',
];
$properties[] = [
    'name' => 'author',
    'label' => 'Author',
    'type' => '18281',
    'id' => 3,
    'defaultvalue' => 'dataobject:lb_authors.name',
    'source' => 'books_authors_link.author',
    'status' => 1,
    'seq' => 3,
    'validation' => '',
    'configuration' => '',
];
$object['propertyargs'] = $properties;
return $object;
