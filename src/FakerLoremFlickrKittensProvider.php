<?php

namespace Hatchet\FakerLoremFlickrKittens;

use Faker\Provider\Base as BaseProvider;

class FakerLoremFlickrKittensProvider extends BaseProvider
{
    protected static string $baseUrl = "https://loremflickr.com/";

    public static function imageUrl(
        int $width = 640,
        int $height = 480,
        bool $gray = false
    ): string {
        $urlPrefix = self::buildUrlPrefix($gray) . "{$width}/{$height}";

        return self::buildLoremFlickrUrl($urlPrefix);
    }

    /**
     * Download a remote image from the LoremFlickr api to disk and return its filename/path
     *
     * Requires curl, or allow_url_fopen to be on in php.ini.
     *
     * @example '/path/to/dir/13b73edae8443990be1aa8f1a483bc27.jpg'
     */
    public static function image(
        string $dir = null,
        int $width = 640,
        int $height = 480,
        bool $isFullPath = true,
        bool $gray = false
    ): bool|\RuntimeException|string {
        $url = static::imageUrl($width, $height, $gray);

        return self::fetchImage($url, $dir, $isFullPath);
    }

    private static function fetchImage(
        string $url,
        ?string $dir,
        bool $isFullPath
    ): bool|\RuntimeException|string {
        $dir = $dir === null ? sys_get_temp_dir() : $dir; // GNU/Linux / OS X / Windows compatible
        // Validate directory path
        if (! is_dir($dir) || ! is_writable($dir)) {
            throw new \InvalidArgumentException(sprintf('Cannot write to directory "%s"', $dir));
        }

        // Generate a random filename. Use the server address so that a file
        // generated at the same time on a different server won't have a collision.
        $name = md5(uniqid(empty($_SERVER['SERVER_ADDR']) ? '' : $_SERVER['SERVER_ADDR'], true));
        $filename = $name . ".jpg";
        $filepath = $dir . DIRECTORY_SEPARATOR . $filename;

        // save file
        if (function_exists('curl_exec')) {
            // use cURL
            $fp = fopen($filepath, 'w');
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            $success = curl_exec($ch) && curl_getinfo($ch, CURLINFO_HTTP_CODE) === 200;
            fclose($fp);
            curl_close($ch);

            if (! $success) {
                unlink($filepath);

                // could not contact the distant URL or HTTP error - fail silently.
                return false;
            }
        } elseif (ini_get('allow_url_fopen')) {
            // use remote fopen() via copy()
            $success = copy($url, $filepath);
            if (! $success) {
                // could not contact the distant URL or HTTP error - fail silently.
                return false;
            }
        } else {
            return new \RuntimeException('The image formatter downloads an image from a remote HTTP server. Therefore, it requires that PHP can request remote hosts, either via cURL or fopen()');
        }

        return $isFullPath ? $filepath : $filename;
    }

    private static function buildUrlPrefix(?bool $gray): string
    {
        $urlPrefix = '';

        if ($gray) {
            $urlPrefix .= 'g/';
        }

        return $urlPrefix;
    }

    private static function buildLoremFlickrUrl($urlPrefix)
    {
        return self::$baseUrl . $urlPrefix . "/kitten";
    }
}
