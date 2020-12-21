<?php
// 应用公共文件
function GV($var,$key)
{
    return !empty($$var[$key]) ? $$var[$key] : null;
}