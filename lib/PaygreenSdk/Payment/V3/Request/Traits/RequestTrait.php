<?php

namespace Paygreen\Sdk\Payment\V3\Request\Traits;

trait RequestTrait
{
    /**
     * @return int[]
     */
    protected function getDefautlPagination()
    {
        return [
            'max_per_page' => 20,
            'page' => 1
        ];
    }
}