UuidBehavior
============

Helps you add UUID for propel ActiveRecord

[![Build Status](https://travis-ci.org/badlamer/UuidBehavior.png)](https://travis-ci.org/badlamer/UuidBehavior)


### Requirements

This behavior requires Propel >= 1.6.0 and Ramsey\Uuid for PHP >= 5.4

### Installation

Get the code by cloning this repository, or by using Composer (recommended):

```javascript
{
    "require": {
        "badlamer/propel-uuid-behavior": "dev-master"
    }
}
```

Then, if you don't use Composer, or an autoloader in your application, add the
following configuration to your `build.properties` or `propel.ini` file:

```ini
propel.behavior.uuid.class = vendor.badlamer.propel-uuid-behavior.src.UuidBehavior
```

> Note: `vendor.badlamer.propel-uuid-behavior.src.UuidBehavior` is the path to access the `UuidBehavior` class in "dot-path" notation.


Then declare the behavior in your `schema.xml`:

```xml
<table name="person">
  <!--
    Explict define a column, else the beavior would create a colum called "uuid".
    We need to have at least one column with primaryKey="true" to avoid the error:
      >>Fatal error: Uncaught Error: Call to a member function getPhpName() on null in [...] vendor/propel/propel1/generator/lib/builder/om/QueryBuilder.php:478<<
  -->
  <column name="id" type="CHAR" size="36" required="true" primaryKey="true" />
 
  <!--
    We are linking the column with the name >>id<< to the behavior.
    Now the uuid generation is used for each new created entity.
  -->
  <behavior name="uuid">
    <parameter name="name" value="id" />
  </behavior>
</table>
```
