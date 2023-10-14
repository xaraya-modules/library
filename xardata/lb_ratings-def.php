<?php

$object = array (
  'objectid' => 0,
  'name' => 'lb_ratings',
  'label' => 'Library Ratings',
  'moduleid' => 18257,
  'itemtype' => 13,
  'module_id' => 18257,
  'template' => '',
  'datastore' => 'relational',
  'table' => 'ratings',
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
    'ratings' => 'ratings',
  ),
);
$properties = array();
$properties[] = array (
  'name' => 'id',
  'label' => 'Id',
  'type' => '21',
  'id' => 1,
  'defaultvalue' => NULL,
  'source' => 'ratings.id',
  'status' => 1,
  'seq' => 1,
  'validation' => '',
  'configuration' => '',
);
$properties[] = array (
  'name' => 'rating',
  'label' => 'Rating',
  'type' => '15',
  'id' => 2,
  'defaultvalue' => NULL,
  'source' => 'ratings.rating',
  'status' => 1,
  'seq' => 2,
  'validation' => '',
  'configuration' => '',
);
$properties[] = array (
  'name' => 'books',
  'label' => 'Books',
  'type' => '18283',
  'source' => '',
  'defaultvalue' => 'linkobject:lb_books_ratings.rating.book:lb_books.title',
  'status' => '2',
  'id' => 3,
);
$object['propertyargs'] = $properties;
return $object;
