<?php

namespace Paygreen\Sdk\Payment\V3\Request\Traits;

trait RequestTrait
{
    /**
     * @return int[]
     */
    protected function getDefaultPagination()
    {
        return [
            'max_per_page' => 20,
            'page' => 1
        ];
    }

    /**
     * @param $filters
     * @param $pagination
     * @return string
     */
    protected function getListParameters($filters = [], $pagination = []) {
        if ($filters === null) {
            $filters = [];
        }

        if (empty($pagination)) {
            $pagination = $this->getDefaultPagination();
        }

        return http_build_query(
            array_merge($filters, $pagination)
        );
    }
}