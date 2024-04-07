<?php

namespace Framework\dependency;

use Framework\exceptions\ServiceNotResolvedException;

interface IServiceCollection
{
    /**
     * @throws ServiceNotResolvedException
     */
    public function getService($serviceInterface): object;

    public function resolve($class, $constructorParams=[]);

//    /**
//     * Bind class to the interface, each time when service requested by interface will be created new object.
//     *
//     * @param $serviceInterface
//     * @param $serviceClass
//     * @return void
//     */
//    public function AddTransient($serviceInterface, $serviceClass): void;

    /**
     * Bind class to the interface, creates only one instance during the execution.
     *
     * @param $serviceInterface
     * @param $serviceClass
     * @return void
     */
    public function addScoped($serviceInterface, $serviceClass): void;

    public function addSingleton($serviceInterface, $serviceInstance): void;
}