<?php

namespace wisder\yii\rest;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpHeaderAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\ContentNegotiator;
use yii\filters\RateLimiter;
use yii\filters\VerbFilter;
use yii\web\Response;

class Controller extends \yii\rest\Controller
{
    public $optional = [];

    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'application/xml' => Response::FORMAT_XML,
                ],
            ],
            'verbFilter' => [
                'class' => VerbFilter::class,
                'actions' => $this->verbs(),
            ],
            'authenticator' => [
                'class' => CompositeAuth::class,
                'authMethods' => [
                    [
                        'class' => HttpHeaderAuth::class,
                        'header' => 'token',
                    ],
                    [
                        'class' => QueryParamAuth::class,
                        'tokenParam' => 'token',
                    ],
                ],
                'optional' => $this->optional,
            ],
            'rateLimiter' => [
                'class' => RateLimiter::class,
            ],
        ];
    }
}
