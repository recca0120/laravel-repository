<?php

namespace Recca0120\Repository\Tranforms;

use Recca0120\Repository\Criteria;
use Recca0120\Repository\Traits\Collection as CollectionTrait;

abstract class Tranform
{
    use CollectionTrait;

    /**
     * $model.
     *
     * @var mixed
     */
    protected $model;

    /**
     * __construct.
     *
     * @method __construct
     *
     * @param mixed $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * push.
     *
     * @method push
     *
     * @param \Recca0120\Repository\Criteria $criteria
     *
     * @return self
     */
    public function push(Criteria $criteria)
    {
        $this->items[] = $criteria;

        return $this;
    }

    /**
     * apply.
     *
     * @method apply
     *
     * @return mixed $model
     */
    public function apply()
    {
        $model = clone $this->model;
        $allowTypes = [];
        foreach ($this->items as $criteria) {
            foreach ($criteria->all() as $action) {
                $allowTypes[$action->type][] = [
                    'method'     => $action->method,
                    'parameters' => $this->transformParameters($action->parameters),
                ];
            }
        }

        foreach ($allowTypes as $type => $actions) {
            $method = (method_exists($this, $type) === true) ?
                $type : 'defaults';

            $model = call_user_func_array([$this, $method], [$model, $actions]);
        }

        return $model;
    }

    /**
     * defaults apply.
     *
     * @method defaults
     *
     * @param mixed $model
     * @param array $actions
     *
     * @return mixed
     */
    public function defaults($model, $actions)
    {
        foreach ($actions as $action) {
            $model = call_user_func_array([$model, $action['method']], $action['parameters']);
        }

        return $model;
    }

    /**
     * transformParameters.
     *
     * @method transformParameters
     *
     * @param array $parameters
     *
     * @return array
     */
    abstract protected function transformParameters($parameters);
}
