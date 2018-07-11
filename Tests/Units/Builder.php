<?php

namespace Mapado\ImageUrlBuilder\Tests\Unit;

use atoum;
use Mapado\ImageUrlBuilder\Builder as BaseBuilder;

class Builder extends atoum
{
    private $manager;

    public function beforeTestMethod($method)
    {
        $this->manager = new BaseBuilder();
    }

    /**
     * testNonChangingUrl
     *
     * @access public
     * @return void
     */
    public function testNonChangingUrl()
    {
        $baseUrl = '//img.mapado.net/2014/1/1/my-image.png';
        $url = $this->manager->buildUrl($baseUrl);
        $this->string($url)
            ->isEqualTo($baseUrl);

        $baseUrl = '//img1.mapado.net/2014/1/1/my-image.png';
        $url = $this->manager->buildUrl($baseUrl);
        $this->string($url)
            ->isEqualTo($baseUrl);

        $baseUrl = '//img2.mapado.net/2014/1/1/my-image.png';
        $url = $this->manager->buildUrl($baseUrl);
        $this->string($url)
            ->isEqualTo($baseUrl);
    }

    /**
     * testThumbs
     *
     * @access public
     * @return void
     */
    public function testThumbs()
    {
        $baseUrl = '//img.mapado.net/2014/1/1/my-image';
        $url = $this->manager->buildUrl($baseUrl, 200);
        $this->string($url)
            ->isEqualTo($baseUrl . '_thumbs/200');

        $baseUrl = '//img.mapado.net/2014/1/1/my-image.png';
        $url = $this->manager->buildUrl($baseUrl, 200);
        $this->string($url)
            ->isEqualTo($baseUrl . '_thumbs/200.png');

        $baseUrl = '//img.mapado.net/2014/1/1/my-image.png';
        $url = $this->manager->buildUrl($baseUrl, 200, 150);
        $this->string($url)
            ->isEqualTo($baseUrl . '_thumbs/200-150.png');

        $baseUrl = '//img.mapado.net/2014/1/1/my-image.png';
        $url = $this->manager->buildUrl($baseUrl, 200, 150, ['cropWidth' => 500]);
        $this->string($url)
            ->isEqualTo($baseUrl . '_thumbs/200-150-500-0.png');

        $baseUrl = '//img.mapado.net/2014/1/1/my-image.png';
        $url = $this->manager->buildUrl($baseUrl, 200, 150, ['cropWidth' => 500, 'cropHeight' => 300]);
        $this->string($url)
            ->isEqualTo($baseUrl . '_thumbs/200-150-500-300.png');

        // other options
        $baseUrl = '//img.mapado.net/2014/1/1/my-image.png';
        $url = $this->manager->buildUrl($baseUrl, 200, 150, ['rcr' => 1.5]);
        $this->string($url)
            ->isEqualTo($baseUrl . '_thumbs/200-150.rcr=1.5.png');

        $baseUrl = '//img.mapado.net/2014/1/1/my-image.png';
        $url = $this->manager->buildUrl($baseUrl, 200, 150, ['iid' => '200-100']);
        $this->string($url)
            ->isEqualTo($baseUrl . '_thumbs/200-150.iid=200-100.png');

        $baseUrl = '//img.mapado.net/2014/1/1/my-image.png';
        $url = $this->manager->buildUrl($baseUrl, 200, 150, ['rcr' => 1.5, 'iid' => '200-100']);
        $this->string($url)
            ->isEqualTo($baseUrl . '_thumbs/200-150.iid=200-100;rcr=1.5.png');
    }

    /**
     * testNoDomain
     *
     * @access public
     * @return void
     */
    public function testNoDomain()
    {
        $baseUrl = '2014/1/1/my-image.png';
        $url = $this->manager->buildUrl($baseUrl);
        $this->string($url)
            ->isEqualTo('//img1.mapado.net/' . $baseUrl);

        $baseUrl = '2014/1/2/my-image.png';
        $url = $this->manager->buildUrl($baseUrl);
        $this->string($url)
            ->isEqualTo('//img.mapado.net/' . $baseUrl);
    }

    public function testBuildHttpUrl()
    {
        $baseUrl = '2014/1/1/my-image.png';
        $url = $this->manager
            ->withHttpPrefix()
            ->buildUrl($baseUrl);

        $this->string($url)
            ->isEqualTo('http://img1.mapado.net/' . $baseUrl);
    }

    public function testBuildHttpDoesNotInterferWithInstance()
    {
        $baseUrl = '2014/1/1/my-image.png';
        $this->manager->withHttpPrefix();

        $url = $this->manager
            ->buildUrl($baseUrl);

        $this->string($url)
            ->isEqualTo('//img1.mapado.net/' . $baseUrl);
    }
}
