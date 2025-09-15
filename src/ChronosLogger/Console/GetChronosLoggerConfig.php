<?php

namespace AicInternational\ChronosLogger\Console;

use Illuminate\Console\Command;

class GetChronosLoggerConfig extends Command {
	protected $signature = 'chronos:config {channel=chronos : The Name of the channel}';
	protected $description = 'Displays the current configuration of a Chronos log channel.';

	public function handle(): int {
		$channel = $this->argument('channel');
		$configKey = "logging.channels.$channel";

		$config = config($configKey);

		if (!$config) {
			$this->error("Channel [$channel] not found in config/logging.php");
			return self::FAILURE;
		}

		$this->info("Chronos Config for [$channel]:");

		$this->table(
			['Key', 'Value'],
			collect($config)->map(function ($value, $key) {
				if (is_array($value)) {
					$value = json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
				}
				return [$key, $value];
			})->toArray()
		);

		return self::SUCCESS;
	}
}
