<?php
/**
 * This page can be used if you would like remove a dropdown in the main nav if there are children pages.
 * It is otherwise just a normal page
 * 
 * You will need to wrap the nav dropdown code in 
 * 
 * <% if $ClassName != 'ChildlessPage' %>
 *  .... your sub nav here ....
 * <% end_if %>
 *
 */
class ChildlessPage extends Page {

	/**
	 * Set to return true if this page should not show it's children in the nav
	 *
	 * @return bool
	 */
	public function HideChildrenFromNavigation() {
		return true;
	}
}


class ChildlessPage_Controller extends Page_Controller {

	public function init() {
		parent::init();
	}
	

}
