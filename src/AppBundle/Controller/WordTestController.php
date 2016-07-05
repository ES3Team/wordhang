<?php
/**
 * Created by IntelliJ IDEA.
 * User: Guilherme
 * Date: 03/07/2016
 * Time: 21:53
 */
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Word;
use AppBundle\Form\WordType;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Get all words (test purpose).
 *
 * @Route("/{_locale}/allWords", defaults={"_locale"="en"}, requirements = { "_locale" = "en|de" })
 */
class WordTestController extends Controller
{
    /**
     * Word test.
     *
     * @Route("/", name="teste")
     * @Method("GET")
     * @Template()
     */
    public function getAllWordsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Word')->findAll();
        $serializer = new Serializer(
            array(new GetSetMethodNormalizer(), new ArrayDenormalizer()),
            array(new JsonEncoder())
        );
        $data = $serializer->serialize($entities, 'json');
        return new Response($data);
    }
}
