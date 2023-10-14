<?php

$object = array (
  'objectid' => 0,
  'name' => 'lb_series',
  'label' => 'Library Series',
  'moduleid' => 18257,
  'itemtype' => 14,
  'module_id' => 18257,
  'template' => '',
  'datastore' => 'relational',
  'table' => 'series',
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
    'series' => 'series',
  ),
);
$properties = array();
$properties[] = array (
  'name' => 'id',
  'label' => 'Id',
  'type' => '21',
  'id' => 1,
  'defaultvalue' => NULL,
  'source' => 'series.id',
  'status' => 1,
  'seq' => 1,
  'validation' => '',
  'configuration' => '',
);
$properties[] = array (
  'name' => 'name',
  'label' => 'Name',
  'type' => '2',
  'id' => 2,
  'defaultvalue' => NULL,
  'source' => 'series.name',
  'status' => 1,
  'seq' => 2,
  'validation' => '',
  'configuration' => '',
);
$properties[] = array (
  'name' => 'sort',
  'label' => 'Sort',
  'type' => '4',
  'id' => 3,
  'defaultvalue' => NULL,
  'source' => 'series.sort',
  'status' => 2,
  'seq' => 3,
  'validation' => '',
  'configuration' => '',
);
$properties[] = array (
  'name' => 'books',
  'label' => 'Books',
  'type' => '18283',
  'source' => '',
  'defaultvalue' => 'linkobject:lb_books_series.series.book:lb_books.title',
  'status' => '2',
  'id' => 4,
);
$object['propertyargs'] = $properties;
return $object;
