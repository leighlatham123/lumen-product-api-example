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
     * Create product translation in Translation model by language id and product id int values
     *
     * @param array $data An array of product translation data values
     *
     * @return array
     */
    public function create(array $data): array
    {
        try
        {
            return self::$_language::firstOrCreate(
                [
                    'product_id'                    => $data['product_id'],
                    'language_id'                   => $data['language_id'],
                ],
                [
                    'product_name_translation'      => $data['product_name'],
                    'product_desc_translation'      => $data['product_desc'],
                    'product_category_translation'  => $data['product_category'],
                    'product_price_translation'     => $data['product_price'],
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
     * Get product(s) translation(s) from Translation model by language id and product id int values
     *
     * @param int $product_id  Valid product id integer value
     * @param int $language_id Valid language id integer value
     *
     * @return array
     */
    public function read(int $product_id, int $language_id): array
    {
        try
        {
            return self::$_language::whereProductId($product_id)
                ->whereLanguageId($language_id)
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
     * Update product translation in Traslation model by language id and product id int values
     *
     * @param int   $product_id  Valid product id integer value
     * @param int   $language_id Valid language id integer value
     * @param array $data        An array of product data values
     *
     * @return array
     */
    public function update(int $product_id, int $language_id, array $data): array
    {
        $values = array_filter($data);

        try
        {
            $product = self::$_language::whereProductId($product_id)
                ->whereLanguageId($language_id)
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
     * Delete product translation from Translation model by language id and product id int values
     *
     * @param int $product_id  Valid product id integer value
     * @param int $language_id Valid language id integer value
     *
     * @return void
     */
    public function delete(int $product_id, int $language_id): void
    {
        try
        {
            $removed = self::$_language::whereProductId($product_id)
                ->whereLanguageId($language_id)
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

