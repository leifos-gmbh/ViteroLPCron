<?php
/* Copyright (c) 1998-2019 ILIAS open source, Extended GPL, see docs/LICENSE */

include_once "Services/Cron/classes/class.ilCronJob.php";

/**
 * Vitero plugint to provide Learning Progress calculations.
 *
 * @author Jesús López <lopez@leifos.com>
 *
 */
class ilViteroLearningProgressCronJob extends ilCronJob
{
	protected $plugin; // [ilCronHookPlugin]

	/**
	 * Get id
	 * @return int
	 */
	public function getId()
	{
		return ilViteroLearningProgressPlugin::getInstance()->getId();
	}

	public function getTitle()
	{
		return ilViteroLearningProgressPlugin::PNAME;
	}

	public function getDescription()
	{
		return ilViteroLearningProgressPlugin::getInstance()->txt('cron_job_info');
	}

	public function getDefaultScheduleType()
	{
		return self::SCHEDULE_TYPE_IN_MINUTES;
	}

	public function getDefaultScheduleValue()
	{
		return parent::SCHEDULE_TYPE_IN_HOURS;
	}

	public function hasAutoActivation()
	{
		return false;
	}

	public function hasFlexibleSchedule()
	{
		return true;
	}

	public function hasCustomSettings()
	{
		return false;
	}

	public function run()
	{
		$result = new ilCronJobResult();

		try
		{
			$result->setStatus(ilCronJobResult::STATUS_OK);
		}
		catch(ilException $e)
		{
			ilLoggerFactory::getRootLogger()->debug('Cron job failed with message:' . $e->getMessage());
			$result->setStatus(ilCronJobResult::STATUS_CRASHED);
			$result->setMessage($e->getMessage());
		}
		return $result;
	}

	/**
	 * @return \ilViteroLearningProgressPlugin
	 */
	public function getPlugin()
	{
		return ilViteroLearningProgressPlugin::getInstance();
	}

}

?>