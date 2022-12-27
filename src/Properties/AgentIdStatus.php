<?php

namespace Hamidrezaniazi\Pecs\Properties;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-event.html#field-event-agent-id-status */
enum AgentIdStatus: string
{
    case VERIFIED = 'verified';

    case MISMATCH = 'mismatch';

    case MISSING = 'missing';

    case AUTH_METADATA_MISSING = 'auth_metadata_missing';
}
