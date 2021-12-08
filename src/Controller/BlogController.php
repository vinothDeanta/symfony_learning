<?php 
namespace App\Controller;

use App\Entity\BlogPost;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\HttpFoundation\Request;



/**
 * @Route("/blog")
 */

Class BlogController extends AbstractController
{

    /**
     *  @Route("/{page}",  name="blog_list", defaults={"page"= 5},  requirements={"page"="\d+"},  methods={"GET"})
     */
    public function Postlist($page = 1, Request $request)
    {
        $limit = $request->get('limit', 10);
       
        $repository = $this->getDoctrine()->getRepository(BlogPost::class);
        $items = $repository->findAll();

        return $this->json(
            [
                "page" => $page,
                "limit" => $limit,
                "data" => array_map(function(BlogPost $item){
                   // return $item->getSlugname();
                    return $this->generateUrl('blog_by_id', ['id'=> $item->getId()]);
                }, $items)
            ]
            
        );
    }

    /**
     * @Route("/post/{id}", name="blog_by_id", requirements={"id"="\d+"},  methods={"GET"})
     */
    // public function post($id)
    // {
    //     return $this->json(
    //         $this->getDoctrine()->getRepository(BlogPost::class)->find($id)
    //     );
    // }
    public function post(BlogPost $post)
    {
        // it is also same as "$this->getDoctrine()->getRepository(BlogPost::class)->find($id)"
         return $this->json($post);
    }


    /**
     * @Route("/post/{slug}", name="blog_by_slug",  methods={"GET"})
     */
    public function postBySlug($slug)
    {
        return $this->json(
            $this->getDoctrine()->getRepository(BlogPost::class)->findBy(["slugname"=>$slug])
        );
    }

    




    /**
     * @Route("/add", name="blog_add", methods={"POST"})
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

    /**
     * @Route("/delete/{id}", name="blog_delete", methods={"DELETE"})
     */
    public function delete(BlogPost $post)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();
        return $this->json(["status"=>"Delete Successfully"]);
    }


}



?>