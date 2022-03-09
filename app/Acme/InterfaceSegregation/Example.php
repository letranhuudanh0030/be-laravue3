<?php

interface ManageableInterface{
    public function beManager();
}

interface WorkerableInterface{
    public function work();
}

interface SleepableInterface{
    public function sleep();
}

class HumanWorker implements WorkerableInterface, SleepableInterface,ManageableInterface{
    public function work()
    {
        return 'human working';
    }

    public function sleep()
    {
        return 'human sleeping';
    }

    public function beManager(){
        $this->work();
        $this->sleep();
    }
}

class AndroidWorker implements WorkerableInterface,ManageableInterface{
    public function work()
    {
        return 'android working';
    }

    public function beManager(){
        $this->work();
    }
}

class Captain {
    public function manage(ManageableInterface $worker)
    {
        $worker->beManager();
    }
}
