![Philter Logo](https://raw.githubusercontent.com/indgy/philter/main/docs/philter.svg)
##### A PHP fluent input sanitiser.
Philter accepts untrusted input, passes it through some filters and returns it back to you. It is not a substitution for validation.

## Installation
Copy the `src/Philter.php` file to your project, or install using composer:

```sh
composer require indgy/philter
```

## Getting started
Create a new Philter instance passing in the untrusted input, then combine filters for the untrusted input to pass through and finally call [`toFloat()`](https://indgy.github.io/philter/reference/#toFloat), [`toInt()`](https://indgy.github.io/philter/reference/#toInt) or [`toString()`](https://indgy.github.io/philter/reference/#toString) to get the filtered and now trusted input.

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

### Available filters

[`allow(String $chars)`](https://indgy.github.io/philter/reference/#allow)
 - Allow only the characters in \$chars

[`alpha()`](https://indgy.github.io/philter/reference/#alpha) - Allow only a-z

[`alphanum()`](https://indgy.github.io/philter/reference/#alphanum) - Allow only a-z and 0-9

[`ascii()`](https://indgy.github.io/philter/reference/#ascii) - Allow only ASCII chars (32-127), transliterating where possible

[`between(Int $min, Int $max)`](https://indgy.github.io/philter/reference/#between) - Allow values between min and max inclusive

[`contains(String $match)`](https://indgy.github.io/philter/reference/#contains) - Allow values containing \$match

[`cut(Int $length)`](https://indgy.github.io/philter/reference/#cut) - Cut string to \$length

[`digits()`](https://indgy.github.io/philter/reference/#digits) - Allow only 0-9

[`in(Array $items)`](https://indgy.github.io/philter/reference/#in) - Allow if in \$items

[`max(Int $max)`](https://indgy.github.io/philter/reference/#max) - Allow only if less than or equal to \$max

[`min(Int $min)`](https://indgy.github.io/philter/reference/#min) - Allow only if greater than or equal to \$min

[`numeric()`](https://indgy.github.io/philter/reference/#numeric) - Allow only if numeric, e.g. currency string

[`trim()`](https://indgy.github.io/philter/reference/#trim) - Trim characters from beginning and end *(see also `ltrim()` and `rtrim()`)*

[`utf8()`](https://indgy.github.io/philter/reference/#utf8) - Convert to UTF-8 transliterating where possible


Refer to the [Reference](https://indgy.github.io/philter/reference/index.html) for more detail on the filters.

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
Refer to the [user guide](https://indgy.github.io/philter/index.html) or browse the [API ](https://indgy.github.io/philter/api/index.html).
