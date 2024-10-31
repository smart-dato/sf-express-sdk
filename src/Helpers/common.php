<?php

if (! function_exists('pkcs7_encode')) {
    function pkcs7_encode($text): string
    {
        $text_length = strlen($text);

        $amount_to_pad = 32 - ($text_length % 32);
//        if ($amount_to_pad == 0) {
//            $amount_to_pad = 32;
//        }

        $pad_chr = chr($amount_to_pad);
        $tmp = str_repeat($pad_chr, $amount_to_pad);

        return $text.$tmp;
    }
}
if (! function_exists('pkcs7_decode')) {
    function pkcs7_decode($text): string
    {
        $pad = ord(substr($text, -1));
        if ($pad < 1 || $pad > 32) {
            $pad = 0;
        }

        return substr($text, 0, (strlen($text) - $pad));
    }
}
