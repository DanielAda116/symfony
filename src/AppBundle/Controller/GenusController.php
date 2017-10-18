<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 11.10.2017
 * Time: 14:00
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Genus;
use AppBundle\Entity\GenusNote;
use AppBundle\Repository\GenusRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class GenusController extends Controller
{

    /**
     * @Route("/genus/new")
     */
    public function newAction(){

        $genus = new Genus();
        $genus->setName('Octoups'.rand(1, 100));
        $genus->setSubFamily('Octoprontus');
        $genus->setSpeciesCount(rand(100,31231));

        $note = new GenusNote();
        $note->setUsername('AquaWeaver');
        $note->setUserAvatarFilename('ryan.jpeg');
        $note->setNote('I counted 8 legs... as they wrapped around me');
        $note->setCreatedAt(new \DateTime('-1 month'));
        $note->setGenus($genus);

        $em = $this->getDoctrine()->getManager();
        $em->persist($genus);
        $em->persist($note);
        $em->flush();

        return new Response('<html><body>Genus '.$genus->getName().' created!</body></html>');
    }

    /**
     * @Route("/genus")
     */
    public function listAction(){

        $em = $this->getDoctrine()->getManager();

        dump($em->getRepository('AppBundle:Genus'));

        /** @var GenusRepository $genusesRepo */
        $genusesRepo = $em->getRepository('AppBundle:Genus');
        $genuses = $genusesRepo->findAllPublishedOrderedBySize();

        return $this->render('genus/list.html.twig', [
           'genuses' => $genuses
        ]);
    }

    /**
     * @Route("/genus/{genusName}", name="genus_show")
     */
    public function showAction($genusName){

        $em= $this->getDoctrine()->getManager();

        $genus = $em->getRepository('AppBundle:Genus')->findOneBy(['name' => $genusName]);

        if(!$genus){
            throw $this->createNotFoundException('Genus not found');
        }

        return $this->render('genus/show.html.twig', array(
            'genus' => $genus
        ));
    }

    /**
     * @Route("/genus/{name}/notes", name="genus_show_notes")
     * @Method("GET")
     */
    public function getNotesAction($genusName)
    {
        $em = $this->getDoctrine()->getManager();


    }


}