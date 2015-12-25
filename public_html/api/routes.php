<?php

return array(
	'\/(.*)\/([0-9]+)(\?(.*)){0,1}' =>
		array(
			'ApiResponder' ,
			array('action' => 'findById', 'entity' => '$1', 'id' => '$2')
		) ,

	'\/(.*)\/@([A-Za-z_]+[A-Za-z0-9_]*)(\?(.*)){0,1}' =>
		array(
			'ApiResponder' ,
			array('entity' => '$1', 'action' => '$2')
		) ,

	'\/(.*)\/(\?(.*)){0,1}' =>
		array(
			'ApiResponder' ,
			array('action' => 'find', 'entity' => '$1')
		),
);
