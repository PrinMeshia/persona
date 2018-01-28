<?php
namespace app\vendor\profiler\dataCollector;

interface DataCollectorInterface
{
    /**
     * Collects data 
     */
    function collect();
    function getName();
}