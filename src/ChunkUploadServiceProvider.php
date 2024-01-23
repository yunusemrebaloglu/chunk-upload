<?php

namespace YunusEmreBaloglu\ChunkUpload;

use Illuminate\Support\ServiceProvider;
use YunusEmreBaloglu\ChunkUpload\Commands\ChunkUploadDeleteOtherFiles;

class ChunkUploadServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        // Register the package's console commands.
        $this->commands([
            ChunkUploadDeleteOtherFiles::class,
        ]);

        // Publish configuration file.
        $this->publishes([
            __DIR__ . '/../config/chunk-upload.php' => config_path('chunk-upload.php'),
        ], 'chunk-upload-config');

        $this->publishes([
            __DIR__ . '/Components' => resource_path('js/Components'),
        ], 'chunk-upload-inertia-components');

        // Load package routes.

        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Register package services if needed.
    }
}
