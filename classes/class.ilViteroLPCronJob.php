<?php
/* Copyright (c) 1998-2019 ILIAS open source, Extended GPL, see docs/LICENSE */

include_once "Services/Cron/classes/class.ilCronJob.php";

/**
 * Vitero plugint to provide Learning Progress calculations.
 *
 * @author Jesús López <lopez@leifos.com>
 *
 */
class ilViteroLPCronJob extends ilCronJob
{
	const VITERO_PLUGIN_NAME = 'Vitero'; // Has to be the same in class.ilViteroPlugin.php

	protected $plugin; // [ilCronHookPlugin]

	/**
	 * Get id
	 * @return int
	 */
	public function getId()
	{
		return ilViteroLPCronPlugin::getInstance()->getId();
	}

	public function getTitle()
	{
		return ilViteroLPCronPlugin::PNAME;
	}

	public function getDescription()
	{
		return ilViteroLPCronPlugin::getInstance()->txt('cron_job_info');
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
			$plugin = $this->getParentViteroPluginObject();

			//This udpate Learning Progress at the end have to update this ilLPStatus
			$plugin->updateLearningProgress();

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
	 * @return \ilViteroLPCronPlugin
	 */
	public function getPlugin()
	{
		return ilViteroLPCronPlugin::getInstance();
	}

	private function getParentViteroPluginObject()
	{
		//include_once("./Services/Component/classes/class.ilPluginAdmin.php");

		$plugins = ilPluginAdmin::getActivePluginsForSlot(IL_COMP_SERVICE, "Repository", "robj");

		foreach ($plugins as $pl)
		{
			if($pl == self::VITERO_PLUGIN_NAME)
			{
				return ilPluginAdmin::getPluginObject(
					IL_COMP_SERVICE, "Repository",
					"robj", $pl
				);
			}
		}

		return false;
	}
}
?>