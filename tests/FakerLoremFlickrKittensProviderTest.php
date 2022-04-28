<?php

namespace Hatchet\FakerLoremFlickrKittens\Tests;

use PHPUnit\Framework\TestCase;
use Hatchet\FakerLoremFlickrKittens\FakerLoremFlickrKittensProvider;

class FakerLoremFlickrKittensProviderTest extends TestCase
{
    public function testImageUrlUses640x680AsTheDefaultSize()
    {
        $this->assertMatchesRegularExpression('#^https://loremflickr.com/640/480/kitten#', FakerLoremFlickrKittensProvider::imageUrl());
    }

    public function testImageUrlAcceptsCustomWidthAndHeight()
    {
        $this->assertMatchesRegularExpression('#^https://loremflickr.com/800/400/kitten#', FakerLoremFlickrKittensProvider::imageUrl(800, 400));
    }

    public function testImageUrlGray()
    {
        $this->assertMatchesRegularExpression('#^https://loremflickr\.com/g/800/400/kitten#', FakerLoremFlickrKittensProvider::imageUrl(800, 400, true));
    }

    public function testImageDownloadWithDefaults()
    {
        $file = FakerLoremFlickrKittensProvider::image(sys_get_temp_dir());
        $this->assertFileExists($file);
        if (function_exists('getimagesize')) {
            list($width, $height, $type) = getimagesize($file);
            $this->assertEquals(640, $width);
            $this->assertEquals(480, $height);
            $this->assertEquals(constant('IMAGETYPE_JPEG'), $type);
        } else {
            $this->assertEquals('jpg', pathinfo($file, PATHINFO_EXTENSION));
        }
        if (file_exists($file)) {
            unlink($file);
        }
    }
}
