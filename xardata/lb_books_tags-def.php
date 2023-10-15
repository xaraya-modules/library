<?php

$object = [
  'objectid' => 0,
  'name' => 'lb_books_tags',
  'label' => 'Library Books Tags',
  'moduleid' => 18257,
  'itemtype' => 8,
  'module_id' => 18257,
  'template' => '',
  'datastore' => 'relational',
  'table' => 'books_tags_link',
  'dbConnIndex' => 1,
  'config' =>
  [
    'dbConnIndex' => 1,
    'dbConnArgs' => '["Xaraya\\\\Modules\\\\Library\\\\UserApi","getDbConnArgs"]',
  ],
  'class' => 'Xaraya\\Modules\\Library\\LibraryObject',
  'filepath' => 'modules/library/class/object.php',
  'sources' =>
  [
    'books_tags_link' => 'books_tags_link',
  ],
];
$properties = [];
$properties[] = [
  'name' => 'id',
  'label' => 'Id',
  'type' => '21',
  'id' => 1,
  'defaultvalue' => null,
  'source' => 'books_tags_link.id',
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
  'source' => 'books_tags_link.book',
  'status' => 1,
  'seq' => 2,
  'validation' => '',
  'configuration' => '',
];
$properties[] = [
  'name' => 'tag',
  'label' => 'Tag',
  'type' => '18281',
  'id' => 3,
  'defaultvalue' => 'dataobject:lb_tags.name',
  'source' => 'books_tags_link.tag',
  'status' => 1,
  'seq' => 3,
  'validation' => '',
  'configuration' => '',
];
$object['propertyargs'] = $properties;
return $object;
