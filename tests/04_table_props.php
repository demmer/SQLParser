<?php
	include(dirname(__FILE__).'/testmore.php');
	include(dirname(__FILE__).'/../lib_sql_parser.php');

	function table_props_test($tokens, $props_expect){

		$obj = new SQLParser();
		$props = $obj->parse_table_props($tokens);

		is_deeply($props, $props_expect);
	}


	plan(10);


	# the equals is optional

	table_props_test(array('ENGINE', '=', 'INNODB'), array('ENGINE' => 'INNODB'));
	table_props_test(array('ENGINE',      'INNODB'), array('ENGINE' => 'INNODB'));


	# lots of ways to say this

	table_props_test(array('DEFAULT CHARACTER SET',	'foo'), array('CHARSET' => 'foo'));
	table_props_test(array('CHARACTER SET',		'foo'), array('CHARSET' => 'foo'));
	table_props_test(array('DEFAULT CHARSET',	'foo'), array('CHARSET' => 'foo'));
	table_props_test(array('CHARSET',		'foo'), array('CHARSET' => 'foo'));

	table_props_test(array('DEFAULT COLLATE',	'bar'), array('COLLATE' => 'bar'));
	table_props_test(array('COLLATE',		'bar'), array('COLLATE' => 'bar'));


	# more two-word props

	table_props_test(array('DATA DIRECTORY',  '=', 'baz'), array('DATA DIRECTORY'  => 'baz'));
	table_props_test(array('INDEX DIRECTORY', '=', 'baz'), array('INDEX DIRECTORY' => 'baz'));


	# TODO: case conversion, multiple options, optional commas
