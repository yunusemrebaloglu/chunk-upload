<?php

return [
    'url' => env('CHUNK_UPLOAD_URL', '/yunusemrebaloglu/chunk-upload'),
    'url_delete_file' => env('CHUNK_UPLOAD_DELETE_FILE_URL', '/yunusemrebaloglu/chunk-upload/delete/file'),
    'disk' => env('CHUNK_UPLOAD_DISK', 'public'),
    'delete_minute' => env('DELETE_MINUTE', 30),
];
