calculator
==========
A Symfony project created for programming test.

Most interesting files:

`/src/QL/CalcBundle/Resources/views/Default/index.html.twig`

`/src/QL/CalcBundle/Controller/DefaultController.php`

<img src="http://i.imgur.com/FtDiN4X.png">

##index.html.twig

Javascript used to input the numbers and submit the value back to the controller.  The clickNums function concats itself to create the expression that is communicated to the controller.

##DefaultController.php

Controller php

functions:

checkExist         - checks to make sure that a value has been posted and returns true or false

getPost            - gets the posted value of a specified parameter

replaceOperators   - replaces the division and multiple operators from x to * and ÷ to /
                     returns the expression with replaced values
                     this was left up to PHP simply because this is a PHP position
                     
explodeExpression  - converts a string to an array of single characters and returns that array

checkForTampering  - checks for any a-z and A-Z in the returned results.  This because we are about to use eval on the posted                      information and we want to make sure that information coudln't be injected to our post.

removeTrailingOps  - leaving any *,/,-,+ at the end of the string before eval causes an error in PHP. This function strips the                      leading character if it's any of these.

removeLeadingOps   - same as above, but remove * or / from the front of the string

runTests           - this function is used to run test functions. First runs checkExist, then replaceOperators, then                               checkForTampering, and then returns true if it's passed all of the tests.

evaluateExpression - runs replaceOperations, removeTrailingOps,removeLeadingOps, then runs eval on our expression
