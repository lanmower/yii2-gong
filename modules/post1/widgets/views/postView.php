<?php
$this->render ( 'postViewHeader', array (
		'model' => $model,
		'id' => $id,
		'edit' => $edit,
		'published' => $published 
) );
$this->render ( 'postViewDetails', array (
		'model' => $model,
		'id' => $id,
		'edit' => $edit,
		'published' => $published 
) );
$this->render ( 'postViewButtons', array (
		'model' => $model,
		'id' => $id,
		'edit' => $edit,
		'published' => $published 
) );
$this->render ( 'postViewContent', array (
		'model' => $model,
		'id' => $id,
		'edit' => $edit,
		'published' => $published 
) );

?>
