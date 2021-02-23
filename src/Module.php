<?php
namespace MonthlyBasis\Post;

use MonthlyBasis\Post\Model\Factory as PostFactory;
use MonthlyBasis\Post\Model\Service as PostService;
use MonthlyBasis\Post\Model\Table as PostTable;
use MonthlyBasis\Post\View\Helper as PostHelper;

class Module
{
    public function getConfig()
    {
        return [
            'view_helpers' => [
                'aliases' => [
                ],
                'factories' => [
                ],
            ],
        ];
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                PostFactory\Post::class => function ($serviceManager) {
                    return new PostFactory\Post();
                },
                PostService\Post::class => function ($serviceManager) {
                    return new PostService\Post(
                        $serviceManager->get(PostTable\Post::class)
                    );
                },
                PostService\Posts::class => function ($serviceManager) {
                    return new PostService\Posts(
                        $serviceManager->get(PostFactory\Post::class),
                        $serviceManager->get(PostTable\Post::class)
                    );
                },
                PostService\Posts\NumberOfPosts::class => function ($serviceManager) {
                    return new PostService\Posts\NumberOfPosts(
                        $serviceManager->get(PostTable\Post::class)
                    );
                },
                PostTable\Post::class => function ($serviceManager) {
                    return new PostTable\Post(
                        $serviceManager->get('main')
                    );
                },
            ],
        ];
    }
}
