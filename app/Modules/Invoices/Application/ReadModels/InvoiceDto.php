<?php declare(strict_types=1);

namespace App\Modules\Invoices\Application\ReadModels;

use Carbon\Carbon;

final readonly class InvoiceDto
{
    public function __construct(
        public string $number,
        public Carbon $date,
        public Carbon $dueDate,
        public CompanyDto $company,
        public CompanyDto $billedCompany,
    ) {
    }
}
