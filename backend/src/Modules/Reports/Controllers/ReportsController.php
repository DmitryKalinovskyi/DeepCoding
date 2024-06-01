<?php

namespace DeepCode\Modules\Reports\Controllers;

use DeepCode\Modules\Authentication\Attributes\Filters\Authenticated;
use DeepCode\Modules\Authentication\Attributes\Filters\InRole;
use DeepCode\Modules\Reports\Repositories\IReportsRepository;
use DeepCode\Modules\Reports\Repositories\ReportsSearchParams;
use DeepCode\Modules\Reports\Validation\ReportValidation;
use Framework\Attributes\Dependency\Resolvable;
use Framework\Attributes\Requests\HttpDelete;
use Framework\Attributes\Requests\HttpPost;
use Framework\attributes\Routing\Route;
use Framework\Http\HttpContext;
use Framework\Mapper\AutoMapper;
use Framework\Middlewares\Response\JsonResponse;
use Framework\MVC\APIController;
use Framework\Validation\Validator;

class ReportsController extends APIController
{
    #[Resolvable]
    private IReportsRepository $reportsRepository;
    #[Resolvable]
    private HttpContext $context;


    #[Route("")]
    #[Authenticated]
    #[InRole("Admin")]
    public function Search(): JsonResponse{
        $params = new ReportsSearchParams();
        AutoMapper::mapFromArray($_GET, $params);

        if(!Validator::isModelValid($params)){
            return $this->json((object)["errors" => !Validator::getErrors($params)]);
        }

        return $this->json((object)[
            "pages" => ceil($this->reportsRepository->searchCount($params) / $params->pageSize),
            "reports" =>  $this->reportsRepository->search($params)
        ]);
    }

    #[Route("")]
    #[Authenticated]
    #[HttpPost]
    public function CreateReport(): JsonResponse
    {
        try{
            $validationModel = AutoMapper::map($this->context->body, new ReportValidation());
        }
        catch (\Exception $e){
            return $this->json((object)["errors" => $e->getMessage()], 422);
        }
        $validationModel->UserId = $this->context->user->Id;

        if(!Validator::isModelValid($validationModel)){
            return $this->json((object)["errors" => Validator::getErrors($validationModel)], 422);
        }

        $this->reportsRepository->insert($validationModel);
        return $this->json("Report added.", 200);
    }

    #[Route("{reportId}")]
    #[Authenticated]
    #[InRole("Admin")]
    #[HttpDelete]
    public function DeleteReport(string $reportId): JsonResponse
    {
        if(!ctype_digit($reportId)){
            return $this->json("ReportId is not positive integer");
        }
        $reportId = (int)$reportId;

        $this->reportsRepository->delete($reportId);
        return $this->json("Report deleted.", 200);
    }

    #[Route("{reportId}")]
    #[Authenticated]
    #[InRole("Admin")]
    public function GetReport(string $reportId): JsonResponse
    {
        if(!ctype_digit($reportId)){
            return $this->json("ReportId is not positive integer");
        }
        $reportId = (int)$reportId;
        $report = $this->reportsRepository->find($reportId);

        if($report == null){
            return $this->json("Not founded", 404);
        }

        return $this->json($report, 200);
    }
}