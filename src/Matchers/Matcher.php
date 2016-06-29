<?php

namespace Recca0120\Repository\Matchers;

use Recca0120\Repository\Criteria;

abstract class Matcher
{
    abstract protected function applyCriteria($model, $criteriaItem);

    /**
     * aookt.
     *
     * @method apply
     *
     * @param mixed $model
     * @param mixed $items
     *
     * @return $mixed
     */
    public function apply($model, $criteria)
    {
        if (empty($criteria) === true) {
            return $model;
        }

        $criteria = (is_array($criteria) === false) ? [$criteria] : $criteria;
        foreach ($criteria as $key => $value) {
            $this->castToCriteria($value, $key)->each(function ($action) use (&$model) {
                $method = sprintf('applyCriteria%s', ucfirst($action->method));
                $method = method_exists($this, $method) ? $method : 'applyCriteria';
                $model = call_user_func_array([$this, $method], [$model, $action]);
            });
        }

        return $model;
    }

    public function castToCriteria($value, $key)
    {
        if ($value instanceof Criteria) {
            return $value;
        }
        $criteria = new Criteria();
        $value = is_array($value) === true ? $value : [$key, $value];

        return call_user_func_array([$criteria, 'where'], $value);
    }
}
