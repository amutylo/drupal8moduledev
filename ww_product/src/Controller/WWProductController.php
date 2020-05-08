<?php

namespace Drupal\ww_product\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Datetime\DateFormatter;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Render\Renderer;
use Drupal\Core\Url;
use Drupal\ww_product\Entity\WWProductInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class WWProductController.
 *
 *  Returns responses for Wwproduct routes.
 */
class WWProductController extends ControllerBase implements ContainerInjectionInterface {


  /**
   * The date formatter.
   *
   * @var \Drupal\Core\Datetime\DateFormatter
   */
  protected $dateFormatter;

  /**
   * The renderer.
   *
   * @var \Drupal\Core\Render\Renderer
   */
  protected $renderer;

  /**
   * Constructs a new WWProductController.
   *
   * @param \Drupal\Core\Datetime\DateFormatter $date_formatter
   *   The date formatter.
   * @param \Drupal\Core\Render\Renderer $renderer
   *   The renderer.
   */
  public function __construct(DateFormatter $date_formatter, Renderer $renderer) {
    $this->dateFormatter = $date_formatter;
    $this->renderer = $renderer;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('date.formatter'),
      $container->get('renderer')
    );
  }

  /**
   * Displays a Wwproduct revision.
   *
   * @param int $w_w_product_revision
   *   The Wwproduct revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($w_w_product_revision) {
    $w_w_product = $this->entityTypeManager()->getStorage('w_w_product')
      ->loadRevision($w_w_product_revision);
    $view_builder = $this->entityTypeManager()->getViewBuilder('w_w_product');

    return $view_builder->view($w_w_product);
  }

  /**
   * Page title callback for a Wwproduct revision.
   *
   * @param int $w_w_product_revision
   *   The Wwproduct revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($w_w_product_revision) {
    $w_w_product = $this->entityTypeManager()->getStorage('w_w_product')
      ->loadRevision($w_w_product_revision);
    return $this->t('Revision of %title from %date', [
      '%title' => $w_w_product->label(),
      '%date' => $this->dateFormatter->format($w_w_product->getRevisionCreationTime()),
    ]);
  }

  /**
   * Generates an overview table of older revisions of a Wwproduct.
   *
   * @param \Drupal\ww_product\Entity\WWProductInterface $w_w_product
   *   A Wwproduct object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(WWProductInterface $w_w_product) {
    $account = $this->currentUser();
    $w_w_product_storage = $this->entityTypeManager()->getStorage('w_w_product');

    $langcode = $w_w_product->language()->getId();
    $langname = $w_w_product->language()->getName();
    $languages = $w_w_product->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $w_w_product->label()]) : $this->t('Revisions for %title', ['%title' => $w_w_product->label()]);

    $header = [$this->t('Revision'), $this->t('Operations')];
    $revert_permission = (($account->hasPermission("revert all wwproduct revisions") || $account->hasPermission('administer wwproduct entities')));
    $delete_permission = (($account->hasPermission("delete all wwproduct revisions") || $account->hasPermission('administer wwproduct entities')));

    $rows = [];

    $vids = $w_w_product_storage->revisionIds($w_w_product);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\ww_product\WWProductInterface $revision */
      $revision = $w_w_product_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = $this->dateFormatter->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $w_w_product->getRevisionId()) {
          $link = $this->l($date, new Url('entity.w_w_product.revision', [
            'w_w_product' => $w_w_product->id(),
            'w_w_product_revision' => $vid,
          ]));
        }
        else {
          $link = $w_w_product->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => $this->renderer->renderPlain($username),
              'message' => [
                '#markup' => $revision->getRevisionLogMessage(),
                '#allowed_tags' => Xss::getHtmlTagList(),
              ],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.w_w_product.translation_revert', [
                'w_w_product' => $w_w_product->id(),
                'w_w_product_revision' => $vid,
                'langcode' => $langcode,
              ]) :
              Url::fromRoute('entity.w_w_product.revision_revert', [
                'w_w_product' => $w_w_product->id(),
                'w_w_product_revision' => $vid,
              ]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.w_w_product.revision_delete', [
                'w_w_product' => $w_w_product->id(),
                'w_w_product_revision' => $vid,
              ]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['w_w_product_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
