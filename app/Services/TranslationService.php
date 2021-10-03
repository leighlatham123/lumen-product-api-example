<?php

namespace App\Services;

use App\Models\Translation;

class TranslationService
{
    private static $_translation;
    private static $_language_service;

    /**
     * Request Service Constructor Method
     */
    public function __construct()
    {
        self::$_translation         = new Translation;
        self::$_language_service    = new LanguageService;
    }

    /**
     * Translate the values of a given array by a specified locale
     *
     * @param array  $product_ids Array of product IDs of which to translate
     * @param string $locale      Valid locale string value
     *
     * @return array
     */
    public function translateProducts(array $product_ids, string $locale): array
    {
        $this->_language = self::$_language_service->getLanguage($locale);

        return self::$_translation::whereIn('product_id', $product_ids)
            ->whereLanguageId($this->_language->id)
            ->get()
            ->toArray();
    }
}

