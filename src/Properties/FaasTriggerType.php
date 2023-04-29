<?php

namespace Hamidrezaniazi\Pecs\Properties;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-faas.html#field-faas-trigger-type */
enum FaasTriggerType: string
{
    case HTTP = 'http';

    case PUBSUB = 'pubsub';

    case DATASOURCE = 'datasource';

    case TIMER = 'timer';

    case OTHER = 'other';
}
