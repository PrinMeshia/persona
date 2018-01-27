<?php
namespace app\persona\observerInterface;
abstract class AbstractObserver {
    abstract function update(AbstractSubject $subject_in);
}