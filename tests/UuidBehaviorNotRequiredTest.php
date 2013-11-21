<?php

class UuidBehaviorNotRequiredTest extends \PHPUnit_Framework_TestCase {

	public function setUp() {
		if(!class_exists('BookNotRequiredUuid')) {
			$schema = <<<XML
<database name="uuid_behavior">
<table name="Book_not_required_uuid">
<column name="id" required="true" primaryKey="true" autoIncrement="true" type="INTEGER" />
<behavior name="uuid">
	<parameter name="version" value="1" />
	<parameter name="required" value="false" />
	<parameter name="permanent" value="false" />
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

	public function testUuidCreateNotRequired() {
		$book = new BookNotRequiredUuid;
		$this->assertTrue(method_exists($book, 'getUuid'));
		$this->assertNull($book->getUuid());
		$book->save();
		$this->assertNull($book->getUuid());
	}

	public function testUuidChange() {
		$book = new BookNotRequiredUuid;
		$book->save();
		$book->setUuid('ffff');
		$this->assertEquals(1, $book->save());
	}

}
