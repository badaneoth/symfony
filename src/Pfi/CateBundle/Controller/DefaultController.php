<?php

namespace Pfi\CateBundle\Controller;
use Pfi\CateBundle\Entity\Acteur;
use Pfi\CateBundle\Entity\commmentaire;
use Pfi\CateBundle\Entity\Film;
use Pfi\CateBundle\Entity\image;
use Pfi\CateBundle\Entity\Categorie;

use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Pfi\CateBundle\Entity\FilmForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Pfi\CateBundle\Form\ActeurForm;
use Pfi\CateBundle\Form\ActeurRechercheForm;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\FormBuilderInterface;

class DefaultController extends Controller
{


    /**
     * @Route("/index/")
     * @Template()
     */
    public function indexAction()
    {
       $films=$this->getDoctrine()->getRepository("PfiCateBundle:Film")->findAll();

        return $this->render('PfiCateBundle:Default:index.html.twig', array('films' => $films));
   }

    /**
     * @Route("register/lister/{id}",name="list")
     * @Template()
     */

    public function listerAction($id)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $films= $em->getRepository("PfiCateBundle:Film")->find($id);

        $images = new ArrayCollection();

        //foreach( $films as $f){
          $images = new ArrayCollection( array_merge($images->toArray(), $films->getImage()->toArray()) );
       // }

        // var_dump($images);die();


