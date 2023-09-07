<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;

class ValidatorCustom implements Validator
{
    public function getMessageBag()
    {
        // TODO: Implement getMessageBag() method.
    }

    public function validate()
    {
        // TODO: Implement validate() method.
    }

    public function validated()
    {
        // TODO: Implement validated() method.
    }

    public function fails()
    {
        // TODO: Implement fails() method.
    }

    public function failed()
    {
        // TODO: Implement failed() method.
    }

    public function sometimes($attribute, $rules, callable $callback)
    {
        // TODO: Implement sometimes() method.
    }

    public function after($callback)
    {
        // TODO: Implement after() method.
    }

    public function errors()
    {
        // TODO: Implement errors() method.
    }
}
