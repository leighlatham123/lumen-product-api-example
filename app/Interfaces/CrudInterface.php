<?php

namespace App\Interfaces;

interface CrudInterface
{
    /**
     * Create record
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create();

    /**
     * Read record
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function read();

    /**
     * Update record
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update();

    /**
     * Delete record
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete();
}
