<?php

/**
 * Vitero Learning Progress management Plugin
 * @author Jesus Lopez <lopez@leifos.de>
 */
class ilViteroLearningProgressPlugin extends ilCronHookPlugin
{
	private static $instance = null;

	const PNAME = 'ViteroLPCron';
	const SLOT_ID = 'crnhk';
	const CNAME = 'Cron';
	const CTYPE = 'Services';
	//const PLUGIN_DIR = ILIAS_ABSOLUTE_PATH."/Customizing/global/plugins/Services/Cron/CronHook/".ilViteroLearningProgressPlugin::PNAME;
	//const BACKUP_DIR = self::PLUGIN_DIR."/backup";

	function getPluginName()
	{
		return self::PNAME;
	}

	public static function getInstance()
	{
		if(self::$instance)
		{
			return self::$instance;
		}
		return self::$instance = ilPluginAdmin::getPluginObject(
			self::CTYPE,
			self::CNAME,
			self::SLOT_ID,
			self::PNAME
		);
	}

	//has to return an array with instances of all cron jobs of the plugin
	function getCronJobInstances()
	{
		$job = new ilViteroLearningProgressCronJob();

		return array($job);
	}

	//has to return a single instance of the cron job with the given id
	function getCronJobInstance($a_job_id)
	{
		$job = new ilViteroLearningProgressCronJob();

		return $job;
	}

	protected function init()
	{
		$this->initAutoLoad();
	}

	protected function initAutoLoad()
	{
		spl_autoload_register(
			array($this,'autoLoad')
		);
	}

	/**
	 * Auto load implementation
	 *
	 * @param string class name
	 */
	private final function autoLoad($a_classname)
	{
		$class_file = $this->getClassesDirectory().'/class.'.$a_classname.'.php';
		if(@include_once($class_file))
		{
			return;
		}
	}
}
