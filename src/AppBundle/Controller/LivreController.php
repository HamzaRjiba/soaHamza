<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Livre;
use AppBundle\Entity\auteur;

class LivreController extends FOSRestController
{
    
    /**
    * @Rest\Get("/books/")
    */
    public function getAction()
    {
        $result = $this->getDoctrine()->getRepository(Livre::class)->findAll();
        if ($result === null)
            return new View("there are no books", Response::HTTP_NOT_FOUND);
            return $result;
    }
    /**
    * @Rest\Get("/books/titre={s}")
    */

    public function getActionBytitre($s)
    {
        //Tous les livres dont le titre contient une chaîne passée en paramètre
        
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository(Livre::class)
            ->createQueryBuilder('b')
            ->where('b.titre LIKE :titre')
            ->setParameter('titre', '%' . $s . '%')
            ->getQuery()
            ->getResult();
        //$result = $this->getDoctrine()->getRepository(Livre::class)->findByAuteur($s);
        if ($result === null)
            return new View("there are no books", Response::HTTP_NOT_FOUND);
            return $result;
    }
    /**
    * @Rest\Get("/books/titre={s}/order")
    */

    public function getActionBytitreDesc($s)
    {
//Tous les livres dont le titre contient une chaîne passée en paramètre et
//triés par ordre alphabétique décroissant.        
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository(Livre::class)
            ->createQueryBuilder('b')
            ->where('b.titre LIKE :titre')
            ->orderBy('b.titre', 'DESC')
            ->setParameter('titre', '%' . $s . '%')
            ->getQuery()
            ->getResult();
        //$result = $this->getDoctrine()->getRepository(Livre::class)->findByAuteur($s);
        if ($result === null)
            return new View("there are no books", Response::HTTP_NOT_FOUND);
            return $result;
    }
    /**
    * @Rest\Get("/books/auteur={s}")
    */
    public function getActionByAuteur($s)
    {
        //Tous les livres d’un auteur donné
        $auteur = $this->getDoctrine()->getRepository(auteur::class)->findOneByNomPrenom($s);
        $id=$auteur->getIdAuteur();
        $result = $this->getDoctrine()->getRepository(Livre::class)->findByAuteur($id);

        if ($result === null)
            return new View("there are no books", Response::HTTP_NOT_FOUND);
            return $auteur;
    }
     /**
    * @Rest\Get("/books/{id}")
    */
    public function getBookByid($id)
    {
        //Détail d’un livre donné
        $result = $this->getDoctrine()->getRepository(Livre::class)->findById($id);
        if ($result === null)
            return new View("there are no books", Response::HTTP_NOT_FOUND);
            return $result;
    }


    
     /**
     * @Rest\Post("/books/create")
    */
    public function addBook(Request $request)
    {
    //Ajout d’un nouveau livre
      $titre= $request->get('titre');
      $descriptif= $request->get('descriptif');
      $isbn= $request->get('isbn');
      

      
      if(empty($titre))
      {
        return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
      }
      $data = new Livre();
      $data->setTitre($titre);
      $data->setDescriptif($descriptif);
      $data->setIsbn($isbn);
      $data->setDispo(true);
      $data->setDate(new \DateTime());
      $em = $this->getDoctrine()->getManager();
      $em->persist($data);
      $em->flush();
        return new View("Book Added Successfully", Response::HTTP_CREATED);
    } 
    /**
    * @Rest\Patch("/books/edit/{id}")
    */
    public function editBookByid(Request $request,$id)
    {
        //modifcation d'un livre par id
      $titre= $request->get('titre');
      $descriptif= $request->get('descriptif');
      $isbn= $request->get('isbn');
 
    
        $data = $this->getDoctrine()->getRepository(Livre::class)->find($id);
        if ($data === null)
            return new View("there are no books", Response::HTTP_NOT_FOUND);
            if(empty($titre))
            {
              return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
            }
            
            $data->setTitre($titre);
            $data->setDescriptif($descriptif);
            $data->setIsbn($isbn);
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();
              return new View("Book edited Successfully", Response::HTTP_CREATED);
        
    }
            /**
             * @Rest\Delete("books/remove/{id}")
            */
            public function removeBook(Request $request,$id)
            {
            //supprimer un livre
            $data = $this->getDoctrine()->getRepository(Livre::class)->find($id);
            if(empty($data))
            {
                return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_FOUND);
            }
            $em = $this->getDoctrine()->getManager();
            $em->remove($data);
            $em->flush();
                return new View("Book removed Successfully", Response::HTTP_CREATED);
            } 
    /**
    * @Rest\Patch("/books/activer/{id}")
    */
    public function Activerlivre(Request $request,$id)
    {
       //activer livre
 
    
        $data = $this->getDoctrine()->getRepository(Livre::class)->find($id);
        if ($data === null)
            return new View("there are no books", Response::HTTP_NOT_FOUND);
            
            
            $data->setDispo(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();
              return new View("Book enabled", Response::HTTP_CREATED);
        
    }
    /**
    * @Rest\Patch("/books/desactiver/{id}")
    */
    public function Desactiverlivre(Request $request,$id)
    {
       //desactiver livre
 
    
        $data = $this->getDoctrine()->getRepository(Livre::class)->find($id);
        if ($data === null)
            return new View("there are no books", Response::HTTP_NOT_FOUND);
            
            
            $data->setDispo(false);
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();
              return new View("Book disabled", Response::HTTP_CREATED);
        
    }

            
    
}
