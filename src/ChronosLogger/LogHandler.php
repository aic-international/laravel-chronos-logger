<?php

namespace AIC\ChronosLogger;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Level;
use Monolog\Logger;
use Monolog\LogRecord;
use Throwable;

class LogHandler extends AbstractProcessingHandler {
	private array $channelConfig;

	public function __construct(array $config) {
		parent::__construct(Logger::toMonologLevel($config['level'] ?? Level::Debug));
		$this->channelConfig = $config;
	}

	protected function write(LogRecord $record): void {
		Chronos::log(
			$this->channelConfig['url'] ?? null,
			$this->channelConfig['token'] ?? null,
			$this->channelConfig['labels'] ?? null,
			$record->level->getName(),
			$record->message,
			$this->getStackTrace($record),
			$record->context,
			$record->datetime->format('Y-m-d H:i:s')
		);
	}

	private function getStackTrace(LogRecord $record): ?array {
		if (!is_a($record['context']['exception'] ?? '', Throwable::class)) {
			return null;
		}

		return $record['context']['exception']->getTrace();
	}
}
