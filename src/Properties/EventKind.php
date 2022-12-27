<?php

namespace Hamidrezaniazi\Pecs\Properties;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-allowed-values-event-kind.html */
enum EventKind: string
{
    case ALERT = 'alert';

    case ENRICHMENT = 'enrichment';

    case EVENT = 'event';

    case METRIC = 'metric';

    case STATE = 'state';

    case PIPELINE_ERROR = 'pipeline_error';

    case SIGNAL = 'signal';
}
