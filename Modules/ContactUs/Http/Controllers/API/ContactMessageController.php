<?php

declare(strict_types=1);

namespace Modules\ContactUs\Http\Controllers\API;

use App\Http\Responses\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Modules\ContactUs\Emails\NewMessageMail;
use Modules\ContactUs\Http\Requests\API\ContactMessageRequest;
use Modules\ContactUs\Jobs\NewMessageJob;
use Modules\ContactUs\Services\ContactMessageService;

class ContactMessageController extends Controller
{

    private $messageService;

    public function __construct(ContactMessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ContactMessageRequest $request): JsonResponse
    {
        $start = microtime(true);

        try {
            $message = $this->messageService->storeData($request->getData());
        } catch (Exception $exception) {
            return (new ApiResponse())->exception();
        }

        NewMessageJob::dispatch($message)->onQueue('mail');

        $finish = microtime(true) - $start;

        return (new ApiResponse())->success();
    }
}
