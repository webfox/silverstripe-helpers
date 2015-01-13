<?php

/**
 * Class FooterMenuExtension
 *
 */
class FooterMenuExtension extends SiteTreeExtension {

	private static $db = array(
			'ShowInFooter' => 'Boolean'
	);
	
	public function updateSettingsFields(FieldList $fields) {
		//quick links option
		$fields->addFieldToTab("Root.Settings", new CheckBoxField('ShowInFooter', 'Show in footer menu?'), 'ShowInSearch');
	}
	
	Public function FooterPages(){
		return SiteTree::get()->filter('ShowInFooter', true);
	}

}