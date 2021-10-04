<?php

namespace App\Services;

use Exception;
use App\Models\Language;
use Illuminate\Support\Facades\Log;
use App\Exceptions\UnhandledException;
use App\Exceptions\ModelRemovalException;
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
        self::$_log         = new Log;
        self::$_language    = new Language;
        $this->_log_channel = 'language';
    }

    /**
     * Get language from Language model using category string value
     *
     * @param string $locale Valid locale string value
     *
     * @return array
     */
    public function getLanguage(string $locale): array
    {
        try
        {
            $language = self::$_language::whereLocale($locale)->firstOrFail();
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

        return $language->toArray();
    }

    /**
     * Create language in Languages model
     *
     * @param array $data An array of language data values
     *
     * @return array
     */
    public function create(array $data): array
    {
        try
        {
            return self::$_language::firstOrCreate(
                [
                    'locale'        => $data['locale'],
                ],
                [
                    'name'          => $data['name'],
                    'date_format'   => $data['date_format'],
                    'currency'      => $data['currency'],
                ]
            )->get()->toArray();
        }
        catch(ModelNotFoundException $e)
        {
            self::$_log::channel($this->_log_channel)->error(
                $e->getMessage()
            );

            throw new ValueNotFoundException(__(config('constants.messages.errors.product_not_found')));
        }
        catch(Exception $e)
        {
            self::$_log::channel($this->_log_channel)->error(
                'Unknown exception occurred: ' . $e->getMessage()
            );

            throw new UnhandledException(__(config('constants.messages.errors.unexpected')));
        }
    }

    /**
     * Get language from Languages model by language locale value
     *
     * @param string $locale Valid locale string value
     *
     * @return array
     */
    public function read(string $locale): array
    {
        try
        {
            return self::$_language::whereLocale($locale)
                ->get()
                ->toArray();
        }
        catch(ModelNotFoundException $e)
        {
            self::$_log::channel($this->_log_channel)->error(
                $e->getMessage()
            );

            throw new ValueNotFoundException(__(config('constants.messages.errors.product_not_found')));
        }
        catch(Exception $e)
        {
            self::$_log::channel($this->_log_channel)->error(
                'Unknown exception occurred: ' . $e->getMessage()
            );

            throw new UnhandledException(__(config('constants.messages.errors.unexpected')));
        }
    }

    /**
     * Update language in Languages model
     *
     * @param array $data An array of language data values
     *
     * @return array
     */
    public function update(array $data): array
    {
        $values = array_filter($data);

        try
        {
            $product = self::$_language::whereLocale($data['locale'])
                ->firstOrFail();

            $product->update($values);

            $product->save;

        }
        catch(ModelNotFoundException $e)
        {
            self::$_log::channel($this->_log_channel)->error(
                $e->getMessage()
            );

            throw new ValueNotFoundException(__(config('constants.messages.errors.product_not_found')));
        }
        catch(Exception $e)
        {
            self::$_log::channel($this->_log_channel)->error(
                'Unknown exception occurred: ' . $e->getMessage()
            );

            throw new UnhandledException(__(config('constants.messages.errors.unexpected')));
        }

        return $product->toArray();
    }

    /**
     * Delete language from Languages model using category string value
     *
     * @param string $locale Valid locale string value
     *
     * @return void
     */
    public function delete(string $locale): void
    {
        try
        {
            $removed = self::$_language::whereProductId($locale)
                ->delete();
        }
        catch(ModelNotFoundException $e)
        {
            self::$_log::channel($this->_log_channel)->error(
                $e->getMessage()
            );

            throw new ValueNotFoundException(__(config('constants.messages.errors.product_not_found')));
        }
        catch(Exception $e)
        {
            self::$_log::channel($this->_log_channel)->error(
                'Unknown exception occurred: ' . $e->getMessage()
            );

            throw new UnhandledException(__(config('constants.messages.errors.unexpected')));
        }

        if (empty($removed)) {
            throw new ModelRemovalException(__(config('constants.messages.errors.product_not_removed')));
        }
    }
}

