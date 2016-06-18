<?php

/**
 * Multibyte version of str_pad.
 */
function multibyte_str_pad($string, $pad_length, $pad_string = ' ', $pad_type = STR_PAD_RIGHT, $encoding = null)
{
    $encoding = $encoding ? $encoding : mb_internal_encoding();
    $pad_length = $pad_length + strlen($string) - mb_strlen($string, $encoding);

    return str_pad($string, $pad_length, $pad_string, $pad_type);
}
