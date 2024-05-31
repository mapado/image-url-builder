<?php

declare(strict_types=1);

namespace Mapado\ImageUrlBuilder\Tests\Units;

use PHPUnit\Framework\TestCase;
use Mapado\ImageUrlBuilder\Builder;

/**
 * @covers Builder
 */
class BuilderTest extends TestCase
{
    private $manager;

    public function setUp(): void
    {
        $this->manager = new Builder();
    }

    public function testNonChangingUrl(): void
    {
        $baseUrl = '//img.mapado.net/2014/1/1/my-image.png';
        $url = $this->manager->buildUrl($baseUrl);
        $this->assertSame($baseUrl, $url);

        $baseUrl = '//img.mapado.net/2014/1/1/my-image.png';
        $url = $this->manager->buildUrl($baseUrl);
        $this->assertSame($baseUrl, $url);

        $baseUrl = '//img.mapado.net/2014/1/1/my-image.png';
        $url = $this->manager->buildUrl($baseUrl);
        $this->assertSame($baseUrl, $url);
    }


    public function testThumbs()
    {
        $baseUrl = '//img.mapado.net/2014/1/1/my-image';
        $url = $this->manager->buildUrl($baseUrl, 200);
        $this->assertSame($baseUrl . '_thumbs/200-0', $url);

        $baseUrl = '//img.mapado.net/2014/1/1/my-image';
        $url = $this->manager->buildUrl($baseUrl, 0, 200);
        $this->assertSame($baseUrl . '_thumbs/0-200', $url);

        $baseUrl = '//img.mapado.net/2014/1/1/my-image.png';
        $url = $this->manager->buildUrl($baseUrl, 200);
        $this->assertSame($baseUrl . '_thumbs/200-0.png', $url);

        $baseUrl = '//img.mapado.net/2014/1/1/my-image.png';
        $url = $this->manager->buildUrl($baseUrl, 200, 150);
        $this->assertSame($baseUrl . '_thumbs/200-150.png', $url);

        $baseUrl = '//img.mapado.net/2014/1/1/my-image.png';
        $url = $this->manager->buildUrl($baseUrl, 200, 150, ['cropWidth' => 500]);
        $this->assertSame($baseUrl . '_thumbs/200-150-500-0.png', $url);

        $baseUrl = '//img.mapado.net/2014/1/1/my-image.png';
        $url = $this->manager->buildUrl($baseUrl, 200, 150, ['cropWidth' => 500, 'cropHeight' => 300]);
        $this->assertSame($baseUrl . '_thumbs/200-150-500-300.png', $url);

        // other options
        $baseUrl = '//img.mapado.net/2014/1/1/my-image.png';
        $url = $this->manager->buildUrl($baseUrl, 200, 150, ['rcr' => 1.5]);
        $this->assertSame($baseUrl . '_thumbs/200-150.rcr=1.5.png', $url);

        $baseUrl = '//img.mapado.net/2014/1/1/my-image.png';
        $url = $this->manager->buildUrl($baseUrl, 200, 150, ['iid' => '200-100']);
        $this->assertSame($baseUrl . '_thumbs/200-150.iid=200-100.png', $url);

        $baseUrl = '//img.mapado.net/2014/1/1/my-image.png';
        $url = $this->manager->buildUrl($baseUrl, 200, 150, ['rcr' => 1.5, 'iid' => '200-100']);
        $this->assertSame($baseUrl . '_thumbs/200-150.iid=200-100;rcr=1.5.png', $url);
    }

    public function testWithHttpPrefix()
    {
        $baseUrl = '//img.mapado.net/2014/1/1/my-image.png';
        $httpUrl = 'http:' . $baseUrl;
        $httpsUrl = 'https:' . $baseUrl;
        $expected = $baseUrl . '_thumbs/200-150.png';

        $this->assertSame($expected, $this->manager->buildUrl($httpUrl, 200, 150));
        $this->assertSame($expected, $this->manager->buildUrl($httpsUrl, 200, 150));
    }

    public function testNoDomain()
    {
        $baseUrl = '2014/1/1/my-image.png';
        $url = $this->manager->buildUrl($baseUrl);
        $this->assertSame('//img.mapado.net/' . $baseUrl, $url);

        $baseUrl = '2014/1/2/my-image.png';
        $url = $this->manager->buildUrl($baseUrl);
        $this->assertSame('//img.mapado.net/' . $baseUrl, $url);
    }

    public function testBuildHttpUrl()
    {
        $baseUrl = '2014/1/1/my-image.png';
        $url = $this->manager
            ->withHttpPrefix()
            ->buildUrl($baseUrl);

        $this->assertSame('http://img.mapado.net/' . $baseUrl, $url);
    }

    public function testBuildHttpsUrl()
    {
        $baseUrl = '2014/1/1/my-image.png';
        $url = $this->manager
            ->withHttpsPrefix()
            ->buildUrl($baseUrl);

        $this->assertSame('https://img.mapado.net/' . $baseUrl, $url);
    }

    public function testBuildHttpDoesNotInterferWithInstance()
    {
        $baseUrl = '2014/1/1/my-image.png';
        $this->manager->withHttpPrefix();

        $this->assertSame('//img.mapado.net/' . $baseUrl, $this->manager->buildUrl($baseUrl));
    }

    public function testAllowwebp(): void
    {
        $baseUrl = '//img.mapado.net/2014/1/1/my-image.png';
        $url = $this->manager->buildUrl($baseUrl, null, null);
        $this->assertSame($baseUrl, $url);

        $baseUrl = '//img.mapado.net/2014/1/1/my-image.png';
        $url = $this->manager->buildUrl($baseUrl, null, null, ['allowwebp' => 1]);
        $this->assertSame($baseUrl . '_thumbs/0-0.png', $url);
    }
}
