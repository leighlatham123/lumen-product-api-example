<?php

namespace App\Traits;

trait TranslationTrait
{
    /**
     * Get the product id if present in the provided request
     *
     * @param Request $request Valid request object
     *
     * @return int|null
     */
    protected function getProductId($request): ?int
    {
        return $request->has('product_id') ? $request->get('product_id') : null;
    }

    /**
     * Get the language id if present in the provided request
     *
     * @param Request $request Valid request object
     *
     * @return int|null
     */
    protected function getLanguageId($request): ?int
    {
        return $request->has('language_id') ? $request->get('language_id') : null;
    }

    /**
     * Get the product name tranlsation if present in the provided request
     *
     * @param Request $request Valid request object
     *
     * @return string|null
     */
    protected function getProductName($request): ?string
    {
        return $request->has('product_name_translation') ? $request->get('product_name_translation') : null;
    }

    /**
     * Get the product category tranlsation if present in the provided request
     *
     * @param Request $request Valid request object
     *
     * @return string|null
     */
    protected function getProductCategory($request): ?string
    {
        return $request->has('product_category_translation') ? $request->get('product_category_translation') : null;
    }

    /**
     * Get the product description tranlsation if present in the provided request
     *
     * @param Request $request Valid request object
     *
     * @return string|null
     */
    protected function getProductDescription($request): ?string
    {
        return $request->has('product_desc_translation') ? $request->get('product_desc_translation') : null;
    }

    /**
     * Get the product price tranlsation if present in the provided request
     *
     * @param Request $request Valid request object
     *
     * @return string|null
     */
    protected function getProductPrice($request): ?string
    {
        return $request->has('product_price_translation') ? $request->get('product_price_translation') : null;
    }

    /**
     * Return array of rules used for product translation create
     *
     * @return array
     */
    protected function getCreateProductTranslationRules()
    {
        return array(
            'product_id'                    => 'required|integer',
            'language_id'                   => 'required|integer',
            'product_name_translation'      => 'required|string|max:255',
            'product_desc_translation'      => 'required|string|max:255',
            'product_category_translation'  => 'required|string|max:20',
            'product_price_translation'     => [
                    'required',
                    'regex:/^-?(?:\d+|\d*\.\d+)$/'
                ]
        );
    }

    /**
     * Return array of rules used for product read
     *
     * @return array
     */
    protected function getReadProductTranslationRules()
    {
        return array(
            'product_id'                    => 'required|integer',
            'language_id'                   => 'required|integer',
        );
    }

    /**
     * Return array of rules used for product update
     *
     * @return array
     */
    protected function getUpdateProductTranslationRules()
    {
        return array(
            'product_id'        => [
                'required',
                'integer',
            ],
            'language_id'        => [
                'required',
                'integer',
            ],
            'product_name'      => [
                'sometimes',
                'string',
                'max:255',
            ],
            'product_desc'      => [
                'sometimes',
                'string',
                'max:255',
            ],
            'product_category'  => [
                'sometimes',
                'string',
                'max:20',
            ],
            'product_price'     => [
                'sometimes',
                'regex:/^-?(?:\d+|\d*\.\d+)$/'
            ]
        );
    }

    /**
     * Return array of rules used for product delete
     *
     * @return array
     */
    protected function getDeleteProductTranslationRules()
    {
        return array(
            'product_id'        => [
                'required',
                'integer',
            ],
            'language_id'        => [
                'required',
                'integer',
            ],
        );
    }
}
