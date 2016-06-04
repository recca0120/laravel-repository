<?php

namespace Recca0120\Repository\Filters;

use Recca0120\Repository\Criteria;

abstract class Filter
{
    abstract protected function applyCriteria($model, $criteriaItem);

    /**
     * aookt.
     *
     * @method apply
     *
     * @param mixed $model
     * @param mixed $criteria
     *
     * @return $mixed
     */
    public function apply($model, $criteria)
    {
        if (empty($criteria) === true) {
            return $model;
        }

        if (is_array($criteria) === false) {
            $criteria = [$criteria];
        }

        foreach ($criteria as $key => $value) {
            $this->castToCriteria($value, $key)->each(function ($criteriaItem) use (&$model) {
                if (count($criteriaItem->parameters) === 0) {
                    return;
                }

                $method = sprintf('applyCriteria%s', ucfirst($criteriaItem->method));
                $method = method_exists($this, $method) ? $method : 'applyCriteria';
                $model = call_user_func_array([$this, $method], [$model, $criteriaItem]);
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
        call_user_func_array([$criteria, 'where'], $value);

        return $criteria;
    }
}
