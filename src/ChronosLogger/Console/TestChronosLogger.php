<?php

namespace AicInternational\ChronosLogger\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TestChronosLogger extends Command {
	protected $signature = 'chronos:log-test {message? : The test message}';
	protected $description = 'Sends a test log message via the Chronos Logger';

	public function handle(): int {
		$message = $this->argument('message') ?? 'Chronos Logger test successful!';

		Log::channel('chronos')->info($message);
		$this->info("✅ Test log was sent: {$message}");

		return self::SUCCESS;
	}
}
