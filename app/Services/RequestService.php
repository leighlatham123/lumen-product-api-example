<?php

namespace App\Services;

use Laravel\Lumen\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidationFailedException;

class RequestService
{
    private static $_validator;

    /**
     * Request Service Constructor Method
     */
    public function __construct()
    {
        self::$_validator = new Validator;
    }

    /**
     * Return valid loclization string value from given request header or config
     *
     * @param Request $request Valid request object value
     *
     * @return string
     */
    public static function getRequestLocalization(Request $request): string
    {
        $lang = $request->header('Content-Language') ?? config('app.locale');

        if (!array_key_exists($lang, config('constants.supported_languages'))) {
            app()->setLocale("en");

            throw new ValidationFailedException(__(config('constants.messages.errors.unsupported_language')));
        }

        app()->setLocale($lang);

        return $lang;
    }

    /**
     * Run a DELETE API request through given ruleset
     *
     * @param Request $request Valid instance of HTTP Request
     * @param array   $rules   An array of rules
     *
     * @return void
     */
    public function validateRequest(Request $request, array $rules): void
    {
        $validation = self::$_validator::make(
            $request->all(),
            $rules
        );

        $this->_checkValidation($validation);

        return;
    }

    /**
     * Check the validation has failed or passed the given ruleset
     *
     * @param Illuminate\Support\Facades\Validator $validated Instance of Validator
     *
     * @return void
     */
    private function _checkValidation($validated): void
    {
        if ($validated->fails()) {
            throw new ValidationFailedException($validated->errors()->first());
        }

        return;
    }
}
