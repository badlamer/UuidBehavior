/**
* If permanent UUID, throw exception <?php echo $uuidColumn ?>
*/
public function preUpdate(PropelPDO $con = NULL) {
	<?php if ($permanent) :?>
	if(!$this->isNew()) {
		if($this->isColumnModified('<?php echo $uuidColumn ?>')) {
			throw new \InvalidArgumentException('You can not change the permanent UUID');
		}
	}
	<?php else :?>
	$uuid = $this->get<?php echo $uuidPhpColumn ?>();
	if(!is_null($uuid) && !\Ramsey\Uuid\Uuid::isValid($uuid)) {
		throw new \InvalidArgumentException("UUID: $uuid in not valid");
	}
	<?php endif; ?>
	return true;
}
