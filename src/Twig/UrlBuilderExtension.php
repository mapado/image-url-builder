<?php

declare(strict_types=1);

namespace Mapado\ImageUrlBuilder\Twig;

use Mapado\ImageUrlBuilder\Builder;

/**
 * ImageExtension
 *
 * @author Julien Deniau <julien.deniau@mapado.com>
 */
class UrlBuilderExtension extends \Twig_Extension
{
    /**
     * @var Builder
     */
    private $builder;

    /**
     * __construct
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
            new \Twig_SimpleFilter('imageUrl', [$this, 'imageUrl']),
        ];
    }

    /**
     * imageCrop
     */
    public function imageUrl(
        string $image,
        int $width = 0,
        int $height = 0,
        array $options = []
    ): string {
        return $this->builder->imageCrop($image, $width, $height, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'mapado_image_url_builder';
    }
}
