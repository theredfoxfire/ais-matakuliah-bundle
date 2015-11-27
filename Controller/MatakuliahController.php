<?php

namespace Ais\MatakuliahBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Request\ParamFetcherInterface;

use Symfony\Component\Form\FormTypeInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Ais\MatakuliahBundle\Exception\InvalidFormException;
use Ais\MatakuliahBundle\Form\MatakuliahType;
use Ais\MatakuliahBundle\Model\MatakuliahInterface;


class MatakuliahController extends FOSRestController
{
    /**
     * List all matakuliahs.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing matakuliahs.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many matakuliahs to return.")
     *
     * @Annotations\View(
     *  templateVar="matakuliahs"
     * )
     *
     * @param Request               $request      the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getMatakuliahsAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');

        return $this->container->get('ais_matakuliah.matakuliah.handler')->all($limit, $offset);
    }

    /**
     * Get single Matakuliah.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a Matakuliah for a given id",
     *   output = "Ais\MatakuliahBundle\Entity\Matakuliah",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the matakuliah is not found"
     *   }
     * )
     *
     * @Annotations\View(templateVar="matakuliah")
     *
     * @param int     $id      the matakuliah id
     *
     * @return array
     *
     * @throws NotFoundHttpException when matakuliah not exist
     */
    public function getMatakuliahAction($id)
    {
        $matakuliah = $this->getOr404($id);

        return $matakuliah;
    }

    /**
     * Presents the form to use to create a new matakuliah.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\View(
     *  templateVar = "form"
     * )
     *
     * @return FormTypeInterface
     */
    public function newMatakuliahAction()
    {
        return $this->createForm(new MatakuliahType());
    }
    
    /**
     * Presents the form to use to edit matakuliah.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AisMatakuliahBundle:Matakuliah:editMatakuliah.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the matakuliah id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when matakuliah not exist
     */
    public function editMatakuliahAction($id)
    {
		$matakuliah = $this->getMatakuliahAction($id);
		
        return array('form' => $this->createForm(new MatakuliahType(), $matakuliah), 'matakuliah' => $matakuliah);
    }

    /**
     * Create a Matakuliah from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new matakuliah from the submitted data.",
     *   input = "Ais\MatakuliahBundle\Form\MatakuliahType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AisMatakuliahBundle:Matakuliah:newMatakuliah.html.twig",
     *  statusCode = Codes::HTTP_BAD_REQUEST,
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postMatakuliahAction(Request $request)
    {
        try {
            $newMatakuliah = $this->container->get('ais_matakuliah.matakuliah.handler')->post(
                $request->request->all()
            );

            $routeOptions = array(
                'id' => $newMatakuliah->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_matakuliah', $routeOptions, Codes::HTTP_CREATED);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Update existing matakuliah from the submitted data or create a new matakuliah at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "Ais\MatakuliahBundle\Form\MatakuliahType",
     *   statusCodes = {
     *     201 = "Returned when the Matakuliah is created",
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AisMatakuliahBundle:Matakuliah:editMatakuliah.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the matakuliah id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when matakuliah not exist
     */
    public function putMatakuliahAction(Request $request, $id)
    {
        try {
            if (!($matakuliah = $this->container->get('ais_matakuliah.matakuliah.handler')->get($id))) {
                $statusCode = Codes::HTTP_CREATED;
                $matakuliah = $this->container->get('ais_matakuliah.matakuliah.handler')->post(
                    $request->request->all()
                );
            } else {
                $statusCode = Codes::HTTP_NO_CONTENT;
                $matakuliah = $this->container->get('ais_matakuliah.matakuliah.handler')->put(
                    $matakuliah,
                    $request->request->all()
                );
            }

            $routeOptions = array(
                'id' => $matakuliah->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_matakuliah', $routeOptions, $statusCode);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Update existing matakuliah from the submitted data or create a new matakuliah at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "Ais\MatakuliahBundle\Form\MatakuliahType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AisMatakuliahBundle:Matakuliah:editMatakuliah.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the matakuliah id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when matakuliah not exist
     */
    public function patchMatakuliahAction(Request $request, $id)
    {
        try {
            $matakuliah = $this->container->get('ais_matakuliah.matakuliah.handler')->patch(
                $this->getOr404($id),
                $request->request->all()
            );

            $routeOptions = array(
                'id' => $matakuliah->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_matakuliah', $routeOptions, Codes::HTTP_NO_CONTENT);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Fetch a Matakuliah or throw an 404 Exception.
     *
     * @param mixed $id
     *
     * @return MatakuliahInterface
     *
     * @throws NotFoundHttpException
     */
    protected function getOr404($id)
    {
        if (!($matakuliah = $this->container->get('ais_matakuliah.matakuliah.handler')->get($id))) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.',$id));
        }

        return $matakuliah;
    }
    
    public function postUpdateMatakuliahAction(Request $request, $id)
    {
		try {
            $matakuliah = $this->container->get('ais_matakuliah.matakuliah.handler')->patch(
                $this->getOr404($id),
                $request->request->all()
            );

            $routeOptions = array(
                'id' => $matakuliah->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_matakuliah', $routeOptions, Codes::HTTP_NO_CONTENT);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
	}
}
