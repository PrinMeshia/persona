<?php
namespace app\persona\observerInterface;
interface ObserverInterface {
    public function attacher(ObservateurInterface $observateur);
    public function detacher(ObservateurInterface $observateur);
    public function notifier();
}