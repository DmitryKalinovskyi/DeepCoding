<?php

namespace DeepCode\Modules\News\Controllers;

use DateTime;
use DeepCode\Models\News;
use DeepCode\Modules\Authentication\Attributes\Filters\InRole;
use DeepCode\Modules\News\Repositories\INewsRepository;
use DeepCode\Modules\News\Repositories\NewsSearchParams;
use DeepCode\Modules\News\Validation\NewsValidation;
use Framework\Attributes\Dependency\Resolvable;
use Framework\Attributes\Requests\HttpDelete;
use Framework\Attributes\Requests\HttpPatch;
use Framework\Attributes\Requests\HttpPost;
use Framework\attributes\Routing\Route;
use Framework\Http\HttpContext;
use Framework\Mapper\AutoMapper;
use Framework\Middlewares\Response\JsonResponse;
use Framework\MVC\APIController;
use Framework\Validation\TemplateValidator;
use Framework\Validation\Validator;

class NewsController extends APIController
{
    #[Resolvable]
    private HttpContext $context;
    #[Resolvable]
    private INewsRepository $newsRepository;

    #[Route('')]
    #[InRole("Admin")]
    #[HttpPost]
    public function AddNews(): JsonResponse{
        $validationModel = null;
        try{
            $validationModel = AutoMapper::map($this->context->body, new NewsValidation());
        }
        catch (\Exception $e){
            return $this->json((object)["errors" => $e->getMessage()], 422);
        }
        $validationModel->CreatedTime = time();

        if(!Validator::isModelValid($validationModel)){
            return $this->json((object)["errors" => Validator::getErrors($validationModel)], 422);
        }

        $this->newsRepository->insert($validationModel);
        return $this->json("News added.", 200);
    }

    #[Route('')]
    public function GetNews(): JsonResponse{
        /* @var NewsSearchParams $params */
        $params = AutoMapper::mapFromArray($_GET, new NewsSearchParams());
        $result = (object)[
            "pages" => ceil($this->newsRepository->searchCount($params) / $params->pageSize),
            "news" => $this->newsRepository->search($params)
        ];
        return $this->json($result, 200);
    }

    #[Route('{newsId}')]
    public function GetOneNews(string $newsId): JsonResponse{
        if(!ctype_digit($newsId)){
            return $this->json("NewsId is not positive integer");
        }
        $newsId = (int)$newsId;
        $news = $this->newsRepository->find($newsId);

        if($news == null){
            return $this->json("Not founded", 404);
        }

        return $this->json($news, 200);
    }

    #[Route('{newsId}')]
    #[HttpPatch]
    #[InRole("Admin")]
    public function UpdateNews(string $newsId): JsonResponse{
        if(!ctype_digit($newsId)){
            return $this->json("NewsId is not positive integer");
        }
        $newsId = (int)$newsId;

        // took from body
        $intersect = AutoMapper::intersect($this->context->body, new NewsValidation());
        $errors = [];
        if(!TemplateValidator::isModelValid($intersect, NewsValidation::class, false, $errors)){
            return $this->json((object)["errors" => $errors], 422);
        }

        $this->newsRepository->update($newsId, $intersect);

        return $this->json("Updated.", 200);
    }



    #[Route('{newsId}')]
    #[HttpDelete]
    #[InRole("Admin")]
    public function DeleteNews(string $newsId): JsonResponse{
        if(!ctype_digit($newsId)){
            return $this->json("NewsId is not positive integer");
        }
        $newsId = (int)$newsId;

        $this->newsRepository->delete($newsId);
        return $this->json("News deleted.", 200);
    }
}