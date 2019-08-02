<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Jobs\ReportIncident;

class WebhookController extends Controller
{
    public function inboundMessage(Request $request)
    {
        return Log::debug('Inbound Message', $request->all());
    }

    public function status(Request $request)
    {
        return Log::debug('Status', $request->all());
    }

    public function report(Request $request)
    {
        //Log::debug('Incident', $request->all());

        dispatch(new ReportIncident());

        return response('Webhook received');
    }
}
