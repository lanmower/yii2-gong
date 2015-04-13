<?php
echo CHtml::tag ( 'div', array (
		'class' => "GContent" 
), GDrawWidget::drawWidget ( $model ) );
?>
