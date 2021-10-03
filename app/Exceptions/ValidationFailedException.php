<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;

class ValidationFailedException extends Exception
{
    /**
     * Exception Render Method
     *
     * @return response
     */
    public function render()
    {
        throw new HttpResponseException(
            response()->json(
                [
                    'isvalid'   => false,
                    'result'    => "Error",
                    'errors'    => $this->getMessage(),
                    'status'    => 400
                ], 400
            )
        );
    }
}

