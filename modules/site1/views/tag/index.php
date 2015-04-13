<?php
echo 'Name: ' . $model->name;
$this->widget ( 'GEditor', array (
		'name' => 'prefixContent',
		'value' => $model->prefixContent 
) );
?>
