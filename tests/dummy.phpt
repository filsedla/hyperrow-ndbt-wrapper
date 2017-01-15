<?php

/**
 * Test: dummy test - a template
 * @dataProvider databases.ini
 */

use Tester\Assert;

require __DIR__ . '/bootstrap.php';

Assert::same(1, $context->query('SELECT 1')->fetchField());
