<?php

namespace Apex\Core\Container;

class Container
{
    protected array $bindings = [];
    protected array $singletons = [];
    protected array $instances = [];

    public function bind(string $abstract, string|\Closure $concrete): void
    {
        $this->bindings[$abstract] = $concrete;
    }

    public function has(string $abstract): bool
    {
        return isset($this->bindings[$abstract]) ||
            isset($this->singletons[$abstract]) ||
            isset($this->instances[$abstract]) ||
            class_exists($abstract);
    }

    public function bound(string $abstract): bool
    {
        return $this->has($abstract);
    }

    public function getBindings(): array
    {
        return $this->bindings;
    }

    public function instance(string $abstract, mixed $instance): void
    {
        $this->instances[$abstract] = $instance;
    }

    public function singleton(string $abstract, string|\Closure $concrete): void
    {
        $this->singletons[$abstract] = $concrete;
    }

    /**
     * @throws \ReflectionException
     */
    public function make(string $abstract): object
    {
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        if (isset($this->singletons[$abstract])) {
            $object = $this->resolveConcrete($this->singletons[$abstract]);
            $this->instances[$abstract] = $object;
            return $object;
        }

        $concrete = $this->bindings[$abstract] ?? $abstract;
        return $this->resolveConcrete($concrete);
    }

    /**
     * @throws \ReflectionException
     */
    private function resolveConcrete(string|\Closure $concrete): object
    {
        return $concrete instanceof \Closure
            ? $concrete($this)
            : $this->build($concrete);
    }

    /**
     * @throws \ReflectionException
     */
    protected function build(string $classname): null|object|string
    {
        $reflection = new \ReflectionClass($classname);

        if (!$reflection->isInstantiable()) {
            throw new \InvalidArgumentException("Class $classname is not instantiable");
        }

        $constructor = $reflection->getConstructor();

        if (is_null($constructor)) {
            return new $classname;
        }

        $parameters = $constructor->getParameters();
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $type = $parameter->getType();

            if (!$type || $type->isBuiltin()) {
                throw new \Exception("Unable to resolve parameter $parameter->name of class $classname");
            }

            $dependencyClassName = $type->getName();

            $dependencies[$dependencyClassName] = $this->make($dependencyClassName);
        }

        return $reflection->newInstanceArgs($dependencies);
    }
}