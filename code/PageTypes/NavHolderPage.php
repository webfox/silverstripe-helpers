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

}


class NavHolderPage_Controller extends Page_Controller {

	public function init() {
		parent::init();
	}
	
	
	public function index() { 
		throw new SS_HTTPResponse_Exception(ErrorPage::response_for(404), 404);
	}
	
}
