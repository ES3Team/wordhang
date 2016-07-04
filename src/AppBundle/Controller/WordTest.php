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

/**
 * Get all words (test purpose).
 *
 * @Route("/{_locale}/allWords", defaults={"_locale"="en"}, requirements = { "_locale" = "en|de" })
 */
class WordTest extends Controller
{
    /**
     * @Route("/", name="allWords")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Word')->findAll();
        $response = new Response(json_encode(array($entities)));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
