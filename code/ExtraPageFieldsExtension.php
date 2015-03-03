<?php

/**
 * Class ExtraPageFieldsExtension
 *
 */
class ExtraPageFieldsExtension extends SiteTreeExtension {

	private static $db = array(
		'SubTitle'  => 'Text',
		'MetaTitle' => 'Text'
	);

	public function updateCMSFields(FieldList $fields) {

		//Add secondary heading - H2
		$fields->addFieldToTab('Root.Main', TextField::create('SubTitle', 'Secondary Heading'), 'MenuTitle');

		//change Page Name label to Primary Heading - H1
		$fields->removeFieldFromTab('Root.Main', 'Page name');
		$fields->addFieldToTab('Root.Main', TextField::create('Title', 'Primary Heading'), 'SubTitle');

		//Move meta fields to their own tab

		/** @var ToggleCompositeField $metaDataChildren */
		$metaDataChildren = $fields->fieldByName('Root.Main.Metadata');
		$children = array_merge([$metaTitle = TextField::create('MetaTitle')], $metaDataChildren->getChildren()->toArray());
		$fields->removeFieldFromTab('Root.Main', 'Metadata');
		$fields->addFieldToTab('Root', Tab::create('Metadata'), 'Content');

		//Add META Title tag to METADATA
		$fields->addFieldsToTab('Root.Metadata', $children);

		$metaTitle->setDescription('Displayed as the tab/window name; Also displayed in search engine result listings as the page title.<br />
									Falls back to the Primary Heading field if not provided.');

	}

}

