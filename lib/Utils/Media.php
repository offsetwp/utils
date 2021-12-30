<?php
namespace Offset\Utils;

/**
 * Media Utilities
 */
class Media
{
    /**
     * Checks with the ID that the media is an image
     *
     * @param integer $media_id
     * @return boolean
     */
    public static function isImage(int $media_id = 0)
    {
        if (empty($media_id)) {
            return false;
        }

        return wp_attachment_is('image', $media_id);
    }

    /**
     * Checks with the ID that the media is an video
     *
     * @param integer $media_id
     * @return boolean
     */
    public static function isVideo(int $media_id = 0)
    {
        if (empty($media_id)) {
            return false;
        }

        return wp_attachment_is('video', $media_id);
    }

    /**
     * Return the list of available image sizes with the url, width and height
     *
     * @param integer $media_id
     * @return array
     */
    public static function getImageSizes(int $media_id = 0)
    {
        $sizes = array();

        if (empty($media_id)) {
            return $sizes;
        }

        $upload_url = wp_get_upload_dir();
        $upload_url = $upload_url['baseurl'] ?? '';
        $sizes_list = get_intermediate_image_sizes();
        $media_metadatas = wp_get_attachment_metadata($media_id);

        if (empty($upload_url) || empty($sizes_list) || empty($media_metadatas)) {
            return $sizes;
        }

        foreach ($sizes_list as $size) {
            $imageTmp = wp_get_attachment_image_src($media_id, $size);

            if (empty($imageTmp)) {
                continue;
            }

            $sizes[$size] = array(
              'url' => (string) $imageTmp[0],
              'width' => (int) $imageTmp[1],
              'height' => (int) $imageTmp[2],
            );
        }

        $sizes['origin'] = array(
            'url' => !empty($upload_url) && !empty($media_metadatas['file']) ? $upload_url . '/' . $media_metadatas['file'] : '',
            'width' => (int) $media_metadatas['width'] ?? 0,
            'height' => (int) $media_metadatas['height'] ?? 0,
        );

        return $sizes;
    }
}
