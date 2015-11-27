<?php

namespace Ais\MatakuliahBundle\Tests\Fixtures\Entity;

use Ais\MatakuliahBundle\Entity\Matakuliah;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class LoadMatakuliahData implements FixtureInterface
{
    static public $matakuliahs = array();

    public function load(ObjectManager $manager)
    {
        $matakuliah = new Matakuliah();
        $matakuliah->setNama('title');
        $matakuliah->setNamaSingkat('body');

        $manager->persist($matakuliah);
        $manager->flush();

        self::$matakuliahs[] = $matakuliah;
    }
}
