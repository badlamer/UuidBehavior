<?php

class UuidBehaviorFieldTest extends \PHPUnit_Framework_TestCase {

	public function setUp() {
		if(!class_exists('BookWithField')) {
			$schema = <<<XML
<database name="uuid_behavior">
<table name="book_with_field">
<column name="id" required="true" primaryKey="true" autoIncrement="true" type="INTEGER" />
<column name="uuid" type="VARCHAR" size="16" />
<behavior name="uuid">
	<parameter name="version" value="1" />
</behavior>
</table>
</database>
XML;
			$builder = new PropelQuickBuilder();
			$config  = $builder->getConfig();
			$config->setBuildProperty('behavior.uuid.class', __DIR__ . '/../src/UuidBehavior');
			$builder->setConfig($config);
			$builder->setSchema($schema);
			$con = $builder->build();
		}
	}

	public function testUuidCreate() {
		$book = new BookWithField;
		$this->assertTrue(method_exists($book, 'getUuid'));
		$this->assertNull($book->getUuid());
		$book->save();
		$this->assertNotNull($book->getUuid());
	}

	/**
	* @expectedException InvalidArgumentException
	* @expectedExceptionMessage You can not change the permanent UUID
	*/
	public function testUuidChange() {
		$book = new BookWithField;
		$book->save();
		$book->setUuid(\Rhumsaa\Uuid\Uuid::uuid4()->__toString());
		$book->save();
	}
}
