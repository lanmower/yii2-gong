<?php
class GDataColumn extends CDataColumn {
	protected function renderDataCellContent($row, $data) {
		$field = $this->name;
		echo $data->getCell ( $field );
	}
}

?>
