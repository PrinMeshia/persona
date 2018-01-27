<?php
namespace app\persona\exception;
use Exception;

interface ExceptionObserver
{
  public function update(ObservableException $e);
}