        return $this->container->get('templating')->renderResponse('PfiCateBundle:Default:lister.html.twig', array(
            'films' => $films,'images'=>$images

        ));
    }


















    /**
     * @Route("/listFilms",name="liste")
     * @Template()
     */


    public function listFilmsAction()
    {
       $films=$this->getDoctrine()->getRepository("PfiCateBundle:Film")->findAll();

        return $this->render('PfiCateBundle:Default:index.html.twig', array('films' => $films));
       // return array('films' => $films);
    }




    /**
     * @Route("/admin/formFilm")
     * @Template()
     */
    public function formFilmAction(Request $request )
    {
        $f=new Film();
        $form=$this->createFormBuilder($f)
            ->add('nom','text')
            ->add('info','date')
            ->add('resume','textarea')

            ->add('save',      'submit')
            ->getForm();
        $form->handleRequest($request);
        if($form->isValid()){

            $em=$this->getDoctrine()->getManager();
            $em->persist($f);
            $em->flush();
          return   $this->redirect($this->generateUrl("liste"));
        }
        return array('f' => $form->createView());
    }





     /**
     * @Route("/affichecomm,{id}",name="list")
     * @Template()
     */

    public function affichecommAction($id)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $films= $em->getRepository("PfiCateBundle:Film")->find($id);

    $images = new ArrayCollection();

    //foreach( $films as $f){
      $images = new ArrayCollection( array_merge($images->toArray(), $films->getImage()->toArray()) );


        $comm = $em->getRepository("PfiCateBundle:commmentaire")->findAll();
        return $this->render('PfiCateBundle:Default:affichecomm.html.twig', array('comm' => $comm,'films' => $films,'images'=>$images));
    }




    /**
     * @Route("/comment,{id}")
     * @Template()
     */
    public function commentAction(Request $request,$id )
    {
        $f=new commmentaire();
        $form=$this->createFormBuilder($f)

            ->add('comment','textarea')

            ->add('commenter',      'submit')
            ->getForm();
        $form->handleRequest($request);
        if($form->isValid()){

            $em=$this->getDoctrine()->getManager();
            $em->persist($f);
            $em->flush();
            return   $this->affichecommAction($id);
        }
        return array('f' => $form->createView());
    }











    /**
     * @Route("/presentation/{id}")
     * @Template()
     */
    public function presentationAction($id)
    {
        $film=$this->getDoctrine()->getRepository("PfiCateBundle:Film")->find($id);

        return $this->render('PfiCateBundle:Default:presentation.html.twig', array('film' => $film));
    }






    /**
     * @Route("/affichefavoris/{id}")
     * @Template()
     */

    public function affichefavorisAction($id)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $fav = $em->find("PfiCateBundle:Film", $id);




 $images = new ArrayCollection();

 //foreach( $films as $f){
   $images = new ArrayCollection( array_merge($images->toArray(), $fav->getImage()->toArray()) );
        return $this->render('PfiCateBundle:Default:affichefavoris.html.twig', array('fav' => $fav,'images'=>$images));
    }



    /**
     * @Route("/addFilmfav/{id}")
     * @Template()
     */
    public function addFilmFavAction($id)
    {
       $em = $this->container->get('doctrine')->getEntityManager();
       $films = $em->find("PfiCateBundle:Film", $id);

       if (!$films)
       {
           throw new NotFoundHttpException("Film non trouvé");
       }

     $em->flush();




       return $this->affichefavorisAction($id);


                }






    /**
     * @Route("/supprimer/{id}")
     * @Template()
     */


    public function supprimerAction($id)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $films = $em->find("PfiCateBundle:Film", $id);

        if (!$films)
        {
            throw new NotFoundHttpException("Film non trouvé");
        }

        $em->remove($films);
        $em->flush();


   //  return   new RedirectResponse($this->container->get('router')->generate('myapp_film_lister'));
        //return new RedirectResponse($this->container->get('router')->generate('myapp_film_lister'));
        return $this->listrAction();


    }

    /**
     * @Route("acteur/editer/{id}")
     * @Template()
     */

    public function editerAction($id = null)
    {
        $message='';
        $em = $this->container->get('doctrine')->getEntityManager();

        if (isset($id))
        {
            // modification d’un acteur existant : on recherche ses données
            $acteur = $em->find('PfiCateBundle:Acteur', $id);

            if (!$acteur)
            {
                $message='Aucun acteur trouvé';
            }
        }
        else
        {
            // ajout d’un nouvel acteur
            $acteur = new Acteur();
        }

        $form = $this->container->get('form.factory')->create(new ActeurForm(), $acteur);

        $request = $this->container->get('request');

        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);

            if ($form->isValid())
            {
                $em->persist($acteur);
                $em->flush();
                if (isset($id))
                {
                    $message='Acteur modifié avec succès !';
                }
                else
                {
                    $message='Acteur ajouté avec succès !';
                }
            }
        }

        return $this->container->get('templating')->renderResponse(
            'PfiCateBundle:Acteur:editer.html.twig',
            array(
                'form' => $form->createView(),
                'message' => $message,
            )
        );
    }

    /**
     * @Route("acteur/listerr")
     * @Template()
     */


    public function listerrAction()
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $acteurs= $em->getRepository('PfiCateBundle:Acteur')->findAll();

        $form = $this->container->get('form.factory')->create(new ActeurRechercheForm());

        return $this->container->get('templating')->renderResponse('PfiCateBundle:Acteur:listerr.html.twig', array(
            'acteurs' => $acteurs,
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("acteur/rechercher")
     * @Template()
     */
    public function rechercherAction()
    {
        $request = $this->container->get('request');

        if($request->isXmlHttpRequest())
        {
            $motcle = '';
            $motcle = $request->request->get('motcle');

            $em = $this->container->get('doctrine')->getEntityManager();

            if($motcle != '')
            {
                $qb = $em->createQueryBuilder();

                $qb->select('a')
                    ->from('PfiCateBundle:Acteur', 'a')
                    ->where("a.nom LIKE :motcle OR a.prenom LIKE :motcle")
                    ->orderBy('a.nom', 'ASC')
                    ->setParameter('motcle', '%'.$motcle.'%');

                $query = $qb->getQuery();
                $acteurs = $query->getResult();
            }
            else {
                $acteurs = $em->getRepository('PfiCateBundle:Acteur')->findAll();
            }

            return $this->container->get('templating')->renderResponse('PfiCateBundle:Acteur:liste.html.twig', array(
                'acteurs' => $acteurs
            ));
        }
        else {
            return $this->listerrAction();
        }
    }


    /**
     * @Route("film/listerf")
     * @Template()
     */


    public function listerfAction()
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $acteurs= $em->getRepository('PfiCateBundle:Film')->findAll();

        $form = $this->container->get('form.factory')->create(new ActeurRechercheForm());

        return $this->container->get('templating')->renderResponse('PfiCateBundle:Default:listerf.html.twig', array(
            'acteurs' => $acteurs,
            'form' => $form->createView()
        ));
    }



    /**
     * @Route("film/rechercherf")
     * @Template()
     */
    public function rechercherfAction()
    {
        $request = $this->container->get('request');

        if($request->isXmlHttpRequest())
        {
            $motcle = '';
            $motcle = $request->request->get('motcle');

            $em = $this->container->get('doctrine')->getEntityManager();

            if($motcle != '')
            {
                $qb = $em->createQueryBuilder();

                $qb->select('a')
                    ->from('PfiCateBundle:Film', 'a')
                    ->where("a.nom LIKE :motcle OR a.nom LIKE :motcle")
                    ->orderBy('a.nom', 'ASC')
                    ->setParameter('motcle', '%'.$motcle.'%');

                $query = $qb->getQuery();
                $acteurs = $query->getResult();
            }
            else {
                $acteurs = $em->getRepository('PfiCateBundle:Film')->findAll();
            }

            return $this->container->get('templating')->renderResponse('PfiCateBundle:Default:listef.html.twig', array(
                'acteurs' => $acteurs
            ));
        }
        else {
            return $this->listerfAction();
        }
    }


}