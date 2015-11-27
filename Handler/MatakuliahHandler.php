<?php

namespace Ais\MatakuliahBundle\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use Ais\MatakuliahBundle\Model\MatakuliahInterface;
use Ais\MatakuliahBundle\Form\MatakuliahType;
use Ais\MatakuliahBundle\Exception\InvalidFormException;

class MatakuliahHandler implements MatakuliahHandlerInterface
{
    private $om;
    private $entityClass;
    private $repository;
    private $formFactory;

    public function __construct(ObjectManager $om, $entityClass, FormFactoryInterface $formFactory)
    {
        $this->om = $om;
        $this->entityClass = $entityClass;
        $this->repository = $this->om->getRepository($this->entityClass);
        $this->formFactory = $formFactory;
    }

    /**
     * Get a Matakuliah.
     *
     * @param mixed $id
     *
     * @return MatakuliahInterface
     */
    public function get($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Get a list of Matakuliahs.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0)
    {
        return $this->repository->findBy(array(), null, $limit, $offset);
    }

    /**
     * Create a new Matakuliah.
     *
     * @param array $parameters
     *
     * @return MatakuliahInterface
     */
    public function post(array $parameters)
    {
        $matakuliah = $this->createMatakuliah();

        return $this->processForm($matakuliah, $parameters, 'POST');
    }

    /**
     * Edit a Matakuliah.
     *
     * @param MatakuliahInterface $matakuliah
     * @param array         $parameters
     *
     * @return MatakuliahInterface
     */
    public function put(MatakuliahInterface $matakuliah, array $parameters)
    {
        return $this->processForm($matakuliah, $parameters, 'PUT');
    }

    /**
     * Partially update a Matakuliah.
     *
     * @param MatakuliahInterface $matakuliah
     * @param array         $parameters
     *
     * @return MatakuliahInterface
     */
    public function patch(MatakuliahInterface $matakuliah, array $parameters)
    {
        return $this->processForm($matakuliah, $parameters, 'PATCH');
    }

    /**
     * Processes the form.
     *
     * @param MatakuliahInterface $matakuliah
     * @param array         $parameters
     * @param String        $method
     *
     * @return MatakuliahInterface
     *
     * @throws \Ais\MatakuliahBundle\Exception\InvalidFormException
     */
    private function processForm(MatakuliahInterface $matakuliah, array $parameters, $method = "PUT")
    {
        $form = $this->formFactory->create(new MatakuliahType(), $matakuliah, array('method' => $method));
        $form->submit($parameters, 'PATCH' !== $method);
        if ($form->isValid()) {

            $matakuliah = $form->getData();
            $this->om->persist($matakuliah);
            $this->om->flush($matakuliah);

            return $matakuliah;
        }

        throw new InvalidFormException('Invalid submitted data', $form);
    }

    private function createMatakuliah()
    {
        return new $this->entityClass();
    }

}
