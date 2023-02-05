<?php

namespace App\Console\Commands;

use AmoCRM\Models\LeadModel;
use App\Repository\CompanyRepository;
use App\Repository\LeadRepository;
use Illuminate\Support\Facades\DB;
use Modules\AmoCRM\AmoCRMClientFactory;
use Illuminate\Console\Command;
use Modules\AmoCRM\EntityService;

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

    public function handle(
        CompanyRepository $companyRepository,
        LeadRepository $leadRepository,
        EntityService $entityService
    ) {
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
                DB::transaction(function () use($companyRepository, $leadRepository, $entityService, $lead, $bar) {
                    $company = $entityService->createCompanyFromCompanyModel($lead->getCompany());
                    $lead = $entityService->createLeadFromLeadModel($lead);

                    $companyRepository->updateOrCreate($company);
                    $leadRepository->updateOrCreate($lead);

                    $bar->advance();
                });
            }

            if (!$leads->getNextPageLink()) {
                break;
            }
        }
    }
}
