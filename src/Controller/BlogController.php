<?php 
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;

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
     *  @Route("/{page}",  name="blog_list", defaults={"page"= 5})
     */
    public function list($page = 1){

        /*
            default value specified both in the annotation and function parameter
        
        */

        return new JsonResponse(
            [
                "page" => $page,
                "data" => self::POSTS
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

        return new JsonResponse(
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

}



?>