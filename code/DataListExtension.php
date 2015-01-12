<?php

/**
 * Class DataListExtension
 *
 * @property DataList owner
 */
class DataListExtension extends Extension {

	public function ListColumn($column, $glue = ', '){
		return implode($glue, $this->owner->column($column));
	}

}