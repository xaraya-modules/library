<?php

$object = array (
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
  array (
    'dbConnIndex' => 1,
    'dbConnArgs' => '["Xaraya\\\\Modules\\\\Library\\\\UserApi","getDbConnArgs"]',
  ),
  'class' => 'Xaraya\\Modules\\Library\\LibraryObject',
  'filepath' => 'modules/library/class/object.php',
  'sources' => 
  array (
    'data' => 'data',
  ),
);
$properties = array();
$properties[] = array (
  'name' => 'id',
  'label' => 'Id',
  'type' => '21',
  'id' => 1,
  'defaultvalue' => NULL,
  'source' => 'data.id',
  'status' => 1,
  'seq' => 1,
  'validation' => '',
  'configuration' => '',
);
$properties[] = array (
  'name' => 'book',
  'label' => 'Book',
  'type' => '1',
  'id' => 2,
  'defaultvalue' => NULL,
  'source' => 'data.book',
  'status' => 1,
  'seq' => 2,
  'validation' => 'INTEGER NON',
  'configuration' => 'INTEGER NON',
);
$properties[] = array (
  'name' => 'format',
  'label' => 'Format',
  'type' => '1',
  'id' => 3,
  'defaultvalue' => NULL,
  'source' => 'data.format',
  'status' => 1,
  'seq' => 3,
  'validation' => 'TEXT NON',
  'configuration' => 'TEXT NON',
);
$properties[] = array (
  'name' => 'uncompressed_size',
  'label' => 'Uncompressed Size',
  'type' => '1',
  'id' => 4,
  'defaultvalue' => NULL,
  'source' => 'data.uncompressed_size',
  'status' => 1,
  'seq' => 4,
  'validation' => 'INTEGER NON',
  'configuration' => 'INTEGER NON',
);
$properties[] = array (
  'name' => 'name',
  'label' => 'Name',
  'type' => '1',
  'id' => 5,
  'defaultvalue' => NULL,
  'source' => 'data.name',
  'status' => 1,
  'seq' => 5,
  'validation' => 'TEXT NON',
  'configuration' => 'TEXT NON',
);
$object['propertyargs'] = $properties;
return $object;
