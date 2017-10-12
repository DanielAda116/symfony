<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 12.10.2017
 * Time: 11:33
 */

namespace AppBundle\Service;



use Symfony\Component\HttpFoundation\RequestStack;

class ChangeUrl
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function getChangedURL()
    {

        $request = $this->requestStack->getCurrentRequest();
        $adress = $request->getScheme();

        return $adress;
    }
}