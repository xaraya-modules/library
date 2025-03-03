<?php

$object = [
  'objectid' => 0,
  'name' => 'lb_tags',
  'label' => 'Library Tags',
  'moduleid' => 18257,
  'itemtype' => 15,
  'module_id' => 18257,
  'template' => '',
  'datastore' => 'relational',
  'table' => 'tags',
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
    'tags' => 'tags',
  ],
];
$properties = [];
$properties[] = [
  'name' => 'id',
  'label' => 'Id',
  'type' => '21',
  'id' => 1,
  'defaultvalue' => null,
  'source' => 'tags.id',
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
  'source' => 'tags.name',
  'status' => 1,
  'seq' => 2,
  'validation' => '',
  'configuration' => '',
];
$properties[] = [
  'name' => 'books',
  'label' => 'Books',
  'type' => '18283',
  'source' => '',
  'defaultvalue' => 'linkobject:lb_books_tags.tag.book:lb_books.title',
  'status' => '2',
  'id' => 3,
];
$object['propertyargs'] = $properties;
return $object;
