/**
* If permanent UUID, throw exception <?php echo $uuidColumn ?>
*/
public function preUpdate(PropelPDO $con = NULL) {
	if(!$this->isNew()) {
		if($this->isColumnModified('<?php echo $uuidColumn ?>')) {
			throw new \InvalidArgumentException('You can not change the permanent UUID');
		}
	}
	return true;
}
