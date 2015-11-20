<?php

namespace RcmUser\ApiController;

use RcmUser\Provider\RcmUserAclResourceProvider;
use Reliv\RcmApiLib\Controller\AbstractRestfulJsonController;
use Zend\Http\Response;

/**
 * Class AbstractController
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\ApiController
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2015 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class AbstractController extends AbstractRestfulJsonController
{
    /**
     * getRcmUserService
     *
     * @return \RcmUser\Service\RcmUserService
     */
    protected function getRcmUserService()
    {
        return $this->serviceLocator->get(
            'RcmUser\Service\RcmUserService'
        );
    }

    /**
     * isAllowed
     *
     * @param string $resourceId resourceId
     * @param string $privilege  privilege
     *
     * @return mixed
     */
    public function isAllowed(
        $resourceId = RcmUserAclResourceProvider::RESOURCE_ID_ROOT,
        $privilege = null
    ) {
        return $this->getRcmUserService()->isAllowed(
            $resourceId,
            $privilege,
            RcmUserAclResourceProvider::PROVIDER_ID
        );
    }
}
