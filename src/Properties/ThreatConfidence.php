<?php

namespace Hamidrezaniazi\Pecs\Properties;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-threat.html#field-threat-enrichments-indicator-confidence */
enum ThreatConfidence: string
{
    case NOT_SPECIFIED = 'Not Specified';

    case NONE = 'None';

    case LOW = 'Low';

    case MEDIUM = 'Medium';

    case HIGH = 'High';
}
