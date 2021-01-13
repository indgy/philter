![philter.svg](https://github.com/indgy/philter/docs/philter.svg)
# Philter
A fluent input sanitiser.

## Installation

Install using composer:

```sh
composer require indgy/philter
```

## Getting started
Philter is extremely simple to use, just call the class padding in your untrusted input, combine the filters and finally call `toFloat()`, `toInt()` or `toString()`: 

```php
$f = new Philter($unsafe_input);
$str = $f->in(['safe','string','options'])
	->default('safe')
	->toString();
```

There is a cleaner function shortcut which returns a new Philter instance:

```php
$str = filter($unsafe_input)
	->in(['safe','string','options'])
	->default('safe')
	->toString();
```


## Custom filters
	You may define one-off custom filters using the `apply()` method with a closure which accepts the variable being filtered:

```php
filter($string)->apply(function($v) {
	// do your thing here
	$v = $v.=  'I was philtered';
	// always return $v or null
	return $v;
})->toString();
```

## Available filters

### String
### Numeric
### Range
### Regex

