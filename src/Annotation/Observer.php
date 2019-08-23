<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace Hyperf\ModelListener;

use Hyperf\Di\Annotation\AbstractAnnotation;
use Hyperf\ModelListener\Collector\ObserverCollector;
use Hyperf\Utils\Arr;

/**
 * @Annotation
 * @Target({"CLASS"})
 */
class Observer extends AbstractAnnotation
{
    /**
     * @var array
     */
    public $models = [];

    public function __construct($value = null)
    {
        if (is_string($value)) {
            $this->models = [$value];
        } elseif (is_array($value) && ! Arr::isAssoc($value)) {
            $this->models = $value;
        } else {
            parent::__construct($value);
        }
    }

    public function collectClass(string $className): void
    {
        parent::collectClass($className);

        foreach ($this->models as $model) {
            ObserverCollector::register($model, $className);
        }
    }
}
