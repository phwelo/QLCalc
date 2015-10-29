<?php

namespace QL\CalcBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

// Creating class for new Calculation, which will be used to process the expression
// communicated from our Calculator GUI
class Calculation extends Controller
{
  // simple function to verify existence of an item in post
  private function checkExist($postItem){
    if(isset($_POST[$postItem])){
      return true;
    } else {
      return false;
    }
  }
  // end checkExist

  // replace operator characters with proper PHP math operators
  private function replaceOperators($string){
    if($this->checkExist('expression')){
      $string = str_replace("x","*",$string);
      $string = str_replace("÷","/",$string);
      return $string;
    }
  }
  // end replaceOperators

  // test to make sure we have no letters in post data
  // return true for "ok" and false for "insecure"
  private function checkForTampering($Expression){
    $explodedPost = str_split($this->replaceOperators($Expression));
    foreach ($explodedPost as &$letter){
      if(preg_match("/[A-Za-z]/", $letter, $MatchAlpha)){
        return false;
      } else {
        return true;
      }
    }
  }
  // end checkForTampering

  // Evaluate the contents of the expression now that it has been filtered to
  // prevent invalid operators and user input
  public function evaluateExpression($Expression){
    if($this->checkForTampering($Expression))
    $Expression = $this->replaceOperators($Expression);
    $Evald = eval("return ($Expression);");
    return $Evald;
  }
  // end evaluateExpression
}
// end Calculation class

class DefaultController extends Controller
{
  public function indexAction()
  {
    $Calc1 = new Calculation();
    $screen = $Calc1->evaluateExpression($_POST['expression']);
      // If we get anything unexpected (or nothing, like new load of page) then
      // we want to show nothing on the calculator screen


    return $this->render('QLCalcBundle:Default:index.html.twig', array(
    'screen' => $screen,));
  }
}
