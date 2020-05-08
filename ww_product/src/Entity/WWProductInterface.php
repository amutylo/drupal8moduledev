<?php

namespace Drupal\ww_product\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Wwproduct entities.
 *
 * @ingroup ww_product
 */
interface WWProductInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Wwproduct name.
   *
   * @return string
   *   Name of the Wwproduct.
   */
  public function getName();

  /**
   * Sets the Wwproduct name.
   *
   * @param string $name
   *   The Wwproduct name.
   *
   * @return \Drupal\ww_product\Entity\WWProductInterface
   *   The called Wwproduct entity.
   */
  public function setName($name);

  /**
   * Gets the Wwproduct creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Wwproduct.
   */
  public function getCreatedTime();

  /**
   * Sets the Wwproduct creation timestamp.
   *
   * @param int $timestamp
   *   The Wwproduct creation timestamp.
   *
   * @return \Drupal\ww_product\Entity\WWProductInterface
   *   The called Wwproduct entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Gets the Wwproduct revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Wwproduct revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\ww_product\Entity\WWProductInterface
   *   The called Wwproduct entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Wwproduct revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Wwproduct revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\ww_product\Entity\WWProductInterface
   *   The called Wwproduct entity.
   */
  public function setRevisionUserId($uid);

}
