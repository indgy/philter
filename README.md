![Philter Logo](https://raw.githubusercontent.com/indgy/philter/main/docs/philter.svg)
##### A PHP fluent input sanitiser.

Philter accepts untrusted input, passes it through some filters and returns it back to you. It is not a substitution for validation.

## Installation

Copy the `src/Philter.php` file to your project, or install using composer:

```sh
composer require indgy/philter
```



## Getting started
Create a new Philter instance passing in the untrusted input, then combine filters for the untrusted input to pass through and finally call `toFloat()`, `toInt()` or `toString()` to get the filtered and now trusted input.

```php
use \Indgy\Philter;

$f = new Philter($unsafe_input);
$str = $f->in(['safe','string','options'])
	->default('safe')
	->toString();
```

There is also a handy shortcut function to return a new Philter instance:

```php
use function \Indgy\philter;

$str = philter($unsafe_input)
	->in(['safe','string','options'])
	->default('safe')
	->toString();
```

Refer to the [documentation](https://indgy.github.io/philter/index.html) to view the available filters.

 

## Custom filters
Define custom filters using the `apply()` method with a closure. The closure will be passed the current input value and expects it, or null to be returned.

```php
philter('Here we go.. ')->apply(function($v) {
	// do your thing here
	$v = $v.=  'I was philtered';
	// always return $v or null
	return $v;
})->toString();


```

## Documentation
See the documentation or browse the API docs for more details. 

