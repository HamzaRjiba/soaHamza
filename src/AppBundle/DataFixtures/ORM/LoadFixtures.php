<?php
namespace AppBundle\DataFixtures\ORM;
use AppBundle\Entity\Livre;
use AppBundle\Entity\auteur;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
class LoadFixtures implements FixtureInterface
{
    public function load(ObjectManager $em)
    {
        $data = new Livre();
        $data->setTitre('php'.rand(1, 100));
        $data->setDescriptif('test'.rand(100, 99999));
        $data->setIsbn('i'.rand(100, 99999));
        $data->setDispo(true);
        $data->setDate(new \DateTime());
        $data1 = new Livre();
        $data1->setTitre('php'.rand(1, 100));
        $data1->setDescriptif('test'.rand(100, 99999));
        $data1->setIsbn('i'.rand(100, 99999));
        $data1->setDispo(true);
        $data1->setDate(new \DateTime());
        $auteur=new auteur();
        $auteur->setNomPrenom('Hamza rjiba'.rand(1, 100));
        $auteur->setEmail('test'.rand(100, 99999).'@gmail.com');
        $auteur1=new auteur();
        $auteur1->setNomPrenom('Hamza rjiba'.rand(1, 100));
        $auteur1->setEmail('test'.rand(100, 99999).'@gmail.com');
        $em->persist($data);
        $em->persist($data1);
        $em->persist($auteur);
        $em->persist($auteur1);
        $em->flush();
        

    }

}