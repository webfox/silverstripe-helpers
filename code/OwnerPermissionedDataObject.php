<?php

/**
 * Class OwnerPermissionedDataObject
 *
 * By default a dataobject will deny permission to anyone that is not an administrator
 * This class allows it to fall back to using the relation owners can*() methods
 */
class OwnerPermissionedDataObject extends DataObject {

	protected static $relationOwnerMethod = 'Page';

	/**
	 * @return DataObject
	 */
	protected function RelationOwner() {
		if (is_null(static::$relationOwnerMethod)) {
			return false;
		} elseif ($this->hasMethod(static::$relationOwnerMethod)) {
			return $this->{static::$relationOwnerMethod}();
		} else {
			throw new BadMethodCallException(
				sprintf('Method "%s" not found - Is %s::$relationOwnerMethod correct?', self::$relationOwnerMethod, get_class($this))
			);
		}
	}

	public function canView($member = null) {
		return $this->askOwnerForPermission(__FUNCTION__, $member);
	}

	public function canEdit($member = null) {
		return $this->askOwnerForPermission(__FUNCTION__, $member);
	}

	public function canDelete($member = null) {
		return $this->askOwnerForPermission(__FUNCTION__, $member);
	}

	public function canCreate($member = null) {
		return $this->askOwnerForPermission(__FUNCTION__, $member);
	}

	protected function askOwnerForPermission($method, $member){
		return $this->RelationOwner() ? $this->RelationOwner()->{$method}($member) : singleton('Page')->{$method}($member);
	}
}
