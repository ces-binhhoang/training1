<?php

namespace Drupal\movie_db_trailers\Utility;

use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\Core\Render\Markup;

class Helpers {


  public static function getYoutubeId($video_url) {
    if (!$video_url) {
      return '';
    }

    $is_youtube_url = preg_split('/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/', preg_replace('/(>|<)/i', '', $video_url));

    $youtube_id = $is_youtube_url[1] ? preg_split('/[^0-9a-z_\-]/i', $is_youtube_url[1])[0] : $is_youtube_url;

    return $youtube_id;
  }

  public static function getYoutubeThumbnail($video_url, $video_name) {
    if (!$video_url) {
      return '';
    }

    $youtube_id = Helpers::getYoutubeId($video_url);

    $image_variables = [
      '#theme' => 'image',
      '#uri' => "https://i.ytimg.com/vi/$youtube_id/hqdefault.jpg",
      '#alt' => $video_name,
      '#title' => $video_name,
    ];
    $thumbnail = \Drupal::service('renderer')->render($image_variables);

    return $thumbnail;

  }

  public static function renderImageInsideLink(Url $link_url, $image) {
    $thumbnail_markup = Markup::create($image);
    $link             = Link::fromTextAndUrl($thumbnail_markup, $link_url)->toRenderable();

    return $link;
  }

}
