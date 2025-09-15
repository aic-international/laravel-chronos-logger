<?php

namespace AicInternational\ChronosLogger;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use InvalidArgumentException;
use Monolog\Logger as Monolog;

class Logger {
	private Repository $config;
	private $container;

	public function __construct(Container $container, Repository $config) {
		$this->container = $container;
		$this->config = $config;
	}

	public function __invoke(array $config): Monolog {
		if (empty($config['url'])) {
			throw new InvalidArgumentException('The "url" option is required for the ChronosLogger');
		}

		if (empty($config['token'])) {
			throw new InvalidArgumentException('The "token" option is required for the ChronosLogger');
		}

		return new Monolog($this->config->get('app.name'), [
			new LogHandler($config)
		]);
	}
}
