<?php

class UuidBehaviorTest extends \PHPUnit_Framework_TestCase {

	public function setUp() {
		if(!class_exists('Book')) {
			$schema = <<<XML
<database name="uuid_behavior">
<table name="book">
<column name="id" required="true" primaryKey="true" autoIncrement="true" type="INTEGER" />
<behavior name="uuid">
	<parameter name="version" value="1" />
	<parameter name="name" value="uuid_column" />
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
		$book = new Book;
		$this->assertTrue(method_exists($book, 'getUuidColumn'));
		$this->assertNull($book->getUuidColumn());
		$book->save();
		$this->assertNotNull($book->getUuidColumn());
	}

	/**
	* @expectedException InvalidArgumentException
	*/
	public function testUuidCreateNotValid() {
		$book = new Book;
		$book->setUuidColumn('ffff');
		$book->save();
	}


	/**
	* @expectedException InvalidArgumentException
	* @expectedExceptionMessage You can not change the permanent UUID
	*/
	public function testUuidChange() {
		$book = new Book;
		$book->save();
		$book->setUuidColumn(\Rhumsaa\Uuid\Uuid::uuid4()->__toString());
		$book->save();
	}

	/**
	* @expectedException PropelException
	*/
	public function testUniqueUuid() {
		$book = new Book;
		$book->save();
		$book2 = new Book;
		$book2->setUuidColumn($book->getUuidColumn());
		$book2->save();
	}
}
