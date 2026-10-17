<?php

use App\Models\Media;

return [
    'media_model' => Media::class,
    'disk_name' => env('MEDIA_DISK', 'public'),
];
