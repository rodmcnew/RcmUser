<?php
 /**
 * RcmHtmlHeadServiceInterface.php
 *
 * RcmHtmlHeadServiceInterface
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\view
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\View\Service;


/**
 * Interface RcmHtmlHeadServiceInterface
 *
 * RcmHtmlHeadServiceInterface
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\View\Service
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright ${YEAR} Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
interface RcmHtmlHeadServiceInterface {

    public function build($view, $options);
} 