<?php

namespace Framework\dependency;

use Framework\exceptions\ServiceNotResolvedException;

interface IServiceCollection
{
    /**
     * @throws ServiceNotResolvedException
     */
    public function GetService($serviceInterface): object;

    public function Resolve($class, $constructorParams=[]);

    /**
     * Bind class to the interface, each time when service requested by interface will be created new object.
     *
     * @param $serviceInterface
     * @param $serviceClass
     * @return void
     */
    public function AddTransient($serviceInterface, $serviceClass): void;

    /**
     * Bind class to the interface, creates only one instance during the execution.
     *
     * @param $serviceInterface
     * @param $serviceClass
     * @return void
     */
    public function AddScoped($serviceInterface, $serviceClass): void;

}