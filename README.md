# Installation Instructions #
## Composer ##
Run the following to add this module as a requirement and install it via composer.

```
#!bash

composer require "webfox/silverstripe-helpers"
```
then browse to /dev/build?flush=all

Several of these helpers are disabled by default but can be enabled in the config.


#Requirements#
* Silverstripe 3.1+
* php5.4+
* php5-intl Package 

#Extension Overview#

##DataListExtension##
Adds a new *ListColumn* function to a DataList to allow implode() style functionality of the list items e.g. `$list->ListColumn('ID', ' |')` 
would result in something like "1 |18 |19 |24".

##ExtraPageFieldsExtension##
 - Moves the metadata fields to a new tab
 - Adds a new "Meta Title" field
 
##FooterMenuExtension##
 - Adds a new *ShowInFooter* option to the page settings
 - Adds a new `FooterPages()` function to the SiteTree to return only pages that have this checked

#Template Providers Overview#

##HelpersTemplateProvider
 - Adds a new `Repeat($times)` function to the templates to return a loopable list (kind of like a for loop)
 - Adds a new `Dump($obj)` function to the templates to allow easy dumping of any template variable
 
#Extendable Classes Overview#
 
##OwnerPermissionedDataObject##
 - Allows data objects to inherit the access permissions from their attached relation parent
 - Relation parent defaults to `Page()`
 - If `static::$relationOwner` is set to `null` will fall back to asking the standard `Page` for permission
 
#Page Types Overview#
 
##ChildlessPage##
 - This class by itself does nothing 
 - The idea behind this class is that in your template for the main navigation a "ChildlessPage" should never be rendered as a dropdown
 
##NavHolderPage##
 - If accessed directly this page will return a 404
 - The idea behind this class is that it should act as a label for your site navigation and not be a page itself.