<?php

namespace Framework\dependency;

use Framework\exceptions\ServiceNotResolvedException;

interface IServiceCollection
{
    /**
     * @throws ServiceNotResolvedException
     */
    public function getService($serviceInterface): mixed;

    public function resolve($class, $constructorParams=[]): mixed;

    /**
     * Bind class to the interface, creates only one instance during the execution.
     *
     * @param $serviceInterface
     * @param $serviceClass
     * @return void
     */
    public function addScoped(string $serviceInterface, string $serviceClass): IServiceCollection;

    public function addSingleton(string $serviceInterface, $serviceInstance): IServiceCollection;

    public function invokeFunction(callable $function): mixed;
}