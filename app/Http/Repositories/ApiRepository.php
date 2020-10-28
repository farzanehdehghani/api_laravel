<?php


namespace App\Http\Repositories;


use App\Helpers\BaseAnswer;
use Illuminate\Http\Request;

class ApiRepository
{

    private $request;

    /**
     * @param Request $request
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }
    /**
     * @return BaseAnswer
     */
    function baseAnswer()
    {
        return BaseAnswer::getInstance();
    }

}
