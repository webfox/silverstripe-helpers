<?php

/**
 * Class ImageExtension
 *
 * @property Image $owner
 */
class ImageExtension extends DataExtension {

	private static $db = [
		'AltText' => 'Varchar(255)',
	];

	private static $has_one = [
		'OwningPage' => 'Page'
	];

	public function updateCMSFields(FieldList $fields) {

		Requirements::customCSS(
			<<<CSS
			form.small .field input.text,
			form.small .field textarea,
			form.small .field select,
			form.small .field .TreeDropdownField,
			.field.small input.text,
			.field.small textarea,
			.field.small select,
			.field.small .TreeDropdownField {
    			width: 100%;
			}
CSS
		);

		$fields->dataFieldByName('Title')->setTitle(_t('Linkable.TITLE', 'Title Attribute'))
		       ->setDescription('Describe the image to humans');

		/** @var TextField $altText */
		$fields->addFieldToTab('Root.Main', $altText = TextField::create('AltText', _t('Linkable.SEOTEXT', 'Alt Attribute')), 'Name');
		$altText->setDescription('Describe the image to google');

		$fields->removeByName('OwningPageID');
	}

	public function getDownloadAttribute() {
		/** @var File $component */
		if ($this->owner->Type === 'File' && $component = $this->owner->getComponent($this->owner->Type)) {
			if ($component->exists()) {
				return ' download="' . $component->Name . '" ';
			}

		}

		return null;
	}

}