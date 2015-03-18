<?php
/**
 * This page can be used if you would like remove a dropdown in the main nav if there are children pages.
 * This is just to be used as a placeholder in the nav to allow a dropdown with children but not be linkable or have a page itself. 
 * Landing on this page will give a 404
 * 
 * You will need to wrap the nav dropdown code in 
 * 
 * <% if $ClassName != 'NavHolderPage' %>
 *  .... your sub nav here ....
 * <% end_if %>
 *
 */
class NavHolderPage extends Page {

	/**
	 * Set to return false if this page should not be added to as the first child of it's dropdown list if it is a parent
	 *
	 * @return bool
	 */
	public function ShowInDropdownIfParent(){
		return false;
	}
}


class NavHolderPage_Controller extends Page_Controller {

	public function init() {
		parent::init();
	}
	
	
	public function index() { 
		throw new SS_HTTPResponse_Exception(ErrorPage::response_for(404), 404);
	}
	
}
