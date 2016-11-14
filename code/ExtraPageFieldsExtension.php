<?php

/**
 * Class ExtraPageFieldsExtension
 *
 */
class ExtraPageFieldsExtension extends SiteTreeExtension
{

    private $MetaDescriptionLength = 156;

    protected static $runs = 0;

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

        $traits = $this->traitsUsedRecursive($this->owner->ClassName);
        if (!in_array('HasOnAfterUpdateCMSFieldsExtensionPoint', $traits)) {
            $this->afterUpdateCMSFields($fields);
        }
    }

    protected function traitsUsedRecursive($class, $traitNames = [])
    {
        if (!$class instanceof ReflectionClass) $class = new ReflectionClass($class);
        $traitNames = array_merge($traitNames, $class->getTraitNames());
        if ($class->getParentClass() != false) {
            return array_merge($traitNames, $this->traitsUsedRecursive($class->getParentClass()));
        }

        return $traitNames;
    }

    public function afterUpdateCMSFields(FieldList $fields)
    {
        self::$runs++;

        /** @var ToggleCompositeField $metaDataChildren */
        $metaDataChildren = $fields->fieldByName('Root.Main.Metadata');
        $length           = $this->owner->config()->MetaDescriptionLength ?: $this->MetaDescriptionLength;
        if (!$metaDataChildren->fieldByName('MetaDescription')) {
            ddd(self::$runs);
        }
        $metaDataChildren->fieldByName('MetaDescription')->setAttribute('maxlength', $length);

        $children = array_merge([$metaTitle = TextField::create('MetaTitle')], $metaDataChildren->getChildren()->toArray());
        $fields->removeFieldFromTab('Root.Main', 'Metadata');
        $fields->addFieldToTab('Root', Tab::create('Metadata'), 'Content');

        //Add META Title tag to METADATA
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

    Public function MetaTags(& $tags)
    {
        if (is_a(Director::get_current_page(), 'Security')) {
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

trait HasOnAfterUpdateCMSFieldsExtensionPoint
{
    public function __construct($record = null, $isSingleton = false, $model = null)
    {
        parent::__construct($record, $isSingleton, $model);

        $this->afterExtending('updateCMSFields', function (FieldList $fields) {
            $this->extend('afterUpdateCMSFields', $fields);
        });
    }

}


