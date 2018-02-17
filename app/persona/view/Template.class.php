<?php
namespace app\persona\view;

class Template 
{
    private function validateVariables(array $variables = [])
    {
        foreach ($variables as $name => $value) {
            if (in_array($name, $this->reservedVariables)) {
                $persona->response->error('Unacceptable view variable given: [body]',409);
                exit(1);
            }
        }
        $variables['application_param'] = $this->persona->config->website;
        return $variables;
    }
    private function getDirectory($controller)
    {
        $parts = explode('\\', $controller);
 
        return end($parts);
    }
 
    private function getFile($controller)
    {
        return str_replace(APP_CONTROLLER_METHOD_SUFFIX, null, $controller);
    }
}