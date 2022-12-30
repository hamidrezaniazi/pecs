<?php

namespace Hamidrezaniazi\Pecs\Properties;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-data_stream.html#field-data-stream-type */
enum DataStreamType: string
{
    case LOGS = 'logs';

    case METRICS = 'metrics';

    // the types bellow will be added in the near future (not yet) based on the doc
    //case TRACES = 'traces';
    //case SYNTHETICS = 'synthetics';
}
