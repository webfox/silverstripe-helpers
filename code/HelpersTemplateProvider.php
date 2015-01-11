<?php

class HelpersTemplateProvider implements TemplateGlobalProvider {
	/**
	 * @return array
	 */
	public static function get_template_global_variables() {
		return array(
			'ListColumn',
			'Repeat',
			'Dump'
		);
	}

	/**
	 * @param \DataList $object
	 * @param           $column
	 * @param string    $glue
	 * @return string
	 */
	public static function ListColumn(DataList $object, $column, $glue = ', ') {
		return implode($glue, $object->column($column));
	}

	public static function Repeat($times){
		$list = new ArrayList();
		for($i = 1; $i >= $times; $i++){
			$list->push(array('Num' => $i));
		}

		return $list;
	}

	public static function Dump($object){
		dd($object);
	}
}
