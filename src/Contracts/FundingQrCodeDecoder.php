<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\Funding\FundingQrCodeData;
use LBHurtado\EmiCore\Data\Funding\FundingQrDecodeResultData;

interface FundingQrCodeDecoder
{
    public function decode(FundingQrCodeData $qrCode): FundingQrDecodeResultData;
}
