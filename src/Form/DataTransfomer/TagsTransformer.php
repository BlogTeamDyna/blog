<?php

namespace App\Form\DataTransformer;

use App\Entity\Commentary;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use App\Entity\Tag;


class TagsTransformer implements DataTransformerInterface {


    private ObjectManager $manager;

    public function __construct(ObjectManager $manager) {
        $this->manager = $manager;
    }
    public function transform(mixed $value): string
    {
        dump($value); // TODO: Implement transform() method.
        return implode(',', $value);
    }
    public function reverseTransform($string): array
    {

        $contents = explode(',', $string);

        $tags = $this->manager->getRepository(Tag::class)->findBy([
            'content' => $contents
          ]);


        foreach ($contents as $content) {
            $tag = new Tag();
            $tag->setContent($content);
            $tags[] = $tag;
        }
        return $tags;
        // TODO: Implement reverseTransform() method.
    }
}