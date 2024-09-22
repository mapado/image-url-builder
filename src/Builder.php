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
     * @param ?string $prefix prefix of url, prefer using `withHttpPrefix`
     */
    public function __construct(?string $prefix = null)
    {
        $this->prefix = $prefix;
    }

    public function withHttpPrefix(): self
    {
        return new self('http:');
    }

    public function withHttpsPrefix(): self
    {
        return new self('https:');
    }

    /**
     * generate an image url from its slug
     *
     * @param string $imageSlug the image slug (ie. `/2018/01/foo.jpg`)
     * @param ?int $width the output width
     * @param ?int $height the output height
     * @param array<string, string|int> $options accept cropWidth, cropHeight or url options parameters (like `rcr`, etc.)
     * @param ?bool $useFailover if true, will use failover server
     */
    public function buildUrl(
        string $imageSlug,
        ?int $width = null,
        ?int $height = null,
        array $options = [],
        ?bool $useFailover = false,
    ): string {
        $image = trim($imageSlug);
        if (0 === strpos($image, 'http://') || 0 === strpos($image, 'https://')) {
            $image = preg_replace('#^http(s)?://#', '//', $image);
        }

        if (null !== $image && !preg_match('#^//img([1-3])?.mapado.net/#', $image)) {
            $host = '//img.mapado.net/';
            $image = $host . $image;
        }

        if (null !== $image && $useFailover && preg_match('#^//img([1-3])?.mapado.net/#', $image)) {
            $image = preg_replace('#^//img([1-3])?\.mapado\.net/#', '//failover-img.mapado.net/', $image);
        }

        if (null !== $image && (null !== $width || null !== $height || !empty($options))) {
            $extension = pathinfo($image, PATHINFO_EXTENSION);
            $extLen = strlen($extension);
            if ($extLen > 4) {
                $extension = null;
            }

            $image .= '_thumbs/' . ($width ?? 0) . '-' . ($height ?? 0);

            if (!empty($options['cropWidth']) || !empty($options['cropHeight'])) {
                $cropWidth = $options['cropWidth'] ?? 0;
                $cropHeight = $options['cropHeight'] ?? 0;
                $image .= '-' . (int) $cropWidth . '-' . (int) $cropHeight;

                unset($options['cropWidth']);
                unset($options['cropHeight']);
            }

            if (!empty($options)) {
                $optionValues = [];
                ksort($options);
                foreach ($options as $key => $value) {
                    if ($key !== 'allowwebp') {
                        $optionValues[] = $key . '=' . $value;
                    }
                }
                if (!empty($optionValues)) {
                    $image .= '.' . implode(';', $optionValues);
                }
            }

            if ($extension) {
                $image .= '.' . $extension;
            }
        }

        return $this->prefix . $image;
    }
}
