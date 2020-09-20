<?php

namespace BomberoApp\CJC;

use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\Log;
use Throwable;

class CJC
{
    public static function consume(JobProcessing $event)
    {
        // get custom consumers from config
        $consumers = config('cjc.consumers');

        // continue with legacy job flow if there isn't a custom consumer for the job
        if (!array_key_exists($event->job->getName(), $consumers)) {
            return;
        }

        // execute job
        $consumer = new $consumers[$event->job->getName()]($event->job->payload());
        $consumer->setJob($event->job);
        $consumer->handle();

        // workaround to catch unknown problems
        try {
            $event->job->delete();
        } catch (Throwable $throwable) {
            Log::error('unable to execute job ' . $event->job->getName(), $throwable->getTrace());
        }
    }
}
