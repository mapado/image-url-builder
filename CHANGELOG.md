# Changelog

## 2.2.0

Remove use of img/img1 as we are now multiplexing with http2
Add option allowwebp to enable webp optimization even for not resized images
Allow =0 width, with >= height to resize based on set height

## 2.1.1

Fix malformed imageSlug parameter in buildUrl

## 2.1.0

Add support for PHP 8.x

## 2.0.0

### Added

- Add support for twig 3

### Changed

- [BREAKING] Drop support for PHP 7.1
- [Minor BC] Add static types everywhere
- [Minor BC] Remove `UrlBuilderExtenion::getName` method. It was used in twig 1 but is not used in twig >= 2

## 1.2.1

### Changed

- Fix issue with Twig extension
- add php-cs-fixer and phpstan

## 1.2.0

### Added

- Added the `withHttpsPrefix`

### Changed

- Allow url starting with `http://` an `https://` and crop them as well

## 1.1.0

### Added

- Added twig extension

### Changed for closed-source upgrade

- the extension class is now `Mapado\ImageUrlBuilder\Twig\UrlBuilderExtension`
- the `crop` twig filter has been renammed to `buildUrl`

## 1.0.0

### Changed

- Make project public
- Drop support for PHP < 7.0
- imageCrop require a string a parameter (null was authorized before)
- `Mapado\ImageBundle\Manager\CropManager` has been renamed to `Mapado\ImageUrlBuilder\Builder`
- `Mapado\ImageBundle\Manager\CropManager::imageCrop` has been renamed to `Mapado\ImageUrlBuilder\Builder::buildUrl`
- `Mapado\ImageBundle\Manager\CropManager::httpPrefixedCrop` has been changed to this:
  ```php
  $builder->withHttp()->buildUrl($slug);
  ```
