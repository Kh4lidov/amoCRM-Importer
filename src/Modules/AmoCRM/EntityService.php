<?php

namespace Modules\AmoCRM;

use AmoCRM\Models\CompanyModel;
use AmoCRM\Models\LeadModel;
use App\Models\Company;
use App\Models\Lead;
use Carbon\CarbonImmutable;

class EntityService
{
    public function createLeadFromLeadModel(LeadModel $leadModel): Lead {
        $lead = new Lead();

        $lead->id = $leadModel->getId();
        $lead->name = $leadModel->getName();
        $lead->responsible_user_id = $leadModel->getResponsibleUserId();
        $lead->group_id = $leadModel->getGroupId();
        $lead->created_by = $leadModel->getCreatedBy();
        $lead->updated_by = $leadModel->getUpdatedBy();
        $lead->created_at = $this->createDateFromTimestamp($leadModel->getCreatedAt());;
        $lead->updated_at = $this->createDateFromTimestamp($leadModel->getUpdatedAt());;
        $lead->account_id = $leadModel->getAccountId();
        $lead->pipeline_id = $leadModel->getPipelineId();
        $lead->status_id = $leadModel->getStatusId();
        $lead->closed_at = $this->createDateFromTimestamp($leadModel->getClosedAt());;
        $lead->closest_task_at = $this->createDateFromTimestamp($leadModel->getClosestTaskAt());;
        $lead->price = $leadModel->getPrice();
        $lead->loss_reason_id = $leadModel->getLossReasonId();
        $lead->company_id = $leadModel->getCompany()->getId();

        return $lead;
    }

    public function createCompanyFromCompanyModel(CompanyModel $companyModel): Company {
        $company = new Company();

        $company->id = $companyModel->getId();
        $company->name = $companyModel->getName();
        $company->responsible_user_id = $companyModel->getResponsibleUserId();
        $company->group_id = $companyModel->getGroupId();
        $company->created_by = $companyModel->getCreatedBy();
        $company->updated_by = $companyModel->getUpdatedBy();
        $company->created_at = $this->createDateFromTimestamp($companyModel->getCreatedAt());;
        $company->updated_at = $this->createDateFromTimestamp($companyModel->getUpdatedAt());;
        $company->closest_task_at = $this->createDateFromTimestamp($companyModel->getClosestTaskAt());;
        $company->account_id = $companyModel->getAccountId();

        return $company;
    }

    private function createDateFromTimestamp(?int $timestamp): ?CarbonImmutable {
        return $timestamp ? CarbonImmutable::createFromTimestamp($timestamp) : null;
    }
}
