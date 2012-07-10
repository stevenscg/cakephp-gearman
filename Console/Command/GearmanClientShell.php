<?php
/**
 *
 * Gearman Client as a CakePHP Shell
 *
 * @package        app
 * @subpackage     app.vendors.shells
 * @author         Chris Stevens
 * @copyright      Copyright (c) 2006-2012, Chris Stevens
 */
class GearmanClientShell extends AppShell {
	protected $GearmanWorker;

	public function startup() {
		$this->GearmanClient = new GearmanClient();
	}

	public function help() {
		$this->out('Gearman Client as a CakePHP Shell');
	}

	public function main() {
		$this->GearmanClient->addServers('127.0.0.1');

		// simple array of parameters to serve as the test workload
		$params = array(
			'foo' => 'bar',
			'now' => time()
		);

		// synchronous (resp = A string representing the results of running a task.)
		$resp = $this->GearmanClient->do("json_test", json_encode($params));
		if ($this->GearmanClient->returnCode() != GEARMAN_SUCCESS){
			$this->out("Bad return code!");
			return;
		}

		// do something with the response
		$this->out($resp);
		return;

		// OR

		/*
		// asynchronous (resp = The job handle for the submitted task.)
		$resp = $this->GearmanClient->doBackground("json_test", json_encode($params));
		if ($this->GearmanClient->returnCode() != GEARMAN_SUCCESS){
			$this->out("Bad return code!");
			return;
		}
		$this->out('Background job handle: '.$resp);

		// using the job handle, you can monitor the status of a job
		$status = $this->GearmanClient->jobStatus($resp);

		// the job status array contains: "job known", "job running", numerator, denominator
		$this->out('Known: '.$status[0]);
		$this->out('Running: '.$status[1]);
		$this->out('Progress: '.$status[2].'/'.$status[3]);
		return;
		*/
	}

}
