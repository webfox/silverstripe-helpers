<?php

/**
 * Class LinkExtension
 *
 * @property Link $owner
 */
class LinkExtension extends DataExtension {

    private static $db = [
        'LinkSeoText'   => 'Varchar(255)',
        'ForceDownload' => 'Boolean'
    ];

    private static $has_one = [
        'OwningPage' => 'Page'
    ];

    public function updateCMSFields(FieldList $fields) {

        $fields->dataFieldByName('Title')->setTitle(_t('Linkable.TITLE', 'Link Text'));

        $fields->dataFieldByName('OpenInNewWindow')->hideIf("Type")->isEqualTo("File")->end();

        /** @var TextField $seoText */
        $fields->addFieldToTab('Root.Main', $seoText = TextField::create('LinkSeoText', _t('Linkable.SEOTEXT', 'SEO Title Attribute')), 'Type');
        $seoText->setDescription('Optional. Will be equal to Link Text if left blank');

        $fields->addFieldToTab('Root.Main', $forceDownload = CheckboxField::create('ForceDownload',
            _t('Linkable.FORCEDOWNLOAD', 'Force user to download file')));
        $forceDownload->displayIf('Type')->isEqualTo("File")->end();

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

    public function getTitleAttribute() {
        return ' title="' . ($this->owner->LinkSeoText ?: $this->owner->Title) . '" ';
    }

    public function getAttributes(){

        return join(' ', [$this->owner->getTargetAttr(), $this->getDownloadAttribute(), $this->getTitleAttribute()]);
    }
    
    public function canView($member = null) {
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    public function canEdit($member = null) {
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    public function canDelete($member = null) {
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    public function canCreate($member = null) {
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }
}
