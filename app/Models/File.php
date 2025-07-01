<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;

    protected $table = 'files';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'path',
        'url',
        'size',
        'ext',
        'mime_type',
        'uploaded_by',
        'visibility',
        'download_count',
        'hash',
        'metadata',
    ];

    public function getIconAttribute()
    {
        $icons = [
            'image/jpeg' => 'bx bxs-file-jpg text-danger',
            'image/png' => 'bx bxs-file-png text-success',
            'image/gif' => 'bx bxs-file-gif text-info',
            'application/pdf' => 'bx bxs-file-pdf text-danger',
            'application/msword' => 'bx bxs-file-doc text-info',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'bx bxs-file-doc text-info',
            'application/vnd.ms-excel' => 'bx bx-spreadsheet text-success',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'bx bx-spreadsheet text-success',
            'application/vnd.ms-powerpoint' => 'bx bxs-file text-info',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'bx bxs-file text-info',
            'text/plain' => 'bx bxs-file-txt text-secondary',
            'application/zip' => 'bx bxs-file text-info',
            'application/x-rar-compressed' => 'bx bxs-file text-info',
            'audio/mpeg' => 'bx bxs-music text-success',
            'video/mp4' => 'bx bx-video text-danger',
            'application/octet-stream' => 'bx bx-file text-warning',
        ];

        return $icons[$this->mime_type] ?? 'bx bxs-file text-warning';
    }

    public static function getTotalDiskUsage()
    {
        $total = self::sum('size');
        return $total;
    }

    public function getFormattedSizeAttribute()
    {
        $size = $this->size;
        return self::formatSizeUnits($size);
    }

    private static function formatSizeUnits($size)
    {
        if ($size >= 1073741824) {
            return number_format($size / 1073741824, 2) . ' GB';
        } elseif ($size >= 1048576) {
            return number_format($size / 1048576, 2) . ' MB';
        } elseif ($size >= 1024) {
            return number_format($size / 1024, 2) . ' KB';
        } else {
            return $size . ' B';
        }
    }

    public static function getFileCategories()
    {
        $categories = [
            'Images' => ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/webp', 'image/tiff', 'image/svg+xml'],
            'Videos' => ['video/mp4', 'video/mpeg', 'video/ogg', 'video/webm', 'video/avi', 'video/mov', 'video/mkv', 'video/wmv'],
            'Music' => ['audio/mpeg', 'audio/wav', 'audio/ogg', 'audio/mp4', 'audio/aac', 'audio/flac'],
            'Documents' => [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'text/plain',
                'application/rtf',
                'application/epub+zip'
            ],
            'Archives' => ['application/zip', 'application/x-rar-compressed', 'application/x-7z-compressed', 'application/x-tar', 'application/gzip'],
            'Code' => ['text/html', 'text/css', 'application/javascript', 'application/json', 'application/xml', 'text/x-php', 'text/x-python', 'text/x-c', 'text/x-java'],
            'Others' => [],
        ];

        $data = [];

        foreach ($categories as $category => $mimes) {
            $query = self::query();
            if (!empty($mimes)) {
                $query->whereIn('mime_type', $mimes);
            } else {
                $query->whereNotIn('mime_type', array_merge(...array_values($categories)));
            }

            $totalSize = $query->sum('size');
            $fileCount = $query->count();

            $data[] = [
                'name' => $category,
                'files' => $fileCount,
                'size' => self::formatSizeUnits($totalSize),
                'icon' => self::getCategoryIcon($category),
                'color' => self::getCategoryColor($category),
            ];
        }

        return $data;
    }

    private static function getCategoryIcon($category)
    {
        $icons = [
            'Images' => 'mdi-image',
            'Videos' => 'mdi-play-circle-outline',
            'Music' => 'mdi-music',
            'Documents' => 'mdi-file-document',
            'Archives' => 'mdi-folder-zip',
            'Code' => 'mdi-code-braces',
            'Others' => 'mdi-folder',
        ];
        return $icons[$category] ?? 'mdi-file';
    }

    private static function getCategoryColor($category)
    {
        $colors = [
            'Images' => 'text-success',
            'Videos' => 'text-danger',
            'Music' => 'text-info',
            'Documents' => 'text-primary',
            'Archives' => 'text-warning',
            'Code' => 'text-danger',
            'Others' => 'text-muted',
        ];
        return $colors[$category] ?? 'text-muted';
    }

    public function category()
    {
        return $this->belongsTo(CategoryFile::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function download()
    {
        $this->download_count++;
        $this->save();
    }
}
