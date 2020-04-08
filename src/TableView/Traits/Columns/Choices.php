<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\TableView\Traits\Columns;

trait Choices
{

    protected $appendOptionsChoices = [];

    public function choices($choices, $expanded=false,$multiple=false, $choice_options=[])
    {
        $this->appendOptionsChoices['choices'] = $choices;

        $this->expanded($expanded);

        $this->type('choice');

        $this->multiple($multiple);

        $this->choice_options($choice_options);

        $this->propertyValue("selected");

        return $this;
    }

    public function expanded($expanded)
    {
        $this->appendOptionsChoices['expanded'] = $expanded;

        return $this;
    }

    public function multiple($multiple)
    {
        $this->appendOptionsChoices['multiple'] = $multiple;

        return $this;
    }

    public function choice_options($choice_options)
    {
        $this->appendOptionsChoices['choice_options'] = $choice_options;

        return $this;
    }
    public function selected($selected)
    {

        $this->appendOptionsChoices['selected'] = $selected;

        return $this;
    }

}
