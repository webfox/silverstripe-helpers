<?php

class HelpersTemplateProvider implements TemplateGlobalProvider {
	/**
	 * @return array
	 */
	public static function get_template_global_variables() {
		return array(
			'Repeat',
			'Dump'
		);
	}

	public static function Repeat($times){
		$list = new ArrayList();
		$formatter = new NumberFormatter('en-NZ', NumberFormatter::SPELLOUT);
		for($i = 1; $i <= $times; $i++){
			$list->push(array('Num' => $i, 'Word' => ucwords(strtolower($formatter->format($i)))));
		}

		return $list;
	}

	public static function Dump($object){
		dd($object);
	}
}
