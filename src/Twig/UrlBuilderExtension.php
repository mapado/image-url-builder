<?php

declare(strict_types=1);

namespace Mapado\ImageUrlBuilder\Twig;

use Mapado\ImageUrlBuilder\Builder;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * ImageExtension
 *
 * @author Julien Deniau <julien.deniau@mapado.com>
 */
class UrlBuilderExtension extends AbstractExtension
{
    /**
     * @var Builder
     */
    private $builder;

    /**
     * @param Builder $builder
     */
    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * getFilters
     *
     * @return array
     */
    public function getFilters()
    {
        return [
            new TwigFilter('imageUrl', [$this, 'imageUrl']),
        ];
    }

    /**
     * imageUrl
     *
     * @param string $image
     * @param int $width
     * @param int $height
     * @param array $options
     * @return string
     */
    public function imageUrl(
        string $image,
        int $width = 0,
        int $height = 0,
        array $options = []
    ): string {
        return $this->builder->buildUrl($image, $width, $height, $options);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mapado_image_url_builder';
    }
}
