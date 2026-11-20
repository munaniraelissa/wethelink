<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('images:optimize {--dir= : Only process this folder inside storage/app/public}', function () {
    $root = storage_path('app/public'.($this->option('dir') ? '/'.trim($this->option('dir'), '/') : ''));
    if (! is_dir($root)) {
        $this->error("Directory not found: {$root}");

        return 1;
    }

    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS));
    $count = 0;
    $saved = 0;

    foreach ($files as $file) {
        if (! preg_match('/\.(jpe?g|png|webp)$/i', $file->getFilename())) {
            continue;
        }
        $bytes = \App\Support\ImageOptimizer::optimize($file->getPathname());
        if ($bytes > 0) {
            $count++;
            $saved += $bytes;
            $this->line(sprintf('  %s  -%s KB', str_replace($root, '', $file->getPathname()), number_format($bytes / 1024)));
        }
    }

    $this->info(sprintf('Optimized %d images, saved %s MB.', $count, number_format($saved / 1048576, 1)));
})->purpose('Resize and compress already-uploaded images in place');
