<?php

class UuidBehavior extends \Behavior
{

	protected static
		$availUuidVersions = array(1, 4);

	protected $parameters = array(
		'name' => 'uuid',
		'version' => 4,
		'permanent' => "true",
		'required' => "true",
		'uniqie' => "true"
	);

	public function objectMethods($builder) {

		$script = '';
		if($this->booleanValue($this->getParameter('required'))) {
			$script .= $this->addPreInsertUuidCreateAndSaveHook();
		}

		if($this->booleanValue($this->getParameter('permanent'))) {
			$script .= $this->addPermanentUuidUpdateHook();
		}

		return $script;
	}

	public function addPreInsertUuidCreateAndSaveHook() {
		$columnPhpName = $this->getTable()->getColumn($this->getParameter('name'))->getPhpName();;
		return $this->renderTemplate('addUuidPreInsertHook', array(
			'uuidColumn' => $columnPhpName,
			'version' => $this->getParameter('version')
		)) . "\n";
	}

	public function addPermanentUuidUpdateHook() {
		$columnName = $this->getTable()->getColumn($this->getParameter('name'))->getFullyQualifiedName();
		return $this->renderTemplate('addPermanentUuidUpdateHook', array(
			'uuidColumn' => $columnName
		)) . "\n";
	}

	public function modifyTable() {
		$table = $this->getTable();
		if (!$columnName = $this->getParameter('name')) {
			throw new InvalidArgumentException(sprintf(
				'You must define a \'name\' parameter for the \'aggregate_column\' behavior in the \'%s\' table',
				$table->getName()
			));
		}

		$version = $this->getParameter('version');
		if(!in_array($version, static::$availUuidVersions)) {
			throw new InvalidArgumentException(sprintf(
				'Verions mst be in enum' . implode(', ', static::$availUuidVersions),
				$table->getName()
			));
		}

		// add the aggregate column if not present
		if(!$table->containsColumn($columnName)) {
			$table->addColumn(array(
				'name'    => $columnName,
				'type'    => 'CHAR',
				'size'	  => 36,
				'required' => $this->getParameter('required'),
			));
		} else {
			$column = $this->getTable()->getColumn($this->getParameter('name'));
			$column->setNotNull(
				$this->booleanValue($this->getParameter('required'))
			);
			$column->setSize(36);
			$column->setType('CHAR');
			$column->setUnique($this->booleanValue($this->getParameter('unique')));
		}
	}
}
