<?php

declare(strict_types=1);

namespace Mapado\ImageUrlBuilder\Twig;

use Mapado\ImageUrlBuilder\Builder;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class UrlBuilderExtension extends AbstractExtension
{
    /**
     * @var Builder
     */
    private $builder;

    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @return array<TwigFilter>
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('imageUrl', [$this, 'imageUrl']),
            new TwigFilter('imageUrlHttp', [$this, 'imageUrlHttp']),
        ];
    }

    /**
     * @param array<string, mixed> $options
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
     * @param array<string, mixed> $options
     */
    public function imageUrlHttp(
        string $image,
        int $width = 0,
        int $height = 0,
        array $options = []
    ): string {
        return $this->builder->withHttpPrefix()->buildUrl($image, $width, $height, $options);
    }
}
