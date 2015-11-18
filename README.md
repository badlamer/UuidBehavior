UuidBehavior
============

Helps you add UUID for propel ActiveRecord

[![Build Status](https://travis-ci.org/badlamer/UuidBehavior.png)](https://travis-ci.org/badlamer/UuidBehavior)


### Requirements

This behavior requires Propel >= 1.6.0 and Ramsey\Uuid for PHP >= 3

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
  <behavior name="uuid">
    <parameter name="name" value="uuid_column" />
  </behavior>
</table>
```
