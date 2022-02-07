<?php

namespace app\core\form;

use app\core\Model;

abstract class BaseField
{

    public function __construct(
        public Model  $model,
        public string $attribute,
    )
    {
    }

    public function __toString()
    {
        return sprintf('
             <div class="mt-3">
                  <label class="form-label">%s</label>
                  %s
                  <div class="invalid-feedback">%s</div>
              </div>
     ',
            $this->model->getLabel($this->attribute),
            $this->renderInput(),
            $this->model->getFirstError($this->attribute)
        );
    }

    abstract public function renderInput():string;
}