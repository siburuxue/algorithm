<?php
namespace ZP;

class Collection{
	
	private $array = [];
	
	public function __construct($array=[]){
		//判断是不是数组 如果不是抛出异常
		$this->array = $array;
	}
	
	/**
	 * 获取数组中某个元素
	 * @param $index 下角标
	 */
	public function get($index=null){
		//如果没有传下角标返回整个数组
		if(!isset($index)){
			return $this->array;
		}
		$this->validate_index($index);
		return $this->array[$index];
	}
	
	/**
	 * 判断是否为空
	 */
	public function isEmpty(){
		return count($this->array) > 0;
	}
	
	/**
	 * 入栈/入队
	 */
	public function set($obj){
		$this->array[] = $obj;
	}
	
	/**
	 * 出栈
	 */
	public function pop(){
		return array_pop($this->array);
	}
	
	/**
	 * 获取最大值
	 */
	public function max(){
		
	}
	
	/**
	 * 获取最小值
	 */
	public function min(){
		
	}
	
	/**
	 * 出队
	 */
	public function shift(){
		return array_shift($this->array);
	}
	
	/**
	 * 获取当前数组大小
	 */
	public function size(){
		return count($this->array);
	}

	/**
	 * 判断值是否存在
	 */
	public function exist($val){
		
	}
	
	/**
	 * 删除数组中的一段元素并返回
	 * @param $index 下角标
	 * @param $length 删除数组个数 默认为1个
	 * @return 返回被删除的元素
	 */
	public function del($index,$length=1){
		$this->validate_index($index);
		return array_splice($this->array,$index,$length);
	}
	
	/**
	 * 验证索引是否合法
	 */
	private function validate_index($index){
		//判断索引是不是数字 不是抛异常
		//判断是不是非负数 不是抛异常
		//判断是否超过边界，超过抛异常
		if($index >= count($this->array)){
			throw new \Exception('$index越界');
		}
	}
}