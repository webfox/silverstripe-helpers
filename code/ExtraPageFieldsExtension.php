<?php

/**
 * Class ExtraPageFieldsExtension
 *
 */
class ExtraPageFieldsExtension extends SiteTreeExtension
{

    private $MetaDescriptionLength = 156;

    private static $db = array(
        'SubTitle'   => 'Text',
        'MetaTitle'  => 'Text',
        'MenuTarget' => 'Varchar(255)'
    );

    public function updateCMSFields(FieldList $fields)
    {

        //change Page Name label to Primary Heading - H1 - Only if the title hasn't already been changed
        /** @var TextField $titleField */
        $titleField = $fields->dataFieldByName('Title');
        if ($titleField->Title() == 'Page name') {
            $fields->renameField('Title', 'Primary Heading');
        }

        //Add secondary heading - H2
        $fields->insertAfter(TextField::create('SubTitle', 'Secondary Heading'), 'Title');

        //Move meta fields to their own tab

        /** @var ToggleCompositeField $metaDataChildren */
        $metaDataChildren = $fields->fieldByName('Root.Main.Metadata');
//		ddd($metaDataChildren->fieldByName('MetaDescription'));
        $children = array_merge([$metaTitle = TextField::create('MetaTitle')], $metaDataChildren->getChildren()->toArray());
        $fields->removeFieldFromTab('Root.Main', 'Metadata');
        $fields->addFieldToTab('Root', Tab::create('Metadata'), 'Content');

        //Add META Title tag to METADATA
        $length = $this->owner->config()->MetaDescriptionLength ?: $this->MetaDescriptionLength;
        $metaDataChildren->fieldByName('MetaDescription')->setAttribute('maxlength', $length);
        $fields->addFieldsToTab('Root.Metadata', $children);

        $metaTitle->setDescription('Displayed as the tab/window name; Also displayed in search engine result listings as the page title.<br />
									Falls back to the Primary Heading field if not provided.');

    }

    public function updateSettingsFields(FieldList $fields)
    {
        //quick links option
        $fields->addFieldToTab("Root.Settings", new DropdownField('MenuTarget', 'Open page in', [
            ''       => 'Current Tab (Browser default)',
            '_blank' => 'New Tab'
        ]));
    }

    Public function MenuTarget()
    {
        return empty($this->owner->MenuTarget) ? '' : "target=\"{$this->owner->MenuTarget}\"";
    }

    Public function MetaTags(& $tags) {
        if(is_a(Director::get_current_page(), 'Security')){
            $tags = $tags . '<meta name="robots" content="noindex">';
        } 
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();

        $length = $this->owner->config()->MetaDescriptionLength ?: $this->MetaDescriptionLength;
        if (strlen($this->owner->MetaDescription) > $length) {
            /** @var Text $value */
            $value                        = $this->owner->dbObject('MetaDescription');
            $value                        = $value->LimitCharacters($length);
            $this->owner->MetaDescription = $value;
        };
    }
}


