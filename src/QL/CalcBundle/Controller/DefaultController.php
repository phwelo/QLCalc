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

  // grab post data and return false if we don't have any
  public function getPost($postItem){
    if($this->checkExist('expression')){
      return $_POST['expression'];
    } else {
      return false;
    }
  }
  // end getPost

  // replace operator characters with proper PHP math operators
  private function replaceOperators($string){
      $string = str_replace("x","*",$string);
      $string = str_replace("÷","/",$string);
      return $string;
  }
  // end replaceOperators

  // remove any trailing multiply or divide operators
  private function explodeExpression($Expression){
    $explodedPost = str_split($this->replaceOperators($Expression));
    return $explodedPost;
  }

  // test to make sure we have no letters in post data
  // return true for "ok" and false for "insecure"
  private function checkForTampering($Expression){
    foreach ($this->explodeExpression($Expression) as &$letter){
      if(preg_match("/[A-Za-z]/", $letter, $MatchAlpha)){
        return false;
      } else {
        return true;
      }
    }
  }
  // end checkForTampering

  // trailing operators screw up the evaluation of the expression so we cut them
  private function removeTrailingOps($Expression){
    $exploded = $this->explodeExpression($Expression);
    if(end($exploded) == '*' or end($exploded) == '/' or end($exploded) == '+' or end($exploded) == '-'){
      $Expression = substr($Expression, 0, -1);
    }
    return $Expression;
  }
  // end removeTrailingOps

  private function removeLeadingOps($Expression){
    $exploded = $this->explodeExpression($Expression);
    if($exploded[0] == '*' or $exploded[0] == '/'){
      $Expression = substr($Expression, 1);
    }
    return $Expression;
  }
  public function runTests($Expression){
    if($this->checkExist('expression')){
      $opsReplacedExpression = $this->replaceOperators($Expression);
      if($this->checkForTampering($opsReplacedExpression)){
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  // Evaluate the contents of the expression now that it has been filtered to
  // prevent invalid operators and user input
  public function evaluateExpression($Expression){
    $Expression = $this->replaceOperators($Expression);
    $Expression = $this->removeTrailingOps($Expression);
    $Expression = $this->removeLeadingOps($Expression);
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
    // instantiate new Calculation object
    $Calc1 = new Calculation();
    $TestResults = $Calc1->runTests($Calc1->getPost('expression'));
    if($TestResults){
      $screen = $Calc1->evaluateExpression($Calc1->getPost('expression'));
    } else {
      $screen = "";
    }
    return $this->render('QLCalcBundle:Default:index.html.twig', array(
    'screen' => $screen,));
  }
}
