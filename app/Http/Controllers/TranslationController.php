<?php

namespace App\Http\Controllers;

use App\Services;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Traits\TranslationTrait;
use App\Interfaces\CrudInterface;

class TranslationController extends Controller implements CrudInterface
{
    private $_req;
    private $_locale;
    private static $_request;
    private static $_response;
    private static $_translation;

    use TranslationTrait, ResponseTrait;

    /**
     * Product Controller Constructor Method
     *
     * @param Request $request Valid instance of request values
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->_req         = $request;
        self::$_request     = new Services\RequestService;
        self::$_response    = new Services\ResponseService;
        self::$_translation     = new Services\TranslationService;

        $this->_locale      = self::$_request->getRequestLocalization($this->_req);
    }

    /**
     * @inheritdoc
     */
    public function create()
    {
        self::$_request->validateRequest($this->_req, $this->getCreateProductTranslationRules());

        $product_data = array(
            'product_id'        => $this->_req['product_id'],
            'language_id'       => $this->_req['language_id'],
            'product_name'      => $this->_req['product_name_translation'],
            'product_category'  => $this->_req['product_category_translation'],
            'product_desc'      => $this->_req['product_desc_translation'],
            'product_price'     => $this->_req['product_price_translation'],
        );

        $product_translation = self::$_translation->create($product_data);

        return $this->createResponse(self::$_response, $product_translation);
    }

    /**
     * @inheritdoc
     */
    public function read()
    {
        self::$_request->validateRequest($this->_req, $this->getReadProductTranslationRules());

        $products = self::$_translation->read(
            $this->getProductId($this->_req),
            $this->getLanguageId($this->_req)
        );
        return $this->createResponse(self::$_response, $products);
    }

    /**
     * @inheritdoc
     */
    public function update()
    {
        self::$_request->validateRequest($this->_req, $this->getUpdateProductTranslationRules());

        $product_data = array(
            'product_id'                    => $this->getProductId($this->_req),
            'language_id'                   => $this->getLanguageId($this->_req),
            'product_name_translation'      => $this->getProductName($this->_req),
            'product_desc_translation'      => $this->getProductDescription($this->_req),
            'product_category_translation'  => $this->getProductCategory($this->_req),
            'product_price_translation'     => $this->getProductPrice($this->_req),
        );

        $product = self::$_translation->update(
            $product_data['product_id'],
            $product_data['language_id'],
            $product_data
        );

        return $this->createResponse(self::$_response, $product);
    }

    /**
     * @inheritdoc
     */
    public function delete()
    {
        self::$_request->validateRequest($this->_req, $this->getDeleteProductTranslationRules());

        $product_data = array(
            'product_id'    => $this->getProductId($this->_req),
            'language_id'   => $this->getLanguageId($this->_req),
        );

        self::$_translation->delete(
            $product_data['product_id'],
            $product_data['language_id'],
        );

        return $this->createResponse(self::$_response, ['result' => 'success']);
    }
}
