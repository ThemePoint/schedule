<?php

declare(strict_types=1);

/**
 * Copyright (c) 2022-2022 ThemePoint
 *
 * @author Hendrik Legge <hendrik.legge@themepoint.de>
 *
 * @version 1.0.0
 */

namespace ThemePoint\Scheduler\Factory;

use Cron;

final class CronExpressionFactory
{
    public static function create(
        string $expression = '* * * * *',
    ): Cron\CronExpression {
        return new Cron\CronExpression(
            $expression,
            new Cron\FieldFactory(),
        );
    }
}
