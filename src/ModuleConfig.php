<?php

namespace RcmUser;

/**
 * Class ModuleConfig
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   HttpTest
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2015 Reliv International
 * @license   License.txt
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class ModuleConfig
{
    /**
     * __invoke
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'RcmUser' => require(__DIR__ . '/../config/rcm-user.php'),
            'dependencies' => require(__DIR__ . '/../config/dependencies.php'),
            'doctrine' => require(__DIR__ . '/../config/doctrine.php'),
        ];
    }
}
