<?php
namespace biz\behnke\game\techtree;

class TechTree {
	
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
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return the $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @param string $description
	 */
	public function setDescription($description) {
		$this->description = $description;
	}


}
