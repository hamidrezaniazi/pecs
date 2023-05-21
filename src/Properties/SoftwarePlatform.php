<?php

namespace Hamidrezaniazi\Pecs\Properties;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-threat.html#field-threat-software-platforms */
enum SoftwarePlatform: string
{
    case AWS = 'AWS';

    case AZURE = 'Azure';

    case AZURE_AD = 'Azure AD';

    case GCP = 'GCP';

    case LINUX = 'Linux';

    case MACOS = 'macOS';

    case NETWORK = 'Network';

    case OFFICE365 = 'Office 365';

    case SAAS = 'SaaS';

    case WINDOWS = 'Windows';
}
