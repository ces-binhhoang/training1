<?php
namespace Drupal\movie_db_trailers\Controller;


use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Controller\ControllerBase;
use Drupal\media\Entity\Media;
use Drupal\movie_db_trailers\Utility\Helpers;

class TrailerController extends ControllerBase {

  public function getLinkTrailer($node) {
    $movie_trailer = $node->get('field_movie_trailer')->getValue(10);
    $arr_trailer_link = [];

    if(!empty($movie_trailer)){
      $count = count($movie_trailer);
      if($count >= 10){
        $count = 10;
      }
      for ($i = 0; $i < $count; $i++){
        $target_id = $movie_trailer[$i]['target_id'];
        $file = Media::load($target_id);
        $media_oembed_video = $file->get('field_media_oembed_video')->getValue();
        $title_trailer = $file->get('name')->getValue()[0]['value'] ?? null;
        $video_url = $media_oembed_video[0]['value'] ?? null;
        $video_id = Helpers::getYoutubeId($video_url);
        $arr_trailer_link[] = [
          'title'     => $title_trailer,
          'url'       => $video_url,
          'video_id'  => $video_id
        ];
      }
    }

    return array(
      "#theme"  => 'trailers_list',
      '#items' => $arr_trailer_link,
      "#attached" => [
        'library' => [
          'movie_db_trailers/styles',
          'core/drupal.dialog.ajax'
        ]
      ]
    );
  }

  public function showModalResults($video_id): AjaxResponse
  {
    $response = new AjaxResponse();
    $content = [
      '#type' => 'inline_template',
      '#template' => '<iframe allowfullscreen width="100%" height="98%" src="https://www.youtube.com/embed/{{ video_id }}?autoplay=1"></iframe>',
      '#context' => [
        'video_id' => $video_id,
      ],
    ];
    $response->addCommand(new OpenModalDialogCommand('Movie Trailers Review', $content, [
      'width' => '800',
      'height' => '600',
    ]));
    return $response;
  }

}
