<?php

function inpostgallery_helper_localize($key_word) {
    global $inpostgallery_vocabulary;
    $result = @$inpostgallery_vocabulary[$key_word];
    if (!empty($result)) {
        return $result;
    } else {
        return $key_word;
    }
}
