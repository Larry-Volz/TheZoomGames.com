<?php
// 应用公共文件
function GV($var=null,$key=null)
{
    if ($var === null)
        return null;
    if ($key === null) {
        if (!empty($var))
            $ret = $var;
        else
            $ret = !empty($GLOBALS[$var]) ? $GLOBALS[$var] : null;
    }

    if (!empty($$var[$key]))
        $ret = $$var[$key];
    else
        $ret = !empty($GLOBALS[$var][$key]) ? $GLOBALS[$var][$key] : null;
    if ($ret === $var)
        return null;
}

function isEmpty($val=null): bool
{
    return empty($val);
}