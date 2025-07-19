<?php 

declare(strict_types=1);

namespace App\Enums;

enum AppointmentStatus: string {
    case SCHEDULED = "SCHEDULED";
    case CONFIRMED = "CONFIRMED";
    case COMPLETED = "COMPLETED";
    case CANCELLED = "CANCELLED";
    case NOT_SHOWING = "NOT_SHOWING";
}