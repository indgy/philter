<?php

namespace Indgy;

use Indgy\Philter;

/**
 * Shortcut to create a new Philter instance.
 * @param mixed $var The variable to be filtered
 * @param bool $trim Trim unprintable characters and whitespace
 */
function philter(mixed $var, bool $trim=true): Philter {
    return new Philter($var, $trim);
}
