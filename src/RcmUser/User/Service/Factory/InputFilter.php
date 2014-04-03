<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\User\Service\Factory;

use RcmUser\User\InputFilter\UserInputFilter;
use Zend\InputFilter\Factory;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class InputFilter implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $inputFilter = new UserInputFilter();
        $factory = new Factory();
        $inputs = $serviceLocator->get('RcmUser\UserConfig')->get('InputFilter', array());

        foreach ($inputs as $k => $v) {
            $inputFilter->add($factory->createInput($v), $k);
        }

        return $inputFilter;
    }
}
