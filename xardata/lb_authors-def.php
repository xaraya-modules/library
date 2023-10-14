<?php

$object = array (
  'objectid' => 0,
  'name' => 'lb_authors',
  'label' => 'Library Authors',
  'moduleid' => 18257,
  'itemtype' => 1,
  'module_id' => 18257,
  'template' => '',
  'datastore' => 'relational',
  'table' => 'authors',
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
    'authors' => 'authors',
  ),
);
$properties = array();
$properties[] = array (
  'name' => 'id',
  'label' => 'Id',
  'type' => '21',
  'id' => 1,
  'defaultvalue' => NULL,
  'source' => 'authors.id',
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
  'source' => 'authors.name',
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
  'source' => 'authors.sort',
  'status' => 2,
  'seq' => 3,
  'validation' => '',
  'configuration' => '',
);
$properties[] = array (
  'name' => 'link',
  'label' => 'Link',
  'type' => '4',
  'id' => 4,
  'defaultvalue' => '""',
  'source' => 'authors.link',
  'status' => 2,
  'seq' => 4,
  'validation' => '',
  'configuration' => '',
);
$properties[] = array (
  'name' => 'books',
  'label' => 'Books',
  'type' => '18283',
  'source' => '',
  'defaultvalue' => 'linkobject:lb_books_authors.author.book:lb_books.title',
  'status' => '2',
  'id' => 5,
);
$object['propertyargs'] = $properties;
return $object;
