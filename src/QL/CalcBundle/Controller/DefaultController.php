<?php

namespace QL\CalcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('QLCalcBundle:Default:index.html.twig');
    }
}
