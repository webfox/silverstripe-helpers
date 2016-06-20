<?php

/**
 * Class CustomSiteConfig
 *
 * @property SiteConfig $owner
 */
class WebFoxSiteConfig extends DataExtension {

    static $db = [
        'CustomHeaderOutput' => 'Text',
        'CustomFooterOutput' => 'Text'
    ];

    static $has_one = [
        'PrivacyPolicyPage'      => 'SiteTree',
        'TermsAndConditionsPage' => 'SiteTree'
    ];

    public function updateCMSFields(FieldList $fields) {

        $fields->addFieldsToTab('Root.Main', [
            TreeDropdownField::create('PrivacyPolicyPageID', 'Privacy Policy', 'SiteTree'),
            TreeDropdownField::create('TermsAndConditionsPageID', 'Terms & Conditions', 'SiteTree')
        ]);

        $fields->addFieldsToTab('Root.Advanced', [
            TextareaField::create('CustomHeaderOutput', 'Custom Header Tags'),
            TextareaField::create('CustomFooterOutput', 'Custom Footer Tags')
        ]);
    }
}