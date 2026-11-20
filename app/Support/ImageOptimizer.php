<?php

namespace App\Support;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Shrinks uploaded images in place (same path, same format) so the
 * database references stay valid while page weight drops dramatically.
 */
class ImageOptimizer
{
    public const MAX_DIMENSION = 1200;

    public const JPEG_QUALITY = 80;

    public const WEBP_QUALITY = 80;

    /** Files below this size and within MAX_DIMENSION are left alone. */
    public const MIN_BYTES = 200 * 1024;

    /**
     * Optimize a file stored on the "public" disk, e.g. the value returned by ->store(..., 'public').
     */
    public static function optimizePublic(?string $relativePath): ?string
    {
        if ($relativePath) {
            static::optimize(Storage::disk('public')->path($relativePath));
        }

        return $relativePath;
    }

    /**
     * Optimize an image at an absolute path. Returns bytes saved (0 when untouched).
     */
    public static function optimize(string $path): int
    {
        if (! extension_loaded('gd') || ! is_file($path)) {
            return 0;
        }

        try {
            $info = @getimagesize($path);
            if (! $info) {
                return 0;
            }

            [$width, $height, $type] = $info;
            if (! in_array($type, [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP], true)) {
                return 0; // skip GIF (may be animated) and anything else
            }

            $originalSize = filesize($path);
            $needsResize = max($width, $height) > static::MAX_DIMENSION;
            if (! $needsResize && $originalSize < static::MIN_BYTES) {
                return 0;
            }

            // Large photos need headroom while decoding.
            $previousLimit = ini_get('memory_limit');
            @ini_set('memory_limit', '512M');

            $image = match ($type) {
                IMAGETYPE_JPEG => @imagecreatefromjpeg($path),
                IMAGETYPE_PNG => @imagecreatefrompng($path),
                IMAGETYPE_WEBP => @imagecreatefromwebp($path),
            };

            if (! $image) {
                @ini_set('memory_limit', $previousLimit);

                return 0;
            }

            // Re-encoding strips EXIF, so apply phone-camera rotation first.
            if ($type === IMAGETYPE_JPEG) {
                $image = static::applyExifOrientation($image, $path);
                $width = imagesx($image);
                $height = imagesy($image);
            }

            if (max($width, $height) > static::MAX_DIMENSION) {
                $scale = static::MAX_DIMENSION / max($width, $height);
                $newWidth = max(1, (int) round($width * $scale));
                $newHeight = max(1, (int) round($height * $scale));

                $resized = imagecreatetruecolor($newWidth, $newHeight);
                if ($type !== IMAGETYPE_JPEG) {
                    imagealphablending($resized, false);
                    imagesavealpha($resized, true);
                }
                imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                imagedestroy($image);
                $image = $resized;
            } elseif ($type !== IMAGETYPE_JPEG) {
                imagealphablending($image, false);
                imagesavealpha($image, true);
            }

            $tmp = $path.'.opt';
            $ok = match ($type) {
                IMAGETYPE_JPEG => imageinterlace($image, true) !== false && imagejpeg($image, $tmp, static::JPEG_QUALITY),
                IMAGETYPE_PNG => imagepng($image, $tmp, 9),
                IMAGETYPE_WEBP => imagewebp($image, $tmp, static::WEBP_QUALITY),
            };
            imagedestroy($image);
            @ini_set('memory_limit', $previousLimit);

            clearstatcache(true, $tmp);
            if ($ok && is_file($tmp) && filesize($tmp) > 0 && filesize($tmp) < $originalSize) {
                $saved = $originalSize - filesize($tmp);
                rename($tmp, $path);

                return $saved;
            }

            @unlink($tmp);
        } catch (\Throwable $e) {
            Log::warning('Image optimization failed for '.$path.': '.$e->getMessage());
            @unlink($path.'.opt');
        }

        return 0;
    }

    private static function applyExifOrientation($image, string $path)
    {
        if (! function_exists('exif_read_data')) {
            return $image;
        }

        $exif = @exif_read_data($path);
        $orientation = $exif['Orientation'] ?? 1;

        $rotated = match ((int) $orientation) {
            3 => imagerotate($image, 180, 0),
            6 => imagerotate($image, -90, 0),
            8 => imagerotate($image, 90, 0),
            default => null,
        };

        if ($rotated) {
            imagedestroy($image);

            return $rotated;
        }

        return $image;
    }
}
