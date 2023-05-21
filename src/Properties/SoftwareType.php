<?php

namespace Hamidrezaniazi\Pecs\Properties;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-threat.html#field-threat-software-type */
enum SoftwareType: string
{
    case MALWARE = 'Malware';

    case TOOL = 'Tool';
}
