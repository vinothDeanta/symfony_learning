<?php 
namespace App\Controller;

use App\Entity\BlogPost;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\HttpFoundation\Request;



/**
 * @Route("/blog")
 */

Class BlogController extends AbstractController
{
    Private const POSTS = [
        [
            "id" => 1,
            "username" => "Vinoth",
            "department" => "CSE",
        ],

        [
            "id" => 2,
            "username" => "Dinesh",
            "department" => "IT",
        ],

        [
            "id" => 3,
            "username" => "Kishore",
            "department" => "ECE",
        ],
    ];

    /**
     *  @Route("/{page}",  name="blog_list", defaults={"page"= 5},  requirements={"page"="\d+"})
     */
    public function list($page = 1, Request $request){

        /*
            default value specified both in the annotation and function parameter
        
        */
        $limit = $request->get('limit', 10);
        
        return $this->json(
            [
                "page" => $page,
                "limit" => $limit,
                "data" => self::POSTS,
                "url" => array_map(function($item){
                    return $this->generateUrl('blog_by_id', ['id'=> $item['id']]);
                }, self::POSTS)
            ]
            
        );
    }

    /**
     * @Route("/post/{id}", name="blog_by_id", requirements={"id"="\d+"})
     */
    public function post($id)
    {
        /* 
            1, The array_search() function search an array for a value and returns the key.
            syntax: array_search(value, array, strict)
        
            2, The array_column() function returns the values from a single column in the input array 
            syntax: array_column(array, column_key, index_key = optional)

            3, \d indicates digits only, requirements means regular expression. 


        */ 

        return $this->json(
            self::POSTS[array_search($id, array_column(self::POSTS, 'id'))]
        );
    }


    /**
     * @Route("/post/{username}", name="blog_by_username")
     */
    public function postByUsername($username)
    {
        return new JsonResponse(
            self::POSTS[array_search($username, array_column(self::POSTS, 'username'))]
        );
    }

    /**
     *  @Route("/post/{page}",  name="blog_list", defaults={"page"= 5},  requirements={"page"="\d+"})
     */
    public function Postlist($page = 1, Request $request)
    {
        $limit = $request->get('limit', 10);
        $repository = $this->getDoctrine()->getManager(BlogPost::class);
        $items = $repository->findAll();
        
        return $this->json(
            [
                "page" => $page,
                "limit" => $limit,
                "data" => array_map(function(BlogPost $item){
                    return $this->generateUrl('blog_by_slug', ['id'=> $item->getSlugname()]);
                }, $items)
            ]
            
        );
    }





    /**
     * @Route("/add", name="blog_add")
     */
    public function add(Request $request)
    {
        $serializer = $this->get('serializer');
        $blogPost = $serializer->deserialize($request->getContent(), BlogPost::class, 'json');
        $em = $this->getDoctrine()->getManager();
        $em->persist($blogPost);
        $em->flush();
        return $this->json($blogPost);

    }

}



?>