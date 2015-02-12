<?php

/**
 * Class ExtraPageFieldsExtension
 *
 */
class ExtraPageFieldsExtension extends SiteTreeExtension {

	private static $db = array(
			'SubTitle' => 'Text',
			'MetaTitle' => 'Text'
	);

	public function updateCMSFields(FieldList $fields){

		//Add secondary heading - H2
		$fields->addFieldToTab('Root.Main', new TextField('SubTitle', 'Secondary Heading'), 'MenuTitle');
		
		//change Page Name label to Primary Heading - H1
		$fields->removeFieldFromTab('Root.Main', 'Page name');
		$fields->addFieldToTab('Root.Main', new TextField('Title', 'Primary Heading'), 'SubTitle');
		 
		//Add META Title tag to METADATA
		$fields->addFieldToTab('Root.Main.Metadata', new TextField('MetaTitle', $title = 'Meta Title'), $above = 'MetaDescription');
	
	}
	
}

