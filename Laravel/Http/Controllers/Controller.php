<?php

namespace SimpegClient\Laravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * client
     */
    protected $client;

    /**
     * get list.
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function getList(Request $request)
    {
        return $this->client->getList($request->all(), false);
    }

    /**
     * get detail.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $id
     * @return JsonResponse
     */
    public function getDetail(Request $request, $id)
    {
        return $this->client->getDetail($id, $request->all(), false);
    }
}
