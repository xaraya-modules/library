<?php

$object = [
  'objectid' => 0,
  'name' => 'lb_identifiers',
  'label' => 'Library Identifiers',
  'moduleid' => 18257,
  'itemtype' => 10,
  'module_id' => 18257,
  'template' => '',
  'datastore' => 'relational',
  'table' => 'identifiers',
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
    'identifiers' => 'identifiers',
  ],
];
$properties = [];
$properties[] = [
  'name' => 'id',
  'label' => 'Id',
  'type' => '21',
  'id' => 1,
  'defaultvalue' => null,
  'source' => 'identifiers.id',
  'status' => 1,
  'seq' => 1,
  'validation' => '',
  'configuration' => '',
];
$properties[] = [
  'name' => 'book',
  'label' => 'Book',
  'type' => '1',
  'id' => 2,
  'defaultvalue' => null,
  'source' => 'identifiers.book',
  'status' => 1,
  'seq' => 2,
  'validation' => 'INTEGER NON',
  'configuration' => 'INTEGER NON',
];
$properties[] = [
  'name' => 'type',
  'label' => 'Type',
  'type' => '1',
  'id' => 3,
  'defaultvalue' => '"isbn"',
  'source' => 'identifiers.type',
  'status' => 1,
  'seq' => 3,
  'validation' => 'TEXT NON',
  'configuration' => 'TEXT NON',
];
$properties[] = [
  'name' => 'val',
  'label' => 'Val',
  'type' => '1',
  'id' => 4,
  'defaultvalue' => null,
  'source' => 'identifiers.val',
  'status' => 1,
  'seq' => 4,
  'validation' => 'TEXT NON',
  'configuration' => 'TEXT NON',
];
$object['propertyargs'] = $properties;
return $object;
