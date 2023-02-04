<?php

namespace App\Console\Commands;

use AmoCRM\Models\LeadModel;
use App\Models\Company;
use App\Models\Lead;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\AmoCRM\AmoCRMClientFactory;
use Illuminate\Console\Command;

class AmoCRMImportLeads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'amocrm:import:leads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all leads from AmoCRM';

    public function handle()
    {
        $client = AmoCRMClientFactory::getClient();

        $leadsService = $client->leads();

        $leads = null;

        $bar = $this->output->createProgressBar();

        while (true) {
            if (!$leads) {
                $leads = $leadsService->get(null,  [
                    LeadModel::CONTACTS,
                ]);
            } else {
                $leads = $leadsService->nextPage($leads);
            }

            if ($leads === null) {
                break;
            }

            $bar->setMaxSteps($bar->getMaxSteps() + $leads->count());

            /** @var LeadModel $lead */
            foreach ($leads as $lead) {
                $company = $client->companies()->getOne($lead->getCompany()->getId());
                $companyData = $this->filterModelFields($company->toArray(), Company::FILLABLE_FIELDS);
                $companyData = $this->convertTimestamps($companyData);

                $leadData = $this->filterModelFields($lead->toArray(), Lead::FILLABLE_FIELDS);
                $leadData = $this->convertTimestamps($leadData);
                $leadData['company_id'] = $company->getId();

                DB::transaction(function () use($leadData, $companyData, $bar) {
                    Company::updateOrCreate(['id' => $companyData['id']], $companyData);
                    Lead::updateOrCreate(['id' => $leadData['id']], $leadData);

                    $bar->advance();
                });
            }

            if (!$leads->getNextPageLink()) {
                break;
            }
        }
    }

    private function filterModelFields(array $data, array $keys): array {
        return array_filter($data, fn($item, $key) => in_array($key, $keys), ARRAY_FILTER_USE_BOTH);
    }

    private function convertTimestamps(array $data): array {
        foreach ($data as $key => $property) {
            if (Str::endsWith($key, '_at') && $property !== null) {
                $data[$key] = CarbonImmutable::createFromTimestamp($property);
            }
        }

        return $data;
    }
}
