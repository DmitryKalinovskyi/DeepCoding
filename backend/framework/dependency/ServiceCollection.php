<?php

namespace Framework\dependency;

use Framework\exceptions\ServiceConflictException;
use Framework\exceptions\ServiceNotResolvedException;
use InvalidArgumentException;
use ReflectionException;
use ReflectionFunction;
use ReflectionFunctionAbstract;
use ReflectionMethod;

class ServiceCollection implements IServiceCollection
{
    private array $_services;

    /**
     * @throws ServiceConflictException
     */
    public function __construct(){
        $this->_services = [];

        $this->addSingleton(IServiceCollection::class, $this);
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
        if(is_a($serviceClass,  $serviceInterface, true) === false){
            throw new InvalidArgumentException("Service class should implement service interface.");
        }

        if(empty($this->_services[$serviceInterface]) === false){
            throw new ServiceConflictException("Service for that interface already defined.");
        }

        $this->_services[$serviceInterface] = $serviceClass;
        return $this;
    }

    /**
     * @throws ServiceNotResolvedException
     */
    public function resolve($class, $constructorParams = []): mixed
    {
        $classReflector = new \ReflectionClass($class);

        // get constructor using reflector, if class don't have constructor just create and return object.
        $constructReflector = $classReflector->getConstructor();

        $args = $this->resolveParamsForFunc($constructReflector, $constructorParams);

        // return instance with given params.
        return new $class(...$args);
    }

    /**
     * @throws ServiceNotResolvedException
     */
    private function resolveParamsForFunc(ReflectionFunctionAbstract $func, array $params = []): array{
        $args = $func->getParameters();
        if (empty($args)) {
            return [];
        }

        $resultingParams = [];

        foreach ($args as $argument) {
            $argumentTypeName = $argument->getType();

            if($argumentTypeName !== null) $argumentTypeName = $argumentTypeName->getName();

            $argName = $argument->getName();
            if(array_key_exists($argName, $params))
                $resultingParams[$argName] = $params[$argName];
            else if($argumentTypeName !== null)
                $resultingParams[$argName] = $this->getService($argumentTypeName);
        }

        return $resultingParams;
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
        return $this;
    }

    /**
     * @throws ReflectionException
     * @throws ServiceNotResolvedException
     */
    public function invokeFunction(callable $function, array $params = []): mixed
    {
        $m = new ReflectionFunction($function);

        $params = $this->resolveParamsForFunc($m, $params);

        return $m->invoke(...$params);
    }
}