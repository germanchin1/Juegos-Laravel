<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\File;

class ProcessGitCommit implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public array $data)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $filePath = base_path('COMMIT_HISTORY.md');

        $content = "### 🚀 Commit Detectado: " . ($this->data['message'] ?? 'Sin mensaje') . "\n";
        $content .= "- **Autor:** " . ($this->data['author'] ?? 'Desconocido') . "\n";
        $content .= "- **Rama:** " . ($this->data['branch'] ?? 'main') . "\n";
        $content .= "- **Hash:** `" . substr($this->data['hash'] ?? '-------', 0, 7) . "`\n";
        $content .= "- **Fecha:** " . now()->format('Y-m-d H:i:s') . "\n";
        $content .= "- **Estado:** ✅ Procesado por el Analista Automático\n\n";

        if (!File::exists($filePath)) {
            File::put($filePath, "# 💾 Historial de Actividad (RabbitMQ)\n\n");
        }

        File::append($filePath, $content);
    }
}
