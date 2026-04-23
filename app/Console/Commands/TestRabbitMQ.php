<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Queue;

class TestRabbitMQ extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-rabbitmq';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Captures the last Git commit and sends it to RabbitMQ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Reading last commit from Git...');

        // Get real data from Git inside the container
        $author = trim(shell_exec('git log -1 --pretty=format:"%an"') ?? 'Unknown');
        $branch = trim(shell_exec('git rev-parse --abbrev-ref HEAD') ?? 'main');
        $message = trim(shell_exec('git log -1 --pretty=format:"%s"') ?? 'No message');
        $hash = trim(shell_exec('git log -1 --pretty=format:"%H"') ?? '');

        $event = [
            'event' => 'git.commit',
            'repository' => 'Juegos-Laravel',
            'branch' => $branch,
            'author' => $author,
            'message' => $message,
            'hash' => $hash,
            'timestamp' => now()->toIso8601String(),
        ];

        // Publish to RabbitMQ
        Queue::pushRaw(json_encode($event), 'github_events_queue');

        $this->info("🚀 Event sent to RabbitMQ!");
        $this->table(['Field', 'Value'], [
            ['Author', $author],
            ['Branch', $branch],
            ['Message', $message],
            ['Hash', substr($hash, 0, 7)],
        ]);
    }
}
