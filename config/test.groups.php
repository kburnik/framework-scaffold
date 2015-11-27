<?php

return array(
  'model_unittests' => glob("model/*/testsuite/*TestCase.php"),
  'controller_unittests' => glob("controller/testsuite/*TestCase.php"),
  'api_unittests' => glob("public_html/api/responder/testsuite/*TestCase.php")
);
