<?php

namespace App\Http\Controllers;

use App\Services;
use App\Traits\ProductTrait;
use Illuminate\Http\Request;
use App\Interfaces\CrudInterface;

class ProductController extends Controller implements CrudInterface
{
    private $_req;
    private $_locale;
    private $_category;
    private static $_product;
    private static $_request;
    private static $_response;
    private static $_translate;

    use ProductTrait;

    /**
     * Product Controller Constructor Method
     *
     * @param Request $request Valid instance of request values
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->_req = $request;
        $this->category = $request['product_category'];
        self::$_product = new Services\ProductService;
        self::$_request = new Services\RequestService;
        self::$_response = new Services\ResponseService;
        self::$_translate = new Services\TranslationService;

        $this->_locale = self::$_request->getRequestLocalization($this->_req);
    }

    /**
     * Create a product model
     *
     * @return mixed
     */
    public function create()
    {
        self::$_request->validateRequest($this->_req, $this->getCreateProductRules());

        $product_data = array(
            'product_name'  => $this->_req['product_name'],
            'product_desc'  => $this->_req['product_desc'],
            'product_price' => $this->_req['product_price'],
        );

        $product = self::$_product->create(
            $this->category,
            $product_data
        );

        return $this->createResponse(self::$_response, $product);
    }

    /**
     * Read a product model
     *
     * @return mixed
     */
    public function read()
    {
        self::$_request->validateRequest($this->_req, $this->getReadProductRules());

        $products = self::$_product->read(
            $this->category,
            $this->getProductName($this->_req)
        );

        if ($this->requiresTranslation($this->_locale)) {
            $products = self::$_translate->translateProducts(
                $this->getProductIds($products), $this->_locale
            );
        }

        return $this->createResponse(self::$_response, $products);
    }

    /**
     * Update a product model
     *
     * @return void
     */
    public function update()
    {
        self::$_request->validateRequest($this->_req, $this->getUpdateProductRules());

        $product_data = array(
            'id'            => $this->getProductId($this->_req),
            'product_name'  => $this->getProductName($this->_req),
            'product_desc'  => $this->getProdctDescription($this->_req),
            'product_price' => $this->getProdctPrice($this->_req),
        );

        $product = self::$_product->update(
            $this->category,
            $product_data
        );

        return $this->createResponse(self::$_response, $product);
    }

    /**
     * Delete a product model
     *
     * @return void
     */
    public function delete()
    {
        self::$_request->validateRequest($this->_req, $this->getDeleteProductRules());

        $product_data = array(
            'id'            => $this->getProductId($this->_req),
            'product_name'  => $this->getProductName($this->_req),
        );

        self::$_product->delete(
            $this->category,
            $product_data
        );

        return $this->createResponse(self::$_response, ['result' => 'success']);
    }
}
