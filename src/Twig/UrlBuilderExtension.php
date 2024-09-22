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
        ];
    }

    /**
     * @param array<string, string|int> $options
     */
    public function imageUrl(
        string $image,
        int $width = 0,
        int $height = 0,
        array $options = []
    ): string {
        // By default, for the twig extension, we use the failover server
        return $this->builder->buildUrl($image, $width, $height, $options, true);
    }
}
