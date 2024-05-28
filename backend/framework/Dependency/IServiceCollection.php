<?php

namespace Framework\Dependency;

use Closure;

interface IServiceCollection
{
    /**
     * @param string $serviceName
     * @return mixed
     */
    public function __get(string $serviceName): mixed;

    /**
     * @param string $serviceName
     * @return mixed
     */
    public function getService(string $serviceName): mixed;

    /**
     * Create instance of class using services inside collection and passed parameters.
     * Note, that passed parameters is preferred as constructor parameters
     *
     * @param string $class Class that should be resolved
     * @param array $constructorParams Additional parameters that are used in class construction
     * @return mixed - resolved class
     */
    public function resolve(string $class, array $constructorParams=[]): mixed;

    public function invokeFunction(callable $function, array $params = []): mixed;


    /**
     * Adds service to the collection, have transient lifetime.
     *
     * @param string $serviceClass
     * @param callable|null $factory factory for the object, if not specified, will be created by own using constructor
     * @return IServiceCollection
     */
    public function addTransient(string $serviceClass, ?callable $factory = null): IServiceCollection;

    /**
     * @param string $serviceInterface
     * @param string $serviceClass
     * @param callable|null $factory
     * @return IServiceCollection
     */
    public function addTransientForInterface(string $serviceInterface, string $serviceClass, ?callable $factory = null): IServiceCollection;

    public function addScoped(string $serviceClass, ?callable $factory = null): IServiceCollection;

    public function addScopedForInterface(string $serviceInterface, string $serviceClass, ?callable $factory = null): IServiceCollection;

}