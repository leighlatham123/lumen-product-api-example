<?php

namespace App\Services;

use Exception;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use App\Exceptions\UnhandledException;
use App\Exceptions\ModelRemovalException;
use App\Exceptions\ValueNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductService
{
    private static $_log;
    private $_log_channel;
    private static $_product;

    /**
     * Product Service Constructor Method
     */
    public function __construct()
    {
        self::$_log         = new Log;
        self::$_product     = new Product;
        $this->_log_channel = 'product';
    }

    /**
     * Create product in Product model by category string value
     *
     * @param string $category Valid category string value
     * @param array  $data     An array of product data values
     *
     * @return array
     */
    public function create(string $category, array $data): array
    {
        try
        {
            return self::$_product::firstOrCreate(
                [
                    'product_name'      => $data['product_name'],
                    'product_category'  => $category,
                ],
                [
                    'product_desc'      => $data['product_desc'],
                    'product_price'     => $data['product_price']
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
     * Get product(s) from Product model using category string value
     *
     * @param string      $category Valid category string value
     * @param string|null $name     Valid name string value or null
     *
     * @return array
     */
    public function read(string $category, string $name = null): array
    {
        try
        {
            return self::$_product::whereProductCategory($category)
                ->when(
                    $name, function ($query) use ($name) {
                        return $query->whereProductName($name);
                    }
                )
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
     * Update product in Product model by category string value
     *
     * @param string $category Valid category string value
     * @param array  $data     Array of product data values
     *
     * @return array
     */
    public function update(string $category, array $data): array
    {
        $values = array_filter($data);

        try
        {
            $product = self::$_product::whereProductCategory($category)
                ->when(
                    $data['product_name'], function ($query) use ($data) {
                        return $query->whereProductName($data['product_name']);
                    }
                )
                ->when(
                    $data['id'], function ($query) use ($data) {
                        return $query->whereId($data['id']);
                    }
                )->firstOrFail();

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
     * Delete product from Product model using category string value
     *
     * @param string $category Valid category string value
     * @param array  $data     Array of product data values
     *
     * @return void
     */
    public function delete(string $category, array $data): void
    {
        try
        {
            $removed = self::$_product::whereProductCategory($category)
                ->when(
                    $data['product_name'], function ($query) use ($data) {
                        return $query->whereProductName($data['product_name']);
                    }
                )
                ->when(
                    $data['id'], function ($query) use ($data) {
                        return $query->whereId($data['id']);
                    }
                )->delete();
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
