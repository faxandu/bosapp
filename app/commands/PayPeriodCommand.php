<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use TimeTracking\models\TimeTrackingPayPeriod;


class PayPeriodCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'pay_period:create';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Used for cron job, creates new pay period';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{

		$infile = fopen("/var/www/html/app/commands/week_check.txt", "r") or die("Unable to open file!");
		$check = fgetc($infile);
		if($check == '1') {
            $start_date = date("Y-n-j",strtotime("today"));
            $end_date = date("Y-n-j",strtotime("+14 day"));
			$arr = array('name' => "", 'start_pay_period' => $start_date, 'end_pay_period' => $end_date);
			TimeTrackingPayPeriod::create($arr);
			$outfile = fopen("/var/www/html/app/commands/week_check.txt", "w") or die("Unable to open file!");
			fwrite($outfile, '0');
		//	$timetracker = new TimeTrackingPayPeriodController();
		}
		else{
			//unlink('week_check.txt');
			$outfile = fopen("/var/www/html/app/commands/week_check.txt", "w") or die("Unable to open file!");
			fwrite($outfile, '1');
		}	
		fclose($infile);
		fclose($outfile);


	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('example', InputArgument::OPTIONAL, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
