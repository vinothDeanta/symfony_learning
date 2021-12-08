<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $blogPost = new BlogPost();
        $blogPost->setTitle('A first post');
        $blogPost->setPublished(new \DateTime('2021-06-05 12:00:00'));
        $blogPost->setContent('Post description');
        $blogPost->setAuthor('Selvam');
        $blogPost->setSlugname('a-first-post');
        $manager->persist($blogPost);
        
        $blogPost = new BlogPost();
        $blogPost->setTitle('A second post');
        $blogPost->setPublished(new \DateTime('2021-06-05 01:00:00'));
        $blogPost->setContent('Post description');
        $blogPost->setAuthor('vinoth');
        $blogPost->setSlugname('a-second-post');
        $manager->persist($blogPost);

        $manager->flush();
    }
}
