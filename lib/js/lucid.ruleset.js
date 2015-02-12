lucid.ruleset = function(newRules){
    this.rules = newRules;
};

lucid.ruleset.prototype.checkData=function(data){
    // a hash to store all of the error messages.
    var errors = {};
    var countErrors = 0;
    for(var i=0;i<this.rules.length;i++){
        // if the rule fails...
        if(!this.checkRule(this.rules[i],data)){
            // make sure the hash index is an array
            if(typeof(errors[this.rules[i]['field']]) !== 'object'){
                errors[this.rules[i]['field']] = [];
            }

            // push the error message onto the list of errors
            errors[this.rules[i]['field']].push(this.rules[i]['error']);
            countErrors++;
        }
    }
    return (countErrors > 0)?errors:true;
};

lucid.ruleset.prototype.checkRule=function(rule, data){
    switch(rule['type']){
        case 'length':
            var field = rule['field'];
            var value = new String(( typeof data[field] != "undefined" ) ? data[field]:'');
            var min   = ( typeof rule['min'] != "undefined" ) ? rule['min']:0;
            var max   = ( typeof rule['max'] != "undefined" ) ? rule['max']:9999999;
            return (value.length >= min && value.length <= max);
            break;
        case 'valid_email':
            return true;
            break;
        default:
            break;
    }
    return true;
};

lucid.rulesets = {};
