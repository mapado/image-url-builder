<?php

declare(strict_types=1);

namespace Mapado\ImageUrlBuilder;

class Builder
{
    /**
     * @var ?string
     */
    private $prefix;

    /**
     * @var string prefix of url, prefer using `withHttpPrefix`
     */
    public function __construct(string $prefix = null)
    {
        $this->prefix = $prefix;
    }

    public function withHttpPrefix()
    {
        return new self('http:');
    }

    public function withHttpsPrefix()
    {
        return new self('https:');
    }

    /**
     * generate an image url from its slug
     *
     * @param string $imageSlug the image slug (ie. `/2018/01/foo.jpg`)
     * @param int $width the output width
     * @param int $height the output height
     * @param array $options accept cropWidth, cropHeight or url options parameters (like `rcr`, etc.)
     */
    public function buildUrl(
        string $imageSlug,
        int $width = 0,
        int $height = 0,
        array $options = []
    ): string {
        $image = $imageSlug;
        if (0 === strpos($image, 'http://') || 0 === strpos($image, 'https://')) {
            $image = preg_replace('#^http(s)?://#', '//', $image);
        }

        if (!preg_match('#^//img([1-3])?.mapado.net/#', $image)) {
            $host = $this->getHost($image);
            $image = $host . $image;
        }

        if ($width > 0) {
            $extension = pathinfo($image, PATHINFO_EXTENSION);
            $extLen = strlen($extension);
            if ($extLen > 4) {
                $extension = null;
            }

            $image .= '_thumbs/' . $width;
            if ($height > 0) {
                $image .= '-' . $height;
            }

            if (!empty($options['cropWidth']) || !empty($options['cropHeight'])) {
                $cropWidth = !empty($options['cropWidth']) ? $options['cropWidth'] : 0;
                $cropHeight = !empty($options['cropHeight']) ? $options['cropHeight'] : 0;
                $image .= '-' . (int) $cropWidth . '-' . (int) $cropHeight;

                unset($options['cropWidth']);
                unset($options['cropHeight']);
            }

            if (!empty($options)) {
                $optionValues = [];
                ksort($options);
                foreach ($options as $key => $value) {
                    $optionValues[] = $key . '=' . $value;
                }
                $image .= '.' . implode(';', $optionValues);
            }

            if ($extension) {
                $image .= '.' . $extension;
            }
        }

        return $this->prefix . $image;
    }

    /**
     * getHost
     */
    private function getHost(string $image): string
    {
        $matches = [];
        preg_match('#^[0-9]{4}/[0-9]{1,2}/([0-9]{1,2})#', $image, $matches);
        if (!empty($matches)) {
            $shard = (int) $matches[1] % 2;
            $shard = $shard ?: ''; // remove "0"
        } else {
            $shard = '';
        }
        $host = '//img' . $shard . '.mapado.net/';

        return $host;
    }
}
