<?php

namespace App\Services;

class ResponseService
{
    /**
     * Undocumented function
     *
     * @param boolean $validity Valid boolean response validity value
     * @param array   $data     An array of data to be returned in the response
     * @param string  $status   An integer HTTP status code
     *
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function generateJsonResponse(bool $validity, array $data, int $status)
    {
        return response()->json(
            [
                'isvalid'  => $validity,
                'data' => $data,
                'status' => $status
            ], 200
        );
    }
}
