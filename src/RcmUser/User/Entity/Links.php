<?php
 /**
 * Links.php
 *
 * Links
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Entity
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\User\Entity;


 /**
 * Class Links
 *
 * Links
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Entity
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */

class Links implements \JsonSerializable {

    protected $links = array();

    /**
     * getLinks
     *
     * @return array
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * addLink
     *
     * @param Link $link
     *
     * @return void
     */
    public function addLink(Link $link)
    {
        $this->links[] = $link;
    }

    /**
     * jsonSerialize
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->links;
    }
} 