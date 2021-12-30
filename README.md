# Utils - Utilities for the Offset environment

## Installation

```bash
composer require offset/utils
```

## Use

```php
use Offset\Utils;

// Media Utilities
$media_id = 7;

Utils\Media::isImage($media_id);
Utils\Media::isVideo($media_id);
Utils\Media::getImageSizes($media_id);
```
