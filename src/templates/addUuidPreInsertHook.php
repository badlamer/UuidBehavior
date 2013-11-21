/**
* Create UUID if is NULL <?php echo $uuidColumn ?>
*/
public function preInsert(PropelPDO $con = NULL) {

	if(is_null($this->get<?php echo $uuidColumn ?>())) {
		$this->set<?php echo $uuidColumn ?>(\Rhumsaa\Uuid\Uuid::uuid<?php echo $version ?>()->__toString());
	} else {
		$uuid = $this->get<?php echo $uuidColumn ?>();
		if(!\Rhumsaa\Uuid\Uuid::isValid($uuid)) {
			throw new \InvalidArgumentException('UUID: ' . $uuid . ' in not valid');
			return false;
		}
	}
	return true;
}
