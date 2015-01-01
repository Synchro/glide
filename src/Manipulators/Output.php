<?php

namespace Glide\Manipulators;

use Glide\Interfaces\Manipulator;
use Glide\Request;
use Intervention\Image\Image;

class Output implements Manipulator
{
    /**
     * Perform output image manipulation.
     * @param  Request $request The request object.
     * @param  Image   $source  The source image.
     * @return null
     */
    public function run(Request $request, Image $image)
    {
        $image->encode(
            $this->getFormat($request->getParam('fm')),
            $this->getQuality($request->getParam('q'))
        );
    }

    /**
     * Resolve format.
     * @param  string $format The format.
     * @return string The resolved format.
     */
    public function getFormat($format)
    {
        $default = 'jpg';

        if (is_null($format)) {
            return $default;
        }

        if (!in_array($format, ['jpg', 'png', 'gif'])) {
            return $default;
        }

        return $format;
    }

    /**
     * Resolve quality.
     * @param  string $quality The quality.
     * @return string The resolved quality.
     */
    public function getQuality($quality)
    {
        $default = 90;

        if (is_null($quality)) {
            return $default;
        }

        if (!ctype_digit($quality)) {
            return $default;
        }

        if ($quality < 0 or $quality > 100) {
            return $default;
        }

        return $quality;
    }
}
