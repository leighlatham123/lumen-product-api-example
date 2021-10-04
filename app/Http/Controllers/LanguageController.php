<?php

namespace App\Http\Controllers;

use App\Services;
use Illuminate\Http\Request;
use App\Traits\LanguageTrait;
use App\Traits\ResponseTrait;
use App\Interfaces\CrudInterface;

class LanguageController extends Controller implements CrudInterface
{
    private $_req;
    private $_locale;
    private static $_request;
    private static $_response;
    private static $_language;

    use LanguageTrait, ResponseTrait;

    /**
     * Language Controller Constructor Method
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
        self::$_language    = new Services\LanguageService;

        $this->_locale      = self::$_request->getRequestLocalization($this->_req);
    }

    /**
     * @inheritdoc
     */
    public function create()
    {
        self::$_request->validateRequest($this->_req, $this->getCreateLanguageRules());

        $language_data = array(
            'locale'        => $this->_req['locale'],
            'name'          => $this->_req['name'],
            'date_format'   => $this->_req['date_format'],
            'currency'      => $this->_req['currency'],
        );

        $language = self::$_language->create($language_data);

        return $this->createResponse(self::$_response, $language);
    }

    /**
     * @inheritdoc
     */
    public function read()
    {
        self::$_request->validateRequest($this->_req, $this->getReadLanguageRules());

        $language_data = self::$_language->read(
            $this->getLanguageLocale($this->_req)
        );

        return $this->createResponse(self::$_response, $language_data);
    }

    /**
     * @inheritdoc
     */
    public function update()
    {
        self::$_request->validateRequest($this->_req, $this->getUpdateLanguageRules());

        $language_data = array(
            'locale'        => $this->_req['locale'],
            'name'          => $this->_req['name'],
            'date_format'   => $this->_req['date_format'],
            'currency'      => $this->_req['currency'],
        );

        $language = self::$_language->update($language_data);

        return $this->createResponse(self::$_response, $language);
    }

    /**
     * @inheritdoc
     */
    public function delete()
    {
        self::$_request->validateRequest($this->_req, $this->getDeleteLanguageRules());

        $language_data = array(
            'locale'        => $this->getLanguageLocale($this->_req),
        );

        self::$_language->delete($language_data['locale']);

        return $this->createResponse(self::$_response, ['result' => 'success']);
    }
}
