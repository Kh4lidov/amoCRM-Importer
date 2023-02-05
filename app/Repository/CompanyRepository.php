<?php

namespace App\Repository;

use App\Models\Company;

class CompanyRepository
{
    public function updateOrCreate(Company $company): void {
        if (Company::where('id', $company->id)->exists()) {
            $company->exists = true;
        }

        $company->save();
    }
}
