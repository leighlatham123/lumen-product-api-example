<?php

namespace App\Services;

use Exception;
use App\Models\Language;
use Illuminate\Support\Facades\Log;
use App\Exceptions\UnhandledException;
use App\Exceptions\ValueNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LanguageService
{
    private static $_log;
    private $_log_channel;
    private static $_language;

    /**
     * Request Service Constructor Method
     */
    public function __construct()
    {
        self::$_log = new Log;
        self::$_language = new Language;
        $this->_log_channel = 'language';
    }

    /**
     * Get language from Language model using category string value
     *
     * @param string $locale Valid locale string value
     *
     * @return array
     */
    public function getLanguage($locale)
    {
        try
        {
            return self::$_language::whereLocale($locale)->firstOrFail();
        }
        catch(ModelNotFoundException $e)
        {
            self::$_log::channel($this->_log_channel)->error(
                $e->getMessage()
            );

            throw new ValueNotFoundException(__(config('constants.messages.errors.language_not_found')));
        }
        catch(Exception $e)
        {
            self::$_log::channel($this->_log_channel)->error(
                'Unknown exception occurred: ' . $e->getMessage()
            );

            throw new UnhandledException(__(config('constants.messages.errors.unexpected')));
        }
    }
}

