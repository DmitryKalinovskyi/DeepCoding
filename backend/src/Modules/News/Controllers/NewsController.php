<?php

namespace DeepCode\Modules\News\Controllers;

use DateTime;
use DeepCode\Modules\News\Repositories\INewsRepository;
use DeepCode\Modules\News\Validation\NewsValidation;
use Framework\Attributes\Dependency\Resolvable;
use Framework\Attributes\Requests\HttpDelete;
use Framework\Attributes\Requests\HttpPost;
use Framework\attributes\Routing\Route;
use Framework\Http\HttpContext;
use Framework\Mapper\AutoMapper;
use Framework\Middlewares\Response\JsonResponse;
use Framework\MVC\APIController;
use Framework\Validation\Validator;

class NewsController extends APIController
{
    #[Resolvable]
    private HttpContext $context;
    #[Resolvable]
    private INewsRepository $newsRepository;

    #[Route('')]
    #[HttpPost]
    public function AddNews(): JsonResponse{
        $validationModel = AutoMapper::map($this->context->body, new NewsValidation());
        $validationModel->CreatedTime = new DateTime();

        if(!Validator::isModelValid($validationModel)){
            return $this->json((object)["errors" => Validator::getErrors($validationModel)], 422);
        }

        $this->newsRepository->insert($validationModel);
        return $this->json("News added.", 200);
    }

    #[Route('{newsId}')]
    #[HttpDelete]
    public function DeleteNews(string $newsId): JsonResponse{
        if(!ctype_digit($newsId)){
            return $this->json("NewsId is not positive integer");
        }
        $newsId = (int)$newsId;

        $this->newsRepository->delete($newsId);
        return $this->json("News deleted.", 200);
    }
}