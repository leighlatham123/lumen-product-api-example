<?php

namespace App\Traits;

use App\Services\ResponseService;

trait ProductTrait
{
    /**
     * Get the product_id values from a given array of products data
     *
     * @param array $products An array of products data
     *
     * @return array $product_ids
     */
    protected function getProductIds(array $products): array
    {
        $product_ids = array();

        foreach ($products as $product) {
            array_push($product_ids, $product['id']);
        }

        return $product_ids;
    }

    /**
     * Get the product id if present in the provided request
     *
     * @param Request $request Valid request object
     *
     * @return string|null
     */
    protected function getProductId($request): ?int
    {
        return $request->has('id') ? $request->get('id') : null;
    }

    /**
     * Get the product name if present in the provided request
     *
     * @param Request $request Valid request object
     *
     * @return string|null
     */
    protected function getProductName($request): ?string
    {
        return $request->has('product_name') ? $request->get('product_name') : null;
    }

    /**
     * Get the product description if present in the provided request
     *
     * @param Request $request Valid request object
     *
     * @return string|null
     */
    protected function getProductDescription($request): ?string
    {
        return $request->has('product_desc') ? $request->get('product_desc') : null;
    }

    /**
     * Get the product price if present in the provided request
     *
     * @param Request $request Valid request object
     *
     * @return string|null
     */
    protected function getProductPrice($request): ?string
    {
        return $request->has('product_price') ? $request->get('product_price') : null;
    }

    /**
     * Return true if the locale provided is not 'en' - false if 'en'
     *
     * @param string $locale Valid locale string type
     *
     * @return boolean
     */
    protected function requiresTranslation(string $locale): bool
    {
        return $locale === "en" ? false : true;
    }

    /**
     * Return a JSON response 200 containing product data if valid
     * Return a JSON response 404 if no matching products were found
     *
     * @param ResponseService $response Valid repsonse service instance
     * @param array           $products An array of products data values
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createResponse(ResponseService $response, array $products)
    {
        if (empty($products)) {
            return $response->generateJsonResponse(
                false,
                array('message' => __(config('constants.messages.errors.product_not_found'))), 404
            );
        }

        return $response->generateJsonResponse(true, $products, 200);
    }

    /**
     * Return array of rules used for product create
     *
     * @return array
     */
    protected function getCreateProductRules()
    {
        return array(
            'product_name'      => 'required|string|max:255',
            'product_desc'      => 'required|string|max:255',
            'product_category'  => 'required|string|max:20',
            'product_price'     => [
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
    protected function getReadProductRules()
    {
        return array(
            'product_name'      => 'sometimes|string|max:255',
            'product_category'  => 'required|string|max:20',
        );
    }

    /**
     * Return array of rules used for product update
     *
     * @return array
     */
    protected function getUpdateProductRules()
    {
        return array(
            'id'                => [
                'required_without:product_name',
                'integer',
            ],
            'product_name'      => [
                'required_without:id',
                'string',
                'max:255',
            ],
            'product_desc'      => [
                'sometimes',
                'string',
                'max:255',
            ],
            'product_category'  => [
                'required',
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
    protected function getDeleteProductRules()
    {
        return array(
            'id'      => [
                'required_without_all:product_name',
                'integer',
            ],
            'product_name'      => [
                'required_without_all:id',
                'string',
                'max:255',
            ],
            'product_category'  => [
                'required',
                'string',
                'max:20',
            ],
        );
    }
}
