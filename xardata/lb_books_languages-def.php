<?php

$object = array (
  'objectid' => 0,
  'name' => 'lb_books_languages',
  'label' => 'Library Books Languages',
  'moduleid' => 18257,
  'itemtype' => 4,
  'module_id' => 18257,
  'template' => '',
  'datastore' => 'relational',
  'table' => 'books_languages_link',
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
    'books_languages_link' => 'books_languages_link',
  ),
);
$properties = array();
$properties[] = array (
  'name' => 'id',
  'label' => 'Id',
  'type' => '21',
  'id' => 1,
  'defaultvalue' => NULL,
  'source' => 'books_languages_link.id',
  'status' => 1,
  'seq' => 1,
  'validation' => '',
  'configuration' => '',
);
$properties[] = array (
  'name' => 'book',
  'label' => 'Book',
  'type' => '18281',
  'id' => 2,
  'defaultvalue' => 'dataobject:lb_books.title',
  'source' => 'books_languages_link.book',
  'status' => 1,
  'seq' => 2,
  'validation' => '',
  'configuration' => '',
);
$properties[] = array (
  'name' => 'lang_code',
  'label' => 'Lang Code',
  'type' => '18281',
  'id' => 3,
  'defaultvalue' => 'dataobject:lb_languages.missing',
  'source' => 'books_languages_link.lang_code',
  'status' => 1,
  'seq' => 3,
  'validation' => '',
  'configuration' => '',
);
$properties[] = array (
  'name' => 'item_order',
  'label' => 'Item Order',
  'type' => '15',
  'id' => 4,
  'defaultvalue' => '0',
  'source' => 'books_languages_link.item_order',
  'status' => 1,
  'seq' => 4,
  'validation' => '',
  'configuration' => '',
);
$object['propertyargs'] = $properties;
return $object;
