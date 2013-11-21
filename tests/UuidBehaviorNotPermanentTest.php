<?php

class UuidBehaviorNotPermanentTest extends \PHPUnit_Framework_TestCase {

	public function setUp() {
		if(!class_exists('BookNotPermanent')) {
			$schema = <<<XML
<database name="uuid_behavior">
<table name="book_not_permanent">
<column name="id" required="true" primaryKey="true" autoIncrement="true" type="INTEGER" />
<behavior name="uuid">
	<parameter name="version" value="1" />
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


	/**
	* @expectedException InvalidArgumentException
	* @expectedExceptionMessage UUID: fff in not valid
	*/
	public function testParmanentUuid() {
		$book = new BookNotPermanent;
		$book->save();
		$this->assertNotNull($book->getUuid());
		$book->setUuid('fff');
		$book->save();
	}
}
