<?php

namespace LBHurtado\EmiCore\Enums;

enum PayoutStatus: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case COMPLETED = 'completed';
    case FAILED = 'failed';
    case CANCELLED = 'cancelled';
    case REFUNDED = 'refunded';

    /**
     * Map a generic status string to a PayoutStatus enum value.
     * Provider-specific terms should be mapped in provider adapters before calling this.
     */
    public static function fromGeneric(string $status): self
    {
        return match (strtolower($status)) {
            'pending' => self::PENDING,
            'processing', 'in_transit' => self::PROCESSING,
            'completed', 'success' => self::COMPLETED,
            'failed', 'error' => self::FAILED,
            'cancelled', 'canceled' => self::CANCELLED,
            'refunded' => self::REFUNDED,
            default => self::PENDING,
        };
    }

    public function isFinal(): bool
    {
        return in_array($this, [self::COMPLETED, self::FAILED, self::CANCELLED, self::REFUNDED]);
    }

    public function isPending(): bool
    {
        return in_array($this, [self::PENDING, self::PROCESSING]);
    }

    public function getBadgeVariant(): string
    {
        return match ($this) {
            self::PENDING => 'secondary',
            self::PROCESSING => 'default',
            self::COMPLETED => 'success',
            self::FAILED => 'destructive',
            self::CANCELLED => 'outline',
            self::REFUNDED => 'default',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::PROCESSING => 'Processing',
            self::COMPLETED => 'Completed',
            self::FAILED => 'Failed',
            self::CANCELLED => 'Cancelled',
            self::REFUNDED => 'Refunded',
        };
    }
}
