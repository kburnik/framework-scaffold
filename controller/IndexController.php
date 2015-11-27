<?php

class IndexController extends TemplateController {

  public function main() {
    return readview('index.view.html');
  }

}