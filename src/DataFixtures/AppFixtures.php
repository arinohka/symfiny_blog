<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Post;
use App\Entity\Comments;
use App\Entity\User;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
		for ($i=0; $i <5; $i++){
        	$user = new User();
        	$user->setEmail('mail@'.$i.'.com');
        	$user->setPassword(mt_rand(100000, 10000000));
        	$manager->persist($user);
		}
		for ($i=0; $i <10; $i++){
        	$post = new Post();
        	$post->setName('post'.$i);
        	$post->setDate(new \DateTime());
        	$post->setAnnotation(mt_rand(10, 100));
        	$post->setText(mt_rand(1000, 100000));
        	$post->setViews(mt_rand(1, 1000000));
			$post->setUser($user);
        	$manager->persist($post);
		}

	// for ($i=0; $i <20; $i++){
    //     	$comments = new Comments();
    //     	$comments->setDate(new \DateTime());
    //     	$comments->setText(mt_rand(1000, 100000));
    //     	$comments->setPost($post);
    //     	$comments->setUser($user);
    //     	$manager->persist($comments);
	// 	}
	
        $manager->flush();
    }
}
