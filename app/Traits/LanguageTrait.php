<?php

namespace App\Traits;

trait LanguageTrait
{
    /**
     * Get the language locale if present in the provided request
     *
     * @param Request $request Valid request object
     *
     * @return string|null
     */
    protected function getLanguageLocale($request): ?string
    {
        return $request->has('product_name_translation') ? $request->get('product_name_translation') : null;
    }

    /**
     * Get the language name if present in the provided request
     *
     * @param Request $request Valid request object
     *
     * @return string|null
     */
    protected function getLanguageName($request): ?string
    {
        return $request->has('product_category_translation') ? $request->get('product_category_translation') : null;
    }

    /**
     * Get the language date format if present in the provided request
     *
     * @param Request $request Valid request object
     *
     * @return string|null
     */
    protected function getLanguageDateFormat($request): ?string
    {
        return $request->has('product_desc_translation') ? $request->get('product_desc_translation') : null;
    }

    /**
     * Get the language currency if present in the provided request
     *
     * @param Request $request Valid request object
     *
     * @return string|null
     */
    protected function getLanguageCurrency($request): ?string
    {
        return $request->has('product_price_translation') ? $request->get('product_price_translation') : null;
    }

    /**
     * Return array of rules used for product translation create
     *
     * @return array
     */
    protected function getCreateLanguageRules()
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
    protected function getReadLanguageRules()
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
    protected function getUpdateLanguageRules()
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
    protected function getDeleteLanguageRules()
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
