<?php

namespace Framework\middlewares\Routing;

use Exception;
use Framework\exceptions\RouteNotResolvedException;

class RouteNode{

    private $_callable;
    private array $_children;

    public function __construct(){
        $this->_callable = null;
        $this->_children = [];
    }

    /**
     * @throws RouteNotResolvedException
     */
    public function moveNext(string $token){
        if(array_key_exists($token, $this->_children)){
            return $this->_children[$token];
        }
        else{
            throw new RouteNotResolvedException();
        }
    }

    /**
     * @throws Exception
     */
    public function addChild(string $token, RouteNode $child): void{

        if(array_key_exists($token, $this->_children)){
            throw new Exception("This token already defined.");
        }
        else{
            $this->_children[$token] = $child;
        }
    }

    public function getCallable(){
        return $this->_callable;
    }
}