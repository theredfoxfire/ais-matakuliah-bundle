<?php
/**
 * interface in order to mock forminteraface waiting https://github.com/sebastianbergmann/phpunit-mock-objects/issues/103
 */
namespace  Ais\MatakuliahBundle\Tests;

interface FormInterface extends \Iterator, \Symfony\Component\Form\FormInterface
{
}
