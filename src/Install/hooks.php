#!/usr/bin/env php

<?php

require getcwd() . '/vendor/autoload.php';

use Apex\Core\Install\DockerInstaller;

DockerInstaller::copyDockerCompose();