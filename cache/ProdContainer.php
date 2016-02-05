<?php
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;
class ProdContainer extends Container
{
    private $parameters;
    private $targetDirs = array();
    public function __construct()
    {
        $this->parameters = $this->getDefaultParameters();
        $this->services = array();
        $this->methodMap = array(
            'application' => 'getApplicationService',
        );
        $this->aliases = array();
    }
    public function compile()
    {
        throw new LogicException('You cannot compile a dumped frozen container.');
    }
    protected function getApplicationService()
    {
        return $this->services['application'] = new \App\Application(new \App\Greeter\PoliteGreeter(new \App\Service\WellTimedGreetingPhraseMaker()));
    }
    public function getParameter($name)
    {
        $name = strtolower($name);
        if (!(isset($this->parameters[$name]) || array_key_exists($name, $this->parameters))) {
            throw new InvalidArgumentException(sprintf('The parameter "%s" must be defined.', $name));
        }
        return $this->parameters[$name];
    }
    public function hasParameter($name)
    {
        $name = strtolower($name);
        return isset($this->parameters[$name]) || array_key_exists($name, $this->parameters);
    }
    public function setParameter($name, $value)
    {
        throw new LogicException('Impossible to call set() on a frozen ParameterBag.');
    }
    public function getParameterBag()
    {
        if (null === $this->parameterBag) {
            $this->parameterBag = new FrozenParameterBag($this->parameters);
        }
        return $this->parameterBag;
    }
    protected function getDefaultParameters()
    {
        return array(
            'environment' => 'prod',
            'debug' => false,
        );
    }
}
