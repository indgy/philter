<?php

namespace Indgy;

/**
 * @return Indgy\Philter
 */
function philter(String $str): Philter {
    return new Philter($str);
}
