<?php

$object = [
  'objectid' => 0,
  'name' => 'lb_data',
  'label' => 'Library Data',
  'moduleid' => 18257,
  'itemtype' => 9,
  'module_id' => 18257,
  'template' => '',
  'datastore' => 'relational',
  'table' => 'data',
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
    'data' => 'data',
  ],
];
$properties = [];
$properties[] = [
  'name' => 'id',
  'label' => 'Id',
  'type' => '21',
  'id' => 1,
  'defaultvalue' => null,
  'source' => 'data.id',
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
  'source' => 'data.book',
  'status' => 1,
  'seq' => 2,
  'validation' => '',
  'configuration' => '',
];
$properties[] = [
  'name' => 'format',
  'label' => 'Format',
  'type' => '2',
  'id' => 3,
  'defaultvalue' => null,
  'source' => 'data.format',
  'status' => 1,
  'seq' => 3,
  'validation' => '',
  'configuration' => '',
];
$properties[] = [
  'name' => 'uncompressed_size',
  'label' => 'Uncompressed Size',
  'type' => '1',
  'id' => 4,
  'defaultvalue' => null,
  'source' => 'data.uncompressed_size',
  'status' => 1,
  'seq' => 4,
  'validation' => '',
  'configuration' => '',
];
$properties[] = [
  'name' => 'name',
  'label' => 'Name',
  'type' => '1',
  'id' => 5,
  'defaultvalue' => null,
  'source' => 'data.name',
  'status' => 1,
  'seq' => 5,
  'validation' => '',
  'configuration' => '',
];
$object['propertyargs'] = $properties;
return $object;
