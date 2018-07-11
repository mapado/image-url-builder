# image-url-builder [![Build Status](https://travis-ci.org/mapado/image-url-builder.svg?branch=master)](https://travis-ci.org/mapado/image-url-builder)
Generate a full url from an image slug

## Installation

```sh
composer require mapado/image-url-builder
```

## Usage

```php
use Mapado\ImageUrlBuilder\Builder;

$builder = new Builder();

$width = 800;
$height = 600;
$url = $builder->buildUrl('2018/01/foo.jpg', $width, $height);

// will output '//img.mapado.net/2018/01/foo_thumbs/800-600.jpg'
```

The first parameter of the `buildUrl` function accept an image "slug" or a full image url (starting with `https://img.mapado.net/`)

### Force http(s) prefix

If you want to force http prefix, you can use the `withHttpPrefix()` or `withHttpsPrefix()` function before :
```php
$httpUrl = $builder
    ->withHttpPrefix()
        ->buildUrl($slug, $width, $height);
// will output `http://img.mapado.net/xxxx...`

$httpsUrl = $builder
    ->withHttpsPrefix()
        ->buildUrl($slug, $width, $height);
// will output `https://img.mapado.net/xxxx...`
```

### With Twig

A Twig extension is available : `Mapado\ImageUrlBuilder\Twig\UrlBuilderExtension`

You can use the filter like this:
```twig
<img src="{{ imageSlug|imageUrl(width, height) }}" />
```
