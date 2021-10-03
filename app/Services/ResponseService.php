<?php

namespace App\Services;

class ResponseService
{
    /**
     * Create a JSON response
     *
     * @param boolean $validity Valid boolean response validity value
     * @param array   $data     An array of data to be returned in the response
     * @param string  $status   An integer HTTP status code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateJsonResponse(bool $validity, array $data, int $status = 200)
    {
        return response()->json(
            [
                'isvalid'   => $validity,
                'data'      => $data,
                'status'    => $status
            ], $status
        );
    }
}
