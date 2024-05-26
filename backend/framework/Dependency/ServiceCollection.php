<?php

namespace Framework\Dependency;

use Closure;
use Framework\Exceptions\ServiceConflictException;
use Framework\Exceptions\ServiceNotResolvedException;
use InvalidArgumentException;
use ReflectionException;
use ReflectionFunction;
use ReflectionFunctionAbstract;
use ReflectionMethod;

class ServiceCollection implements IServiceCollection
{
    // name <-> className
    private array $services;

    private array $resolvedServices;

    public function __construct(){
        $this->services = [];

        $this->addScopedForInterface(IServiceCollection::class,
            ServiceCollection::class,
            fn() => $this);
    }

    public function getService(string $serviceName): mixed
    {
        if(empty($this->services[$serviceName])){
            var_dump($this->services);
            throw new ServiceNotResolvedException("Service with interface $serviceName not resolved.");
        }

        return $this->services[$serviceName]();
    }

    public function resolve(string $class, $constructorParams = []): mixed
    {
        $classReflector = new \ReflectionClass($class);

        // get constructor using reflector, if class don't have constructor just create and return object.
        $constructReflector = $classReflector->getConstructor();

        if($constructReflector == null) return new $class();

        $args = $this->resolveParamsForFunc($constructReflector, $constructorParams);

        // return instance with given params.
        return new $class(...$args);
    }

    public function invokeFunction(callable $function, array $params = []): mixed
    {
        $m = new ReflectionFunction($function);

        $params = $this->resolveParamsForFunc($m, $params);

        return $m->invoke(...$params);
    }

    public function addTransient(string $serviceClass, ?callable $factory = null): IServiceCollection
    {
        if(!empty($this->services[$serviceClass])){
            throw new ServiceConflictException("$serviceClass already defined.");
        }

        if($factory == null){
            $factory = fn() => $this->resolve($serviceClass);
        }

        $this->services[$serviceClass] = $factory;

        return $this;
    }

    public function addTransientForInterface(string $serviceInterface, string $serviceClass, ?callable $factory = null): IServiceCollection
    {
        if(!is_subclass_of($serviceClass, $serviceInterface)){
            throw new InvalidArgumentException("$serviceClass should implement $serviceInterface.");
        }

        if(!empty($this->services[$serviceInterface])){
            throw new ServiceConflictException("$serviceInterface already defined.");
        }

        if($factory == null){
            $factory = fn() => $this->resolve($serviceClass);
        }

        $this->services[$serviceInterface] = $factory;

        return $this;
    }

    public function addScoped(string $serviceClass, ?callable $factory = null): IServiceCollection
    {
        if(!empty($this->services[$serviceClass])){
            throw new ServiceConflictException("$serviceClass already defined.");
        }

        if($factory == null){
            $factory = fn() => $this->resolve($serviceClass);
        }

        // decorate that factory to return the same instance
        $decoratedFactory = fn()=> $this->resolvedServices[$serviceClass] ?? $this->resolvedServices[$serviceClass] = $factory();

        $this->services[$serviceClass] = $decoratedFactory;

        return $this;
    }

    public function addScopedForInterface(string $serviceInterface, string $serviceClass, ?callable $factory = null): IServiceCollection
    {
        if(!is_subclass_of($serviceClass, $serviceInterface)){
            throw new InvalidArgumentException("$serviceClass should implement $serviceInterface.");
        }

        if(empty($this->services[$serviceInterface]) === false){
            throw new ServiceConflictException("$serviceInterface already defined.");
        }

        if($factory == null){
            $factory = fn() => $this->resolve($serviceClass);
        }

        // decorate that factory to return the same instance
        $decoratedFactory = fn()=> $this->resolvedServices[$serviceInterface] ??
            $this->resolvedServices[$serviceInterface] = $factory();

        $this->services[$serviceInterface] = $decoratedFactory;

        return $this;
    }

    /**
     * @throws ServiceNotResolvedException
     */
    private function resolveParamsForFunc(?ReflectionFunctionAbstract $func, array $params = []): array{
        if($func === null)
            return [];

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
}