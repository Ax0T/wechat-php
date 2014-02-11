<?php
/**
 * 微信session功能简易实现
 */

class Session
{

	private $_lasttime;
	private $_storage;
	private $_user;
	private $_kv;

	public function __construct($user){
		$this->_user=$user;
		$this->_kv = new SaeKV();
        // 初始化KVClient对象
        $this->_kv->init();
        $this->_storage=$this->_kv->get($user);
        var_dump($this->_storage);
        if($this->_storage===false)
        {
        	$this->_kv->set($user,array());
        	$this->_storage=array();
        }
        	
	}

	public function get($key){
		if(isset($this->_storage[$key]))
			return $this->_storage[$key];
		else
			return false;
	} 

	public function set($key,$value){
		if(isset($this->_storage[$key]))
		{
			$this->_storage[$key]=$value;
			$this->_kv->set($this->_user,$this->_storage);
			return true;
		}
		else
			return false;
	}

	public function add($key,$value){
		if(!isset($this->_storage[$key]))
		{
			$this->_storage[$key]=$value;
			$this->_kv->set($this->_user,$this->_storage);
			return true;
		}
		else
			return false;
	}	

	public function remove($key){
		if(isset($this->_storage[$key]))
		{
			unset($this->_storage[$key]);
			$this->_kv->set($this->_user,$this->_storage);
			return true;
		}
		else
			return false;
	}
}