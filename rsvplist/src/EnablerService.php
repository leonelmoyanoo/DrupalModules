<?php
/**
 * @file
 * Contains \Drupal\rsvplist\EnablerService
 */
namespace Drupal\rsvplist;

use Drupal\Core\Database\Database;
use Drupal\Node\Entity\Node;

/**
 * Defines a service for managing RSVP list enabled fornodes.
 */

class EnablerService {
    /**
     * Constructor
     */
    public function __construct() {
        /**
         * Sets a individual node to be RSVP enabled.
         * 
         * @param \Drupal\node\Entity\Node $node
         */
        function setEnabled(Node $node) {
            if (!$this->isEnabled($node)) {
                $insert = Database::getConnection()->insert('rsvplist_enaled');
                $insert->fields(array('nid'), array($node->id()));
                $insert->execute(); 
            }
        }

        /**
         * Check if an individual node is RSVP enabled.
         * 
         * @param \Drupal\node\Entity\Node $node
         * 
         * @return bool
         * Wheter the node is enabled for the RSVP functionality
         */
        function isEnabled(Node $node){
            if($node->isNew()){
                return FALSE;
            }
            $select = Database::getConnection()->select('rsvplist_enabled', 're');
            $select->condition('nid',$node->id());
            $results = $select->execute();
            return !empty($results->fetchCol());
        }

        /**
         * Delets enabled settings for an individual node.
         * 
         * @param \Drupal\node\Entity\Node $node
         */
        function delEnabled(Node $node) {
            $delete = Databas::getConnection()
                                ->delete('rsvplist_enabled');
            $delete->condition('nid', $node->id());
            $delete->execute();
        }
    }
}
