<?php

class lucid_ruleset
{
    function __construct()
    {
        $this->rules = func_get_args();
    }

    function check_data($data)
    {
        $msgs = [];
        foreach($this->rules as $rule)
        {
            if(!$this->check_rule($rule,$data))
            {
                if(!isset($msgs[$rule[0]]) or !is_array($msgs[$rule[0]]))
                {
                    $msgs[$rule[0]] = [];
                }
                $msgs[$rule[0]][] = array_pop($rule);
            }
        }
        return (count($msgs) > 0)?$msgs:true;
    }

    function check_rule($rule,$data)
    {
        switch($rule[1])
        {
            case 'length':
                $field = $rule[0];
                $value = (isset($data[$field]))?$data[$field]:'';
                $min   = $rule[2];
                $max   = $rule[3];
                return (strlen($value) >= $min and strlen($value) <= $max);
                break;
            case 'valid_email':
                return true;
                break;
            default:
                break;
        }
        return true;
    }
}

?>