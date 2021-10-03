<?php

namespace App\Traits;

use App\Services\ResponseService;

trait ResponseTrait
{
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
}
