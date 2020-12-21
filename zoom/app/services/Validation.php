<?php
namespace app\services;

class Validation
{
    static private $data = null;

    static public function data($data=null)
    {
        if ($data !== null)
            self::$data = $data;
        return self::$data;
    }

    /**
     * form data validation.
     * rule format: ['field' => rule]
     */
    static public function validate($rule=null, $data=null)
    {
        if ($rule === null)
            return true;
        if ($data !== null)
            self::data($data);
        if (!$_REQUEST && !self::$data)
            return false;
        $data = self::$data ? self::$data : $_REQUEST;

        foreach ($rule as $field => $row)
            foreach ($row as $cell)
                if (!self::validation(@$data[$field], $cell))
                    return false;
        return true;
    }

    /**
     * check field rule.
     */
    static private function validation($val, $rule)
    {
        switch ($rule) {
            case is_integer($rule):
                return (strlen($val) === $rule);
                break;
            case is_array($rule):
                switch (current($rule)) {
                    case 'in':
                        return in_array($val, end($rule));
                        break;
                }
                break;
            default:
                return self::regex($val, $rule);
        }
    }

    /**
     * verify data with Regular.
     * @access public
     * @param string $value | Unverified data
     * @param string $rule  | Validation rules
     * @return boolean
     */
    static private function regex($value=null, $rule=null)
    {
        if ($value === null || $rule === null)
            return true;
        $validate = array(
            'require'   => '/\S+/',
            'email'     => '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',
            'url'       => '/^http(s?):\/\/(?:[A-za-z0-9-]+\.)+[A-za-z]{2,4}(:\d+)?(?:[\/\?#][\/=\?%\-&~`@[\]\':+!\.#\w]*)?$/',
            'currency'  => '/^\d+(\.\d+)?$/',
            'number'    => '/^\d+$/',
            'zip'       => '/^\d{6}$/',
            'integer'   => '/^[-\+]?\d+$/',
            'double'    => '/^[-\+]?\d+(\.\d+)?$/',
            'english'   => '/^[A-Za-z]+$/',
        );
        // 检查是否有内置的正则表达式
        if(isset($validate[strtolower($rule)]))
            $rule = $validate[strtolower($rule)];
        return preg_match($rule,$value)===1;
    }
}
