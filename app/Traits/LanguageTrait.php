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
        return $request->has('locale') ? $request->get('locale') : null;
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
        return $request->has('name') ? $request->get('name') : null;
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
        return $request->has('date_format') ? $request->get('date_format') : null;
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
        return $request->has('currency') ? $request->get('currency') : null;
    }

    /**
     * Return array of rules used for product translation create
     *
     * @return array
     */
    protected function getCreateLanguageRules()
    {
        return array(
            'locale'        => 'required|string|max:10',
            'name'          => 'required|string|max:255',
            'date_format'   => 'required|string|max:255',
            'currency'      => 'required|string|max:10',
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
            'locale'      => 'required|string|max:10',
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
            'locale'        => 'required|string|max:10',
            'name'          => 'sometimes|string|max:255',
            'date_format'   => 'sometimes|string|max:255',
            'currency'      => 'sometimes|string|max:10',
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
            'locale'        => 'required|string|max:10',
        );
    }
}
