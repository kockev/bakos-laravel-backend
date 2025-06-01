<?php

namespace App\Support\MediaLibrary;

use App\Models\KitchenOrder;
use App\Models\Order;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class OrderPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        return match (true) {
            $media->model instanceof Order => 'orders/' . $media->model->created_at->format('Y-m-d') . '/',
            $media->model instanceof KitchenOrder => 'kitchen-orders/' . $media->model->created_at->format('Y-m-d')  . '/',
            default => $this->getBasePath($media) . '/',
        };
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media);
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media);
    }

    protected function getBasePath(Media $media): string
    {
        $prefix = config('media-library.prefix', '');

        if ($prefix !== '') {
            return $prefix . '/' . $media->getKey();
        }

        return $media->getKey();
    }
}
