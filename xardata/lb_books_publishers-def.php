<?php

$object = [
  'objectid' => 0,
  'name' => 'lb_books_publishers',
  'label' => 'Library Books Publishers',
  'moduleid' => 18257,
  'itemtype' => 5,
  'module_id' => 18257,
  'template' => '',
  'datastore' => 'relational',
  'table' => 'books_publishers_link',
  'dbConnIndex' => 1,
  'config' =>
  [
    'dbConnIndex' => 1,
    'dbConnArgs' => '["Xaraya\\\\Modules\\\\Library\\\\UserApi","getDbConnArgs"]',
  ],
  'class' => 'Xaraya\\Modules\\Library\\LibraryLinkObject',
  'filepath' => 'modules/library/class/link.php',
  'sources' =>
  [
    'books_publishers_link' => 'books_publishers_link',
  ],
];
$properties = [];
$properties[] = [
  'name' => 'id',
  'label' => 'Id',
  'type' => '21',
  'id' => 1,
  'defaultvalue' => null,
  'source' => 'books_publishers_link.id',
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
  'source' => 'books_publishers_link.book',
  'status' => 1,
  'seq' => 2,
  'validation' => '',
  'configuration' => '',
];
$properties[] = [
  'name' => 'publisher',
  'label' => 'Publisher',
  'type' => '18281',
  'id' => 3,
  'defaultvalue' => 'dataobject:lb_publishers.name',
  'source' => 'books_publishers_link.publisher',
  'status' => 1,
  'seq' => 3,
  'validation' => '',
  'configuration' => '',
];
$object['propertyargs'] = $properties;
return $object;
