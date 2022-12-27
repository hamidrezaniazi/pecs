<?php

namespace Hamidrezaniazi\Pecs\Properties;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-allowed-values-event-outcome.html */
enum EventOutcome: string
{
    case FAILURE = 'failure';

    case SUCCESS = 'success';

    case UNKNOWN = 'unknown';
}
