<?php
/**
 *
 * Gearman Worker as a CakePHP Shell
 *
 * @package        app
 * @subpackage     app.vendors.shells
 * @author         Chris Stevens
 * @copyright      Copyright (c) 2006-2012, Chris Stevens
 */
class GearmanWorkerShell extends AppShell {
	protected $GearmanWorker;

	public function startup() {
		$this->GearmanWorker = new GearmanWorker();
	}

	public function help() {
		$this->out('Gearman Worker as a CakePHP Shell');
	}

	public function main() {
		$this->GearmanWorker->addServers('127.0.0.1');
		$this->GearmanWorker->addFunction('json_test', array($this, 'my_json_test'));
		while( $this->GearmanWorker->work() );
	}

	public function my_json_test($job) {
		$params = json_decode($job->workload(),true);
		// add a dummy response so we know that it worked
		$params['response'] = 'it worked';
		return json_encode($params);
	}
}
