<?php

class lucid_ruleset
{
    function __construct()
    {
        $this->rules = func_get_args();
    }

    function check_data($data)
    {
        # a hash to store all of the error messages.
        $errors = [];
        foreach($this->rules as $rule)
        {
            # if the rule fails...
            if(!$this->check_rule($rule,$data))
            {
                # make sure the hash index is an array
                if(!isset($errors[$rule['field']]) or !is_array($errors[$rule['field']]))
                {
                    $errors[$rule['error']] = [];
                }

                # push the error message onto the list of errors
                $errors[$rule['field']][] = $rule['error'];
            }
        }
        return (count($errors) > 0)?$errors:true;
    }

    function check_rule($rule,$data)
    {
        switch($rule['type'])
        {
            case 'length':
                $field = $rule['field'];
                $value = (isset($data[$field]))?$data[$field]:'';
                $min   = (isset($rule['min']))?$rule['min']:0;
                $max   = (isset($rule['max']))?$rule['max']:9999999;
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

    function render_js($form_name)
    {
        $js = 'lucid.rulesets[\''.$form_name.'\'] = new lucid.ruleset('.json_encode($this->rules).');';
        lucid::javascript($js);
    }
}

?>