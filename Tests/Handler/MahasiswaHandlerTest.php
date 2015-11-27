<?php

namespace Ais\MatakuliahBundle\Tests\Handler;

use Ais\MatakuliahBundle\Handler\MatakuliahHandler;
use Ais\MatakuliahBundle\Model\MatakuliahInterface;
use Ais\MatakuliahBundle\Entity\Matakuliah;

class MatakuliahHandlerTest extends \PHPUnit_Framework_TestCase
{
    const DOSEN_CLASS = 'Ais\MatakuliahBundle\Tests\Handler\DummyMatakuliah';

    /** @var MatakuliahHandler */
    protected $matakuliahHandler;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $om;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $repository;

    public function setUp()
    {
        if (!interface_exists('Doctrine\Common\Persistence\ObjectManager')) {
            $this->markTestSkipped('Doctrine Common has to be installed for this test to run.');
        }
        
        $class = $this->getMock('Doctrine\Common\Persistence\Mapping\ClassMetadata');
        $this->om = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->repository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $this->formFactory = $this->getMock('Symfony\Component\Form\FormFactoryInterface');

        $this->om->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo(static::DOSEN_CLASS))
            ->will($this->returnValue($this->repository));
        $this->om->expects($this->any())
            ->method('getClassMetadata')
            ->with($this->equalTo(static::DOSEN_CLASS))
            ->will($this->returnValue($class));
        $class->expects($this->any())
            ->method('getName')
            ->will($this->returnValue(static::DOSEN_CLASS));
    }


    public function testGet()
    {
        $id = 1;
        $matakuliah = $this->getMatakuliah();
        $this->repository->expects($this->once())->method('find')
            ->with($this->equalTo($id))
            ->will($this->returnValue($matakuliah));

        $this->matakuliahHandler = $this->createMatakuliahHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);

        $this->matakuliahHandler->get($id);
    }

    public function testAll()
    {
        $offset = 1;
        $limit = 2;

        $matakuliahs = $this->getMatakuliahs(2);
        $this->repository->expects($this->once())->method('findBy')
            ->with(array(), null, $limit, $offset)
            ->will($this->returnValue($matakuliahs));

        $this->matakuliahHandler = $this->createMatakuliahHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);

        $all = $this->matakuliahHandler->all($limit, $offset);

        $this->assertEquals($matakuliahs, $all);
    }

    public function testPost()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('title' => $title, 'body' => $body);

        $matakuliah = $this->getMatakuliah();
        $matakuliah->setNama($title);
        $matakuliah->setNamaSingkat($body);

        $form = $this->getMock('Ais\MatakuliahBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $form->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($matakuliah));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->matakuliahHandler = $this->createMatakuliahHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);
        $matakuliahObject = $this->matakuliahHandler->post($parameters);

        $this->assertEquals($matakuliahObject, $matakuliah);
    }

    /**
     * @expectedException Ais\MatakuliahBundle\Exception\InvalidFormException
     */
    public function testPostShouldRaiseException()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('title' => $title, 'body' => $body);

        $matakuliah = $this->getMatakuliah();
        $matakuliah->setNama($title);
        $matakuliah->setNamaSingkat($body);

        $form = $this->getMock('Ais\MatakuliahBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(false));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->matakuliahHandler = $this->createMatakuliahHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);
        $this->matakuliahHandler->post($parameters);
    }

    public function testPut()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('title' => $title, 'body' => $body);

        $matakuliah = $this->getMatakuliah();
        $matakuliah->setNama($title);
        $matakuliah->setNamaSingkat($body);

        $form = $this->getMock('Ais\MatakuliahBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $form->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($matakuliah));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->matakuliahHandler = $this->createMatakuliahHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);
        $matakuliahObject = $this->matakuliahHandler->put($matakuliah, $parameters);

        $this->assertEquals($matakuliahObject, $matakuliah);
    }

    public function testPatch()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('body' => $body);

        $matakuliah = $this->getMatakuliah();
        $matakuliah->setNama($title);
        $matakuliah->setNamaSingkat($body);

        $form = $this->getMock('Ais\MatakuliahBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $form->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($matakuliah));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->matakuliahHandler = $this->createMatakuliahHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);
        $matakuliahObject = $this->matakuliahHandler->patch($matakuliah, $parameters);

        $this->assertEquals($matakuliahObject, $matakuliah);
    }


    protected function createMatakuliahHandler($objectManager, $matakuliahClass, $formFactory)
    {
        return new MatakuliahHandler($objectManager, $matakuliahClass, $formFactory);
    }

    protected function getMatakuliah()
    {
        $matakuliahClass = static::DOSEN_CLASS;

        return new $matakuliahClass();
    }

    protected function getMatakuliahs($maxMatakuliahs = 5)
    {
        $matakuliahs = array();
        for($i = 0; $i < $maxMatakuliahs; $i++) {
            $matakuliahs[] = $this->getMatakuliah();
        }

        return $matakuliahs;
    }
}

class DummyMatakuliah extends Matakuliah
{
}
