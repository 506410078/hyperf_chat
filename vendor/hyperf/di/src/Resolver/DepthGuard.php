<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace Hyperf\Di\Resolver;

use Hyperf\Di\Exception\CircularDependencyException;
use Hyperf\Utils\Context;

/**
 * Class DepthGuard aborts the resolver after
 * reaching a predefined depth limit. This is
 * useful to detect circular dependencies.
 */
class DepthGuard
{
    /**
     * @var int
     */
    protected $depthLimit = 500;

    /**
     * @var DepthGuard
     */
    private static $instance;

    public static function getInstance()
    {
        if (! isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * Allows user to adjust depth limit.
     * Should call it before di container bootstraps.
     */
    public function setDepthLimit(int $depthLimit)
    {
        $this->depthLimit = $depthLimit;
    }

    public function increment()
    {
        Context::override('di.depth', function ($depth) {
            $depth = $depth ?? 0;
            if (++$depth > $this->depthLimit) {
                throw new CircularDependencyException();
            }
            return $depth;
        });
    }

    public function decrement()
    {
        Context::override('di.depth', function ($depth) {
            return --$depth;
        });
    }

    public function call(string $name, callable $callable)
    {
        $guard = DepthGuard::getInstance();

        try {
            $this->increment();
            $result = $callable();
        } catch (CircularDependencyException $exception) {
            $exception->addDefinitionName($name);
            throw $exception;
        } finally {
            $guard->decrement();
        }

        return $result;
    }
}
