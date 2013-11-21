UuidBehavior
============

Helps you add UUID for propel ActiveRecord

[![Build Status](https://travis-ci.org/badlamer/UuidBehavior.png)](https://travis-ci.org/badlamer/UuidBehavior)


### Requirements

This behavior requires Propel >= 1.6.0 and  Rhumsaa\Uuid for PHP >= 2.5.0

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
  <column name="name" type="VARCHAR" required="true" />
</table>

<table name="friend">
  <behavior name="uuid">
    <parameter name="name" value="uuid_column" />
  </behavior>
  <!-- you do not need to specify any colums for the "friend" table, the behavior will add them automatically -->
</table>
```
