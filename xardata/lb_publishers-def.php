<?php

$object = [
  'objectid' => 0,
  'name' => 'lb_publishers',
  'label' => 'Library Publishers',
  'moduleid' => 18257,
  'itemtype' => 12,
  'module_id' => 18257,
  'template' => '',
  'datastore' => 'relational',
  'table' => 'publishers',
  'dbConnIndex' => 1,
  'config' =>
  [
    'titlefield' => 'name',
    'dbConnIndex' => 1,
    'dbConnArgs' => '["Xaraya\\\\Modules\\\\Library\\\\UserApi","getDbConnArgs"]',
  ],
  'class' => 'Xaraya\\Modules\\Library\\LibraryObject',
  'filepath' => 'modules/library/class/object.php',
  'sources' =>
  [
    'publishers' => 'publishers',
  ],
];
$properties = [];
$properties[] = [
  'name' => 'id',
  'label' => 'Id',
  'type' => '21',
  'id' => 1,
  'defaultvalue' => null,
  'source' => 'publishers.id',
  'status' => 1,
  'seq' => 1,
  'validation' => '',
  'configuration' => '',
];
$properties[] = [
  'name' => 'name',
  'label' => 'Name',
  'type' => '2',
  'id' => 2,
  'defaultvalue' => null,
  'source' => 'publishers.name',
  'status' => 1,
  'seq' => 2,
  'validation' => '',
  'configuration' => '',
];
$properties[] = [
  'name' => 'sort',
  'label' => 'Sort',
  'type' => '4',
  'id' => 3,
  'defaultvalue' => null,
  'source' => 'publishers.sort',
  'status' => 2,
  'seq' => 3,
  'validation' => '',
  'configuration' => '',
];
$properties[] = [
  'name' => 'books',
  'label' => 'Books',
  'type' => '18283',
  'source' => '',
  'defaultvalue' => 'linkobject:lb_books_publishers.publisher.book:lb_books.title',
  'status' => '2',
  'id' => 4,
];
$object['propertyargs'] = $properties;
return $object;
