<?php

return array (
  'database' => 
  array (
    'default_character_set_name' => 'utf8',
    'default_collation_name' => 'utf8_general_ci',
  ),
  'tables' => 
  array (
    'phinxlog' => 
    array (
      'table' => 
      array (
        'table_name' => 'phinxlog',
        'engine' => 'InnoDB',
        'table_comment' => '',
        'table_collation' => 'utf8_general_ci',
        'character_set_name' => 'utf8',
        'row_format' => 'Dynamic',
      ),
      'columns' => 
      array (
        'version' => 
        array (
          'TABLE_CATALOG' => 'def',
          'TABLE_SCHEMA' => 'navicshow',
          'TABLE_NAME' => 'phinxlog',
          'COLUMN_NAME' => 'version',
          'ORDINAL_POSITION' => '1',
          'COLUMN_DEFAULT' => NULL,
          'IS_NULLABLE' => 'NO',
          'DATA_TYPE' => 'bigint',
          'CHARACTER_MAXIMUM_LENGTH' => NULL,
          'CHARACTER_OCTET_LENGTH' => NULL,
          'NUMERIC_PRECISION' => '19',
          'NUMERIC_SCALE' => '0',
          'DATETIME_PRECISION' => NULL,
          'CHARACTER_SET_NAME' => NULL,
          'COLLATION_NAME' => NULL,
          'COLUMN_TYPE' => 'bigint(20)',
          'COLUMN_KEY' => 'PRI',
          'EXTRA' => '',
          'PRIVILEGES' => 'select,insert,update,references',
          'COLUMN_COMMENT' => '',
          'GENERATION_EXPRESSION' => '',
        ),
        'migration_name' => 
        array (
          'TABLE_CATALOG' => 'def',
          'TABLE_SCHEMA' => 'navicshow',
          'TABLE_NAME' => 'phinxlog',
          'COLUMN_NAME' => 'migration_name',
          'ORDINAL_POSITION' => '2',
          'COLUMN_DEFAULT' => NULL,
          'IS_NULLABLE' => 'YES',
          'DATA_TYPE' => 'varchar',
          'CHARACTER_MAXIMUM_LENGTH' => '100',
          'CHARACTER_OCTET_LENGTH' => '300',
          'NUMERIC_PRECISION' => NULL,
          'NUMERIC_SCALE' => NULL,
          'DATETIME_PRECISION' => NULL,
          'CHARACTER_SET_NAME' => 'utf8',
          'COLLATION_NAME' => 'utf8_general_ci',
          'COLUMN_TYPE' => 'varchar(100)',
          'COLUMN_KEY' => '',
          'EXTRA' => '',
          'PRIVILEGES' => 'select,insert,update,references',
          'COLUMN_COMMENT' => '',
          'GENERATION_EXPRESSION' => '',
        ),
        'start_time' => 
        array (
          'TABLE_CATALOG' => 'def',
          'TABLE_SCHEMA' => 'navicshow',
          'TABLE_NAME' => 'phinxlog',
          'COLUMN_NAME' => 'start_time',
          'ORDINAL_POSITION' => '3',
          'COLUMN_DEFAULT' => NULL,
          'IS_NULLABLE' => 'YES',
          'DATA_TYPE' => 'timestamp',
          'CHARACTER_MAXIMUM_LENGTH' => NULL,
          'CHARACTER_OCTET_LENGTH' => NULL,
          'NUMERIC_PRECISION' => NULL,
          'NUMERIC_SCALE' => NULL,
          'DATETIME_PRECISION' => '0',
          'CHARACTER_SET_NAME' => NULL,
          'COLLATION_NAME' => NULL,
          'COLUMN_TYPE' => 'timestamp',
          'COLUMN_KEY' => '',
          'EXTRA' => '',
          'PRIVILEGES' => 'select,insert,update,references',
          'COLUMN_COMMENT' => '',
          'GENERATION_EXPRESSION' => '',
        ),
        'end_time' => 
        array (
          'TABLE_CATALOG' => 'def',
          'TABLE_SCHEMA' => 'navicshow',
          'TABLE_NAME' => 'phinxlog',
          'COLUMN_NAME' => 'end_time',
          'ORDINAL_POSITION' => '4',
          'COLUMN_DEFAULT' => NULL,
          'IS_NULLABLE' => 'YES',
          'DATA_TYPE' => 'timestamp',
          'CHARACTER_MAXIMUM_LENGTH' => NULL,
          'CHARACTER_OCTET_LENGTH' => NULL,
          'NUMERIC_PRECISION' => NULL,
          'NUMERIC_SCALE' => NULL,
          'DATETIME_PRECISION' => '0',
          'CHARACTER_SET_NAME' => NULL,
          'COLLATION_NAME' => NULL,
          'COLUMN_TYPE' => 'timestamp',
          'COLUMN_KEY' => '',
          'EXTRA' => '',
          'PRIVILEGES' => 'select,insert,update,references',
          'COLUMN_COMMENT' => '',
          'GENERATION_EXPRESSION' => '',
        ),
        'breakpoint' => 
        array (
          'TABLE_CATALOG' => 'def',
          'TABLE_SCHEMA' => 'navicshow',
          'TABLE_NAME' => 'phinxlog',
          'COLUMN_NAME' => 'breakpoint',
          'ORDINAL_POSITION' => '5',
          'COLUMN_DEFAULT' => '0',
          'IS_NULLABLE' => 'NO',
          'DATA_TYPE' => 'tinyint',
          'CHARACTER_MAXIMUM_LENGTH' => NULL,
          'CHARACTER_OCTET_LENGTH' => NULL,
          'NUMERIC_PRECISION' => '3',
          'NUMERIC_SCALE' => '0',
          'DATETIME_PRECISION' => NULL,
          'CHARACTER_SET_NAME' => NULL,
          'COLLATION_NAME' => NULL,
          'COLUMN_TYPE' => 'tinyint(1)',
          'COLUMN_KEY' => '',
          'EXTRA' => '',
          'PRIVILEGES' => 'select,insert,update,references',
          'COLUMN_COMMENT' => '',
          'GENERATION_EXPRESSION' => '',
        ),
      ),
      'indexes' => 
      array (
        'PRIMARY' => 
        array (
          1 => 
          array (
            'Table' => 'phinxlog',
            'Non_unique' => '0',
            'Key_name' => 'PRIMARY',
            'Seq_in_index' => '1',
            'Column_name' => 'version',
            'Collation' => 'A',
            'Sub_part' => NULL,
            'Packed' => NULL,
            'Null' => '',
            'Index_type' => 'BTREE',
            'Comment' => '',
            'Index_comment' => '',
          ),
        ),
      ),
      'foreign_keys' => NULL,
    ),
  ),
);