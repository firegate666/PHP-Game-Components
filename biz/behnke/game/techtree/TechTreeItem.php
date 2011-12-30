<?php
namespace biz\behnke\game\techtree;

class TechTreeItem {
	
	/**
	 * 
	 * @var String
	 */
	protected $name;
	
	/**
	 * 
	 * @var String
	 */
	protected $description;
	
	/**
	 * 
	 * @var TechTreeDependenc[]
	 */
	protected $dependencies = array();
	
}
