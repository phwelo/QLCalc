<?php

namespace QL\CalcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
  public function indexAction()
  {

    $screen = "";
    #var_dump($_POST);
    if(isset($_POST["expression"])){
      $EvalBlock = $_POST["expression"];
      $Exploded_Expression = explode('+',$EvalBlock);
      var_dump($Exploded_Expression);
      echo $screen;
    } else {
      $screen = "";
    }
    return $this->render('QLCalcBundle:Default:index.html.twig', array(
    'screen' => $screen,));
  }
}
