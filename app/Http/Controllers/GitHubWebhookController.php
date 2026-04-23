<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Log;

class GitHubWebhookController extends Controller
{
    /**
     * Handle the incoming GitHub webhook.
     */
    public function handle(Request $request)
    {
        $payload = $request->all();
        $event = $request->header('X-GitHub-Event', 'unknown');

        Log::info("GitHub Webhook received: {$event}");

        // Prepare data for RabbitMQ
        $data = [
            'source' => 'github_webhook',
            'event' => $event,
            'payload' => $payload,
            'received_at' => now()->toIso8601String(),
        ];

        // Dispatch Job to RabbitMQ
        \App\Jobs\ProcessGitCommit::dispatch($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Event published to RabbitMQ',
            'event_type' => $event
        ]);
    }
}
