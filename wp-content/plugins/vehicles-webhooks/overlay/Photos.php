<?php

namespace V12software\InventoryBuilder;

class Photos
{

    private static $MODE_PROCESS = 1;
    private static $CLOUDINARY_URL = 'https://res.cloudinary.com/v12ai/image/upload';
    private static $CDN_URL = 'https://res.cloudinary.com/v12ai/image/upload';

    private static $params = [
        'classified_id' => 1,
        'width' => 800,
        'height' => 600,
        'main' => false,
        'overlaid' => 1,
        'overlay_images' => null,
        'watermark_images' => null,
        'overlay_id' => null,
        'fill' => 1,
        'photos' => null,
        'quality' => 100,
        'user_id' => null,
        'default_photo' => 'coming_soon.jpg',
        'has_default_photo' => true,
    ];

    public static function build($vehicle_id, $params)
    {
        self::checkMode($params);
        self::$params = array_merge(self::$params, $params);
        if (self::$params['main'] && strpos(self::$params['overlay_images'], '"1"') === false) {
            self::$params['overlay_images'] = null;
        }

        $photoLinks = array();
        self::$params['photos'] =!is_array(self::$params['photos']) ? unserialize(self::$params['photos']) : self::$params['photos'];
        if (is_null(self::$params['photos']) || !self::$params['photos'] || count(self::$params['photos']) == 0) {
            if (self::$params['has_default_photo'] && (!is_array(self::$params['photos']) || count(self::$params['photos']) == 0)) {
                return self::noPhoto(self::$params['default_photo'], self::$params['width'], self::$params['height'], self::$params['quality']);
            }
            return $photoLinks;
        }

        foreach (self::$params['photos'] as $photo_index => $photo) {
            $overlay_type = null;
            if (!isset($photo['photo'])) {
                continue;
            }
            $photo = $photo['photo'];
            if (self::$params['overlaid']) {
                if (isset(self::$params['photo_index'])) {
                    if (self::$params['photo_index'] != $photo_index) {
                        continue;
                    }
                }
                if (self::$params['overlay_id']) {
                    $overlay_type = self::getOverlayType(self::$params['overlay_images'], self::$params['watermark_images'], $photo_index, count(self::$params['photos']));
                }
            }

            if (self::$MODE_PROCESS == 0 || (self::$params['main'] == true && $photo_index > 0)) {
                $photoLinks[] = self::$CDN_URL . '/' . $params['user_id'] . '/' . $vehicle_id . '/' . $photo;
            } else {
                $fill = self::$params['fill'];
                if (self::$MODE_PROCESS == 1) {
                    $photoLinks[] = self::buildURL($vehicle_id, $params['user_id'], $photo, self::$params['overlay_id'], $fill, $overlay_type, self::$params['width'], self::$params['height'], self::$params['quality']);
                }
            }
        }
        return $photoLinks;
    }

    public static function buildURL($vehicle_id, $user_id, $photo, $overlay_id, $fill, $overlay_type, $width = 800, $height = 600, $quality = 100)
    {
        $return = '';
        $config = [];

        $config['w'] = $width;
        $config['h'] = $height;

        if ($fill == 'yes') {
            $config['c'] = 'pad';
            $config['b'] = 'auto';
        }
        if ($quality < 100) {
            $config['q'] = $quality;
        }
        if (count($config)) {
            $return .= '/';
            foreach ($config as $key => $val) {
                $return .= $key . '_' . $val . ',';
            }
        }
        $return = rtrim($return, ',');
        if ($overlay_type) {
            $return .= '/';
            $return .= 'w_' . $width . ',h_' . $height . ',';
            $overlay_url = self::$CDN_URL . '/' . $user_id . '/overlays/' . $overlay_type . '-' . $overlay_id . '.png';
            $return .= 'l_fetch:' . base64_encode($overlay_url);
        }

        if (empty($return)) {
            $return = self::$CDN_URL . $return . '/' . $user_id . '/' . $vehicle_id . '/' . $photo;
        } else {
            $return = self::$CLOUDINARY_URL . $return . '/' . $user_id . '/' . $vehicle_id . '/' . $photo;
        }

        return $return;
    }

    public static function getOverlayType($overlay_images, $watermark_images, $index, $total = 120)
    {
        $overlay_type = null;
        ++$index;
        if ($overlay_images != null && strlen($overlay_images) > 0 && $overlay_images !== 0) {
            $overlay_images = json_decode($overlay_images, true);
            if ($index == 1 && in_array(1, $overlay_images)) {
                $overlay_type = "overlay";
            } elseif ($index > 1 && $index < $total && in_array(2, $overlay_images)) {
                $overlay_type = "overlay";
            } elseif ($index == $total && in_array(3, $overlay_images)) {
                $overlay_type = "overlay";
            }
        }
        if ($overlay_type == null && $watermark_images && strlen($watermark_images) > 0 && $watermark_images != 0) {
            $watermark_images = json_decode($watermark_images, true);
            if ($index == 1 && in_array(1, $watermark_images)) {
                $overlay_type = "watermark";
            } elseif ($index > 1 && $index < $total && in_array(2, $watermark_images)) {
                $overlay_type = "watermark";
            } elseif ($index == $total && in_array(3, $watermark_images)) {
                $overlay_type = "watermark";
            }
        }
        return $overlay_type;
    }

    public static function noPhoto($photo, $width = 800, $height = 600, $quality = 100)
    {
        $return = '';
        $config = [];

        $config['w'] = $width;
        $config['h'] = $height;

        if ($quality < 100) {
            $config['q'] = $quality;
        }
        if (count($config)) {
            $return .= '/';
            foreach ($config as $key => $val) {
                $return .= $key . '_' . $val . ',';
            }
        }
        $return = rtrim($return, ',');
        $return = self::$CLOUDINARY_URL . $return . '/' . $photo;
        return array(
            $return
        );
    }

    public static function getOverlaySettingsSql($user_id, $classified_id = 1)
    {
        return 'SELECT overlay_templates.id as overlay_id, `overlay_templates`.`overlay_images`,`overlay_templates`.`watermark_images` 
                FROM `overlay_templates` JOIN `classifieds_overlay_templates` 
                WHERE `classifieds_overlay_templates`.`overlay_template_id` = `overlay_templates`.`id`
                AND `overlay_templates`.`user_id` = ' . $user_id . ' 
                AND `classifieds_overlay_templates`.`classified_id` = ' . $classified_id . ';';
    }

    public static function checkMode($params)
    {
        if (isset($params['app_env'])) {
            $app_env = $params['app_env'];
        } else {
            $app_env = "prod";
        }
        if (strlen($app_env) == 0) {
            $app_env = 'prod';
        }
        if ($app_env != 'prod' && $app_env != 'prd') {
            self::$CLOUDINARY_URL = 'https://res.cloudinary.com/pwappd/image/upload';
            self::$CDN_URL = 'https://res.cloudinary.com/pwappd/image/upload';
        }
    }
}
