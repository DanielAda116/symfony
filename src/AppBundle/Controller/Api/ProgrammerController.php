<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 12.10.2017
 * Time: 13:56
 */

namespace AppBundle\Controller\Api;


use AppBundle\Entity\Genus;
use AppBundle\Form\ProgrammerType;
use AppBundle\Form\UpdateProgrammerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProgrammerController extends Controller
{

    public function newAction(Request $request)
    {
        $data = json_decode($request->getContent(),true);

        $genus = new Genus();
        $form = $this->createForm(ProgrammerType::class, $genus);
        $this->processForm($request,$form);

        $genus->setName($data['name']);
        $genus->setSubFamily($data['subFamily']);
        $genus->setSpeciesCount($data['speciesCount']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($genus);
        $em->flush();

        $data = $this->serializeGenus($genus);
        $response = new Response(json_encode($data), 201);
        $genusUrl = $this->generateUrl(
            'programmer_show',
            ['name' => $genus->getName()]
        );

        $response->headers->set('Location', $genusUrl);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function showAction($name)
    {
        $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findOneBy(array('name' => $name));

       if(!$genus){
           throw $this->createNotFoundException(sprintf('No genus found with name "%s', $name));
        }

        $data = $this->serializeGenus($genus);

        return new JsonResponse($data);
    }

    public function listAction()
    {

        $genuses = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAll();
        $data = array('genuses' => array());
        foreach ($genuses as $genus){
            $data['genuses'][] = $this->serializeGenus($genus);
        }

        $response = new Response(json_encode($data), 200);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function updateAction($name, Request $request)
    {
        /** @var Genus $genus */
        $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findOneBy(array('name' => $name));

        if(!$genus){
            throw $this->createNotFoundException(sprintf('No genus found with name "%s', $name));
        }


        $form = $this->createForm(UpdateProgrammerType::class, $genus);
        $this-> processForm($request, $form);

        $em = $this->getDoctrine()->getManager();
        $em->persist($genus);
        $em->flush();

        $data = $this->serializeGenus($genus);
        $response = new JsonResponse($data,200);

        return $response;

    }

    public function deleteAction($name)
    {
        /** @var Genus $genus */
        $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findOneBy(array('name' => $name));

        if($genus){
            $em = $this->getDoctrine()->getManager();
            $em->remove($genus);
            $em->flush();

        }

        return new Response(null,204);
    }

    private function serializeGenus(Genus $genus)
    {
        return array(
            'name' => $genus->getName(),
            'subFamily' => $genus->getSubFamily(),
            'speciesCount' => $genus->getSubFamily(),
            'funFact' => $genus->getFunFact(),
        );
    }

    private function processForm(Request $request, FormInterface $form)
    {
        $data = json_encode($request->getContent(), true);

        $clearMissing = $request->getMethod() != 'PATCH';
        $form->submit($data, $clearMissing);
    }


}