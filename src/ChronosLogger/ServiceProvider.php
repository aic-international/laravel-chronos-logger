<?php

namespace AicInternational\ChronosLogger;

use AicInternational\ChronosLogger\Console\TestChronosLogger;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider {
	public function boot(): void {
		if ($this->app->runningInConsole()) {
			$this->commands([
				TestChronosLogger::class,
				Console\GetChronosLoggerConfig::class,
			]);
		}
	}
}
