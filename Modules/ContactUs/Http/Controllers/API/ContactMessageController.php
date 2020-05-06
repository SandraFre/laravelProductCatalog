<?php

declare(strict_types=1);

namespace Modules\ContactUs\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ContactUs\Http\Requests\API\ContactMessageRequest;

class ContactMessageController extends Controller
{

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ContactMessageRequest $request): JsonResponse
    {
        //
    }

}
