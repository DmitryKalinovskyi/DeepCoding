<?php

namespace Framework\dependency;

use Framework\exceptions\ServiceNotResolvedException;

class ServiceCollection implements IServiceCollection
{
    private array $_services;

    public function __construct(){
        $this->_services = [];
    }

    public function GetService($serviceInterface): object
    {
        if(empty($this->_services[$serviceInterface]))
            throw new ServiceNotResolvedException("Service with interface $serviceInterface not resolved.");

        return $this->_services[$serviceInterface];
    }

    public function AddTransient($serviceInterface, $serviceClass): void
    {
    }

    public function AddScoped($serviceInterface, $serviceClass): void
    {
        // TODO: Implement AddScoped() method.
    }

    public function AddSingleton($singleton)
    {
        // TODO: Implement AddSingleton() method.
    }

    /**
     * @throws ServiceNotResolvedException
     */
    public function Resolve($class, $constructorParams = [])
    {
        $classReflector = new \ReflectionClass($class);

        // get constructor using reflector, if class don't have constructor just create and return object.
        $constructReflector = $classReflector->getConstructor();
        if (empty($constructReflector)) {
            return new $class;
        }

        // get constructor arguments, return new object if constructor without parameters.
        $constructArguments = $constructReflector->getParameters();
        if (empty($constructArguments)) {
            return new $class;
        }

        // get arguments
        $args = [];
        foreach ($constructArguments as $argument) {
            $argumentType = $argument->getType()->getName();

            $args[$argument->getName()] = $this->GetService($argumentType);
        }

        foreach($constructorParams as $key => $value){
            $args[$key] = $value;
        }

        // return instance with given params.
        return new $class(...$args);
    }
}