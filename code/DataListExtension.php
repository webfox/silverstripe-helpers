<?php

/**
 * Class DataListExtension
 *
 * @property DataList owner
 */
class DataListExtension extends Extension
{

    public function ListColumn($column, $glue = ', ')
    {
        return implode($glue, $this->owner->column($column));
    }

    public function Displayed($visible = true)
    {
        $list = clone $this->owner;

        return $list->filter('Displayed', $visible);
    }

    public function OnlyVisible()
    {
        return $this->Displayed(true);
    }

    public function OnlyHidden()
    {
        return $this->Displayed(false);
    }

    public function WithVisible($relation)
    {
        $list = clone $this->owner;

        return $list->filterByCallback(function ($obj) use ($relation) {
            return $obj->{$relation}()->OnlyVisible()->exists();
        });
    }

}
