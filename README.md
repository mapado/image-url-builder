# image-url-builder
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
$url = $builder->buildUrl('/2018/01/foo.jpg', $width, $height);

// will output '//img.mapado.net/2018/01/foo_thumbs/800-600.jpg'
```

### Force http prefix

If you want to force http prefix, you can use the `withHttpPrefix()` function before :
```php
$url = $builder
    ->withHttpPrefix()
        ->buildUrl($slug, $width, $height);
```
