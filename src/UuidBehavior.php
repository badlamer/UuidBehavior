<?php

class UuidBehavior extends \Behavior
{

	protected static
		$availUuidVersions = array(1, 4);

	protected $parameters = array(
		'name' => 'uuid',
		'version' => 4,
		'permanent' => 'true',
		'required' => 'true',
		'unique' => 'true'
	);

	public function objectMethods($builder) {

		$script = '';
		if($this->booleanValue($this->getParameter('required'))) {
			$script .= $this->addPreInsertUuidCreateAndSaveHook();
		}

		$script .= $this->addPermanentUuidUpdateHook();

		return $script;
	}

	public function addPreInsertUuidCreateAndSaveHook() {
		$columnPhpName = $this->getTable()->getColumn($this->getParameter('name'))->getPhpName();;
		return $this->renderTemplate('addUuidPreInsertHook', array(
			'uuidColumn' => $columnPhpName,
			'version' => $this->getParameter('version')
		));
	}

	public function addPermanentUuidUpdateHook() {
		$column = $this->getTable()->getColumn($this->getParameter('name'));
		return $this->renderTemplate('addPermanentUuidUpdateHook', array(
			'permanent' => $this->booleanValue($this->getParameter('permanent')),
			'uuidPhpColumn' => $column->getPhpName(),
			'uuidColumn' => $column->getFullyQualifiedName()
		));
	}

	public function modifyTable() {
		$table = $this->getTable();
		if (!$columnName = $this->getParameter('name')) {
			throw new InvalidArgumentException(sprintf(
				'You must define a \'name\' parameter for the \'uuid\' behavior in the \'%s\' table',
				$table->getName()
			));
		}

		$version = $this->getParameter('version');
		if(!in_array($version, static::$availUuidVersions)) {
			throw new InvalidArgumentException(sprintf(
				'Version must be in enum' . implode(', ', static::$availUuidVersions),
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

			if($this->booleanValue($this->getParameter('required')) && $this->booleanValue($this->getParameter('unique'))) {
				// add a unique to column
				$column = $this->getTable()->getColumn($this->getParameter('name'));
				$unique = new Unique();
				$unique->setName($columnName . '_uuid_unique');
				$unique->addColumn($column);
				$this->getTable()->addUnique($unique);
			}
		}
	}
}
