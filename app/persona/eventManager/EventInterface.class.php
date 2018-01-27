<?php
namespace app\persona\event\EventManager;

/**
 * Representation of an event
 */
interface EventInterface
{
    public function getName();
    public function getTarget();
    public function getParams();
    public function getParam($name);
    public function setName($name);
    public function setTarget($target);
    public function setParams(array $params);
    public function stopPropagation($flag);
    public function isPropagationStopped();
}