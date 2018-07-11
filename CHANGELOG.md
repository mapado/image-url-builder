# Changelog

## 1.2.1

### Changed

* Fix issue with Twig extension
* add php-cs-fixer and phpstan

## 1.2.0

### Added

* Added the `withHttpsPrefix`

### Changed

* Allow url starting with `http://` an `https://` and crop them as well

## 1.1.0

### Added

* Added twig extension

### Changed for closed-source upgrade

* the extension class is now `Mapado\ImageUrlBuilder\Twig\UrlBuilderExtension`
* the `crop` twig filter has been renammed to `buildUrl`

## 1.0.0

### Changed

* Make project public
* Drop support for PHP < 7.0
* imageCrop require a string a parameter (null was authorized before)
* `Mapado\ImageBundle\Manager\CropManager` has been renamed to `Mapado\ImageUrlBuilder\Builder`
* `Mapado\ImageBundle\Manager\CropManager::imageCrop` has been renamed to `Mapado\ImageUrlBuilder\Builder::buildUrl`
* `Mapado\ImageBundle\Manager\CropManager::httpPrefixedCrop` has been changed to this:
  ```php
  $builder->withHttp()->buildUrl($slug);
  ```
