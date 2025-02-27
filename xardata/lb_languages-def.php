<?php

$object = [
  'objectid' => 0,
  'name' => 'lb_languages',
  'label' => 'Library Languages',
  'moduleid' => 18257,
  'itemtype' => 11,
  'module_id' => 18257,
  'template' => '',
  'datastore' => 'relational',
  'table' => 'languages',
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
    'languages' => 'languages',
  ],
];
$properties = [];
$properties[] = [
  'name' => 'id',
  'label' => 'Id',
  'type' => '21',
  'id' => 1,
  'defaultvalue' => null,
  'source' => 'languages.id',
  'status' => 1,
  'seq' => 1,
  'validation' => '',
  'configuration' => '',
];
$properties[] = [
  'name' => 'lang_code',
  'label' => 'Lang Code',
  'type' => '2',
  'id' => 2,
  'defaultvalue' => null,
  'source' => 'languages.lang_code',
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
  'defaultvalue' => 'linkobject:lb_books_languages.lang_code.book:lb_books.title',
  'status' => '2',
  'id' => 3,
];
$object['propertyargs'] = $properties;
return $object;
