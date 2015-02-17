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
		if ($this->hasMethod(self::$relationOwnerMethod)) {
			return $this->{self::$relationOwnerMethod}();
		} else {
			throw new BadMethodCallException(
				sprintf('Method "%s" not found - Is %s::$relationOwnerMethod correct?', self::$relationOwnerMethod, get_class($this))
			);
		}
	}

	public function canView($member = null) {
		return $this->RelationOwner()->canView($member);
	}

	public function canEdit($member = null) {
		return $this->RelationOwner()->canEdit($member);
	}

	public function canDelete($member = null) {
		return $this->RelationOwner()->canDelete($member);
	}

	public function canCreate($member = null) {
		return $this->RelationOwner()->canCreate($member);
	}
}