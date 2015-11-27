<?php

namespace Ais\MatakuliahBundle\Handler;

use Ais\MatakuliahBundle\Model\MatakuliahInterface;

interface MatakuliahHandlerInterface
{
    /**
     * Get a Matakuliah given the identifier
     *
     * @api
     *
     * @param mixed $id
     *
     * @return MatakuliahInterface
     */
    public function get($id);

    /**
     * Get a list of Matakuliahs.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0);

    /**
     * Post Matakuliah, creates a new Matakuliah.
     *
     * @api
     *
     * @param array $parameters
     *
     * @return MatakuliahInterface
     */
    public function post(array $parameters);

    /**
     * Edit a Matakuliah.
     *
     * @api
     *
     * @param MatakuliahInterface   $matakuliah
     * @param array           $parameters
     *
     * @return MatakuliahInterface
     */
    public function put(MatakuliahInterface $matakuliah, array $parameters);

    /**
     * Partially update a Matakuliah.
     *
     * @api
     *
     * @param MatakuliahInterface   $matakuliah
     * @param array           $parameters
     *
     * @return MatakuliahInterface
     */
    public function patch(MatakuliahInterface $matakuliah, array $parameters);
}
