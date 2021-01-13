# Reference

## Return methods

Philter will apply each filter and return the required scalar type by calling the to*() methods, call one of these methods after you have specified your filters:

### toString()

```php
"abcc-123.456" = philter("abc-123.456")->toString();
```

### toInt()

```php
123 = philter("123.456")->toInt();
```

### toFloat()

```php
123.456 === philter("123.456")->toFloat();
```

### toBool()

```php
true === philter("1")->toBool();
```

The input is never modified so it is possible to reuse filters and return a different type:

```php
$filter = philter("1")->digits(); 

"1" === $filter->toString();
true === $filter->toBool();
```

### Returning a default value
If the input does not pass through a filter, a null value will be returned to the to*() method. Use the `default()` method to specify a default value to return;





## String filters

The following filters accept any string or numeric input.

### allow()
Removes any characters that are not in the allow list, pass the allowed characters as a regex:

```php
"abccc" = philter("abcccdef")->allow("a-c")->toString();
```

### ascii()
Replaces any non ASCII characters with a non accented approximation:

```php
"creme brulee" = philter("crème brûlée")->ascii()->toString();
```

### alpha()
Removes any non alphabetical characters:

```php
"abc" = philter("abc 123")->alpha()->toString();
```

Pass in additional allowed characters as the first argument:

```php
"abc 2" = philter("abc 123")->alpha("2\s")->toString();
```

### alphanum()
Removes any non alpha-numeric characters:

```php
"abc123" = philter("abc-123")->alphanum()->toString();
```

Pass in additional allowed characters as the first argument:

```php
"abc-123" = philter("abc-1,2,3")->alpha("-")->toString();
```

### contains()
Checks that the variable contains the string in \$match:

```php
"This will pass" = philter("This will pass")->contains("this")->toString();
```

By default this is not case sensitive, pass a Boolean true to match case:

```php
null = philter("This will not pass")->contains("this", true)->toString();
```

### cut()
Shortens the length to \$len characters

```php
$str = "This string is probably too long to be a title and will probably break the designers page layout";
"This string is" = philter($str)->cut(15)->trim()->toString();
```

### digits()
A stricter version of numeric, this removes any non numeric characters allowing only 0-9 and decimal point:

```php
123 = philter("abc-123.456")->digits()->toInt();
123.456 = philter("abc-123.456")->digits()->toFloat();
"123.456" = philter("abc-123.456")->digits()->toString();
```

Pass in additional allowed characters as the first argument:

```php
"+15556677" = philter("+1 555 6677")->digits("+\s")->toString();
```

### email()
Removes any characters that should not be in an email address:

```php
"user@example.com" = philter("[user]@!!example!!.com")->email()->toString();
```
Note: This is a simple filter, but probably stricter than the built in filter_var() method


### in()
Ensures the input matches a value contained in the array:

```php
"date" = philter("date")->in(["id","date","status"])->toString();
```

By default this is not case sensitive, pass a Boolean true to match case:

```php
null = philter("date")->in(["Id","Date","Status"], true)->toString();
```

Use `default()` to return a default value if not matched:

```php
"date" = philter("price")->in(["id","date","status"])->default("date")->toString();
```

### numeric()

Removes any non numeric characters allowing common number markup such as + or - decimal points, commas, brackets and spaces:

```php
"+(1) 555 4567" = philter("+(1) 555 4567")->numeric()->toString();
```

Pass in additional allowed characters as the first argument:

```php
"+(1) 555-4567" = philter("+1 555-6677")->numeric("-")->toString();
```

### trim()
*See also `ltrim()` and `rtrim()`*

Trims the leading and trailing characters from the variable:

```php
"abcdef" = philter("  abcdef  ")->trim()->toString();
```

Pass in the character to trim as the first argument:

```php
"abcdef" = philter("/abcdef/")->trim("/")->toString();
```


## Numeric filters

The following filters expect the input to be numeric.

### between()
Ensures the input is a value between \$min and \$max

```php
45 = philter("45")->between(1, 100)->toInt();
```

### min()
Ensures the input is no less than the value of \$min

```php
15 = philter("15")->min(10)->toInt();
```

### max()
Ensures the input is no greater than the value of \$max

```php
95 = philter("95")->max(100)->toInt();
```

## HTML filters

The following filters handle HTML filtering.

### stripHtml()
Removes all HTML:

```php
"Hello world!" = philter("<h1>Hello world!</h1>")->stripHtml()->toString();
```

### stripTags()
Removes the majority of HTML tags and javascript leaving the basic tags:

```php
"<h1>Hello world!</h1>" = philter("<h1>Hello world!</h1><script>doSomething():</script>")->stripHtml()->toString();
```

### stripAttributes()
Removes all attributes from HTML tags:

```php
"<h1>Hello world!</h1>" = philter("<h1 class='big red'>Hello world!</h1>")->stripAttributes()->toString();
```

