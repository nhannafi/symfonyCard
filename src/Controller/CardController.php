<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
// Entities
use App\Entity\Card; use App\Form\CardType;
use  App\Entity\User; use App\Form\UserType;
use App\Entity\Category;use App\Form\CategoryType;
use App\Repository\CardRepository;

use Symfony\Component\OptionsResolver\OptionsResolver;

class CardController extends AbstractController
{
    public function index()
    {
        return $this->render('card/index.html.twig', [
            'controller_name' => 'CardController',
        ]);
    }

    
    /**
     * @Route("/card", name="card")
     */
    public function card(Request $request)
    {

        $em =$this->getDoctrine()->getManager();

        $card =  new Card();
        $formCard = $this->createForm(CardType::class, $card);
        $cards = $em ->getRepository(Card::class)->findAll();

        $formCard->handleRequest($request);

        if($formCard->isSubmitted()&& $formCard->isValid() ) {
            $card->setCreator($this->getUser());
            $image = $formCard->get('image')->getData();
            $imageName= 'card'.uniqid().'.'.$image-> guessExtension();
            $image->move(
                $this->getParameter('cards_folder'),
                $imageName
            );
            $card->setImage($imageName);

            $em->persist($card); //envoyer vers la base
            $em->flush();

            return new Response($card->getName().' created');

        }

        return $this->render('card/index.html.twig', [
            'entities' => $cards,
            'creatorId' => $this->getUser()->getId(),
            'form' => $formCard ->createView() 
        ]);
    }
    /**
    * @Route("/list", name="card_list", methods={"GET"})
    */
    public function listAll(CardRepository $cardRepository): Response
    {
        return $this->render('card/list.html.twig', [
            'cards' => $cardRepository->findAll(),
        ]);
    }
    /**
     * @Route("/category", name="category")
     */
    public function category(Request $request)
    {
        $em =$this->getDoctrine()->getManager();

        $category =  new Category();
        $formCategory = $this-> createForm(CategoryType::class, $category);

        $categories = $em ->getRepository(Category::class)->findAll();

        $formCategory->handleRequest($request);
        if($formCategory->isSubmitted() && $formCategory->isValid()) {

            $em->persist($category);
            $em->flush();

            return new Response($category->getName().' created');
            return $this->redirectToRoute('home');
        }
        
        return $this->render('card/index.html.twig', [
            'entities' => $categories,
            'form' => $formCategory ->createView() 
        ]);
    }
}
