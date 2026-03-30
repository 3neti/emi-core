<?php

namespace LBHurtado\EmiCore\Enums;

enum VerificationStatus: string
{
    case Pending = 'PENDING';
    case ForReview = 'FOR REVIEW';
    case Rejected = 'REJECTED';
    case Approved = 'APPROVED';
    case Recapture = 'RECAPTURE';
}
