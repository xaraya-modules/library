<?php

$object = array (
  'objectid' => 0,
  'name' => 'lb_books',
  'label' => 'Library Books',
  'moduleid' => 18257,
  'itemtype' => 2,
  'module_id' => 18257,
  'template' => '',
  'datastore' => 'relational',
  'table' => 'books',
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
    'books' => 'books',
  ),
);
$properties = array();
$properties[] = array (
  'name' => 'id',
  'label' => 'Id',
  'type' => '21',
  'id' => 1,
  'defaultvalue' => NULL,
  'source' => 'books.id',
  'status' => 1,
  'seq' => 1,
  'validation' => '',
  'configuration' => '',
);
$properties[] = array (
  'name' => 'title',
  'label' => 'Title',
  'type' => '2',
  'id' => 2,
  'defaultvalue' => '\'Unknown\'',
  'source' => 'books.title',
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
  'source' => 'books.sort',
  'status' => 2,
  'seq' => 3,
  'validation' => '',
  'configuration' => '',
);
$properties[] = array (
  'name' => 'timestamp',
  'label' => 'Timestamp',
  'type' => '8',
  'id' => 4,
  'defaultvalue' => 'CURRENT_TIMESTAMP',
  'source' => 'books.timestamp',
  'status' => 1,
  'seq' => 4,
  'validation' => 'TIMESTAMP',
  'configuration' => 'TIMESTAMP',
);
$properties[] = array (
  'name' => 'pubdate',
  'label' => 'Pubdate',
  'type' => '8',
  'id' => 5,
  'defaultvalue' => 'CURRENT_TIMESTAMP',
  'source' => 'books.pubdate',
  'status' => 1,
  'seq' => 5,
  'validation' => 'TIMESTAMP',
  'configuration' => 'TIMESTAMP',
);
$properties[] = array (
  'name' => 'series_index',
  'label' => 'Series Index',
  'type' => '17',
  'id' => 6,
  'defaultvalue' => '1.0',
  'source' => 'books.series_index',
  'status' => 1,
  'seq' => 6,
  'validation' => '',
  'configuration' => '',
);
$properties[] = array (
  'name' => 'author_sort',
  'label' => 'Author Sort',
  'type' => '4',
  'id' => 7,
  'defaultvalue' => NULL,
  'source' => 'books.author_sort',
  'status' => 2,
  'seq' => 7,
  'validation' => '',
  'configuration' => '',
);
$properties[] = array (
  'name' => 'isbn',
  'label' => 'Isbn',
  'type' => '4',
  'id' => 8,
  'defaultvalue' => '""',
  'source' => 'books.isbn',
  'status' => 2,
  'seq' => 8,
  'validation' => '',
  'configuration' => '',
);
$properties[] = array (
  'name' => 'lccn',
  'label' => 'Lccn',
  'type' => '4',
  'id' => 9,
  'defaultvalue' => '""',
  'source' => 'books.lccn',
  'status' => 2,
  'seq' => 9,
  'validation' => '',
  'configuration' => '',
);
$properties[] = array (
  'name' => 'path',
  'label' => 'Path',
  'type' => '4',
  'id' => 10,
  'defaultvalue' => '""',
  'source' => 'books.path',
  'status' => 2,
  'seq' => 10,
  'validation' => '',
  'configuration' => '',
);
$properties[] = array (
  'name' => 'flags',
  'label' => 'Flags',
  'type' => '15',
  'id' => 11,
  'defaultvalue' => '1',
  'source' => 'books.flags',
  'status' => 1,
  'seq' => 11,
  'validation' => '',
  'configuration' => '',
);
$properties[] = array (
  'name' => 'uuid',
  'label' => 'Uuid',
  'type' => '4',
  'id' => 12,
  'defaultvalue' => NULL,
  'source' => 'books.uuid',
  'status' => 2,
  'seq' => 12,
  'validation' => '',
  'configuration' => '',
);
$properties[] = array (
  'name' => 'has_cover',
  'label' => 'Has Cover',
  'type' => '14',
  'id' => 13,
  'defaultvalue' => '0',
  'source' => 'books.has_cover',
  'status' => 1,
  'seq' => 13,
  'validation' => '',
  'configuration' => '',
);
$properties[] = array (
  'name' => 'last_modified',
  'label' => 'Last Modified',
  'type' => '8',
  'id' => 14,
  'defaultvalue' => '"2000-01-01 00:00:00+00:00"',
  'source' => 'books.last_modified',
  'status' => 1,
  'seq' => 14,
  'validation' => 'TIMESTAMP',
  'configuration' => 'TIMESTAMP',
);
$properties[] = array (
  'name' => 'authors',
  'label' => 'Authors',
  'type' => '18283',
  'source' => '',
  'defaultvalue' => 'linkobject:lb_books_authors.book.author:lb_authors.name',
  'status' => '1',
  'id' => 15,
);
$properties[] = array (
  'name' => 'languages',
  'label' => 'Languages',
  'type' => '18283',
  'source' => '',
  'defaultvalue' => 'linkobject:lb_books_languages.book.lang_code:lb_languages.missing',
  'status' => '2',
  'id' => 16,
);
$properties[] = array (
  'name' => 'publishers',
  'label' => 'Publishers',
  'type' => '18283',
  'source' => '',
  'defaultvalue' => 'linkobject:lb_books_publishers.book.publisher:lb_publishers.name',
  'status' => '2',
  'id' => 17,
);
$properties[] = array (
  'name' => 'ratings',
  'label' => 'Ratings',
  'type' => '18283',
  'source' => '',
  'defaultvalue' => 'linkobject:lb_books_ratings.book.rating:lb_ratings.missing',
  'status' => '2',
  'id' => 18,
);
$properties[] = array (
  'name' => 'series',
  'label' => 'Series',
  'type' => '18283',
  'source' => '',
  'defaultvalue' => 'linkobject:lb_books_series.book.series:lb_series.name',
  'status' => '2',
  'id' => 19,
);
$properties[] = array (
  'name' => 'tags',
  'label' => 'Tags',
  'type' => '18283',
  'source' => '',
  'defaultvalue' => 'linkobject:lb_books_tags.book.tag:lb_tags.name',
  'status' => '2',
  'id' => 20,
);
$object['propertyargs'] = $properties;
return $object;
