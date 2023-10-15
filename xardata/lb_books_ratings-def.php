<?php

$object = [
  'objectid' => 0,
  'name' => 'lb_books_ratings',
  'label' => 'Library Books Ratings',
  'moduleid' => 18257,
  'itemtype' => 6,
  'module_id' => 18257,
  'template' => '',
  'datastore' => 'relational',
  'table' => 'books_ratings_link',
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
    'books_ratings_link' => 'books_ratings_link',
  ],
];
$properties = [];
$properties[] = [
  'name' => 'id',
  'label' => 'Id',
  'type' => '21',
  'id' => 1,
  'defaultvalue' => null,
  'source' => 'books_ratings_link.id',
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
  'source' => 'books_ratings_link.book',
  'status' => 1,
  'seq' => 2,
  'validation' => '',
  'configuration' => '',
];
$properties[] = [
  'name' => 'rating',
  'label' => 'Rating',
  'type' => '18281',
  'id' => 3,
  'defaultvalue' => 'dataobject:lb_ratings.missing',
  'source' => 'books_ratings_link.rating',
  'status' => 1,
  'seq' => 3,
  'validation' => '',
  'configuration' => '',
];
$object['propertyargs'] = $properties;
return $object;
