<?php

namespace App\Contracts;

interface AttributeContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listAttributes(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @return mixed
     */
    public function findAttributeById(int $id);

    /**
     * @return mixed
     */
    public function createAttribute(array $params);

    /**
     * @return mixed
     */
    public function updateAttribute(array $params);

    /**
     * @return bool
     */
    public function deleteAttribute($id);

}