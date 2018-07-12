# Installation Instructions #
## Composer ##
Run the following to add this module as a requirement and install it via composer.

```
#!bash

composer require "webfox/silverstripe-helpers"
```

Add the following to your  `config.yml`:

```yaml
Page:
  has_on_after_update_cms_fields: true
```

then browse to /dev/build?flush=all

Several of these helpers are disabled by default but can be enabled in the config.


# Requirements 
* Silverstripe 3.1+
* php5.4+
* php5-intl Package 

# Extension Overview

## DataListExtension
 - Adds a new *ListColumn* function to a DataList to allow implode() style functionality of the list items  
   e.g. `$list->ListColumn('ID', ' |')` would result in something like "1 |18 |19 |24".
 - Automatically applied

## ExtraPageFieldsExtension
 - Moves the metadata fields to a new tab
 - Adds a new "Meta Title" field
 - Automatically applied
 
If you do not add the `HasOnAfterUpdateCMSFieldsExtensionPoint` trait to your base `Page` class then the extension will use an unreliable method of moving the pages. For this reason we suggest adding `use HasOnAfterUpdateCMSFieldsExtensionPoint;` to this class.

If you have a custom constructor already you will need to alias the traits constructor so you may call it.

```php
class Page extends SiteTree {

    use HasOnAfterUpdateCMSFieldsExtensionPoint {
        HasOnAfterUpdateCMSFieldsExtensionPoint::__construct as __TraitConstruct;
    }
    
    public function __construct($record = null, $isSingleton = false, $model = null){
        
        $this->__TraitConstruct($record, $isSingleton, $model);
        
        //your custom things
        
        parent::__construct($record, $isSingleton, $model);
    }

}
```

## Relative Assets Extension
 - Prefixes all references to `assets/*` with a preceeding slash i.e. they become something like `/assets/some.png`
 - If [zaininnari/html-minifier](https://github.com/zaininnari/html-minifier) is installed minifies the HTML output before rendering.
 - If Assets.host config is set then Assets will be prefixed with this host.
 
```yaml
Assets:
  host: '//example.com/'
```
Would equal `//example.com/assets/image.png`

## FooterMenuExtension
 - Adds a new *ShowInFooter* option to the page settings
 - Adds a new `FooterPages()` function to the SiteTree to return only pages that have this checked

## ImageExtension
 - Adds a new *Image Alt Text* option to the image settings
 - Makes the image settings fields full width
 - Automatically applied
 
## LinkExtension
 - Adds a new *SEO Text* option to the link settings
 - Adds a *force download* checkbox to the link if it's set to a file.
 - Automatically applied

# Template Providers Overview

## HelpersTemplateProvider
 - Adds a new `Repeat($times)` function to the templates to return a loopable list (kind of like a for loop)
 - Adds a new `Dump($obj)` function to the templates to allow easy dumping of any template variable
 
# Extendable Classes Overview
 
## OwnerPermissionedDataObject
 - Allows data objects to inherit the access permissions from their attached relation parent
 - Relation parent defaults to `Page()`
 - If `static::$relationOwner` is set to `null` will fall back to asking the standard `Page` for permission
