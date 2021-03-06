<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        $books = $this->getDoctrine()->getRepository('App:Book')->findLast(2);
        return $this->render('default/index.html.twig', ['books' => $books]);
    }
}
