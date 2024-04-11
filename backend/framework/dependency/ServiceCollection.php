<?php

namespace Framework\dependency;

use Framework\exceptions\ServiceConflictException;
use Framework\exceptions\ServiceNotResolvedException;
use InvalidArgumentException;

class ServiceCollection implements IServiceCollection
{
    private array $_services;

    public function __construct(){
        $this->_services = [];
    }

    public function getService($serviceInterface): mixed
    {
        if(empty($this->_services[$serviceInterface]))
            throw new ServiceNotResolvedException("Service with interface $serviceInterface not resolved.");

        $service = $this->_services[$serviceInterface];
        if(gettype($service) === "string"){
            return $this->_services[$serviceInterface] = $this->resolve($service);
        }

        return $service;
    }

    /**
     * @throws ServiceConflictException
     */
    public function addScoped($serviceInterface, $serviceClass): IServiceCollection
    {
        if(($serviceClass instanceof $serviceInterface) === false){
            throw new InvalidArgumentException("Service class should implement service interface.");
        }

        if(empty($this->_services[$serviceInterface]) === false){
            throw new ServiceConflictException("Service for that interface already defined.");
        }

        $this->_services[$serviceInterface] = $serviceClass;
    }



    /**
     * @throws ServiceNotResolvedException
     */
    public function resolve($class, $constructorParams = []): mixed
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

            $args[$argument->getName()] = $this->getService($argumentType);
        }

        foreach($constructorParams as $key => $value){
            $args[$key] = $value;
        }

        // return instance with given params.
        return new $class(...$args);
    }

    /**
     * @throws ServiceConflictException
     */
    public function addSingleton($serviceInterface, $serviceInstance): IServiceCollection
    {
        if(($serviceInstance instanceof $serviceInterface) === false){
            throw new InvalidArgumentException("Service class should implement service interface.");
        }

        if(empty($this->_services[$serviceInterface]) === false){
            throw new ServiceConflictException("Service for that interface already defined.");
        }

        $this->_services[$serviceInterface] = $serviceInstance;
    }

    public function resolveMethod(callable $method): mixed
    {
        return "not implemented.";
    }
}