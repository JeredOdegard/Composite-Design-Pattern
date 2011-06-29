<?php
	abstract class ToDo {		
		abstract function getTitle();
		abstract function getDueDate();
		abstract function getTags();
		
		function getComposite () {
			return null;
		}
		function __toString() {
			return "{$this->title}";
		}
	}
	class SimpleToDo extends ToDo {
		private $title;
		private $duedate;
		private $tags = array();
		
		function __construct($title, $duedate, array $tags) {
			$this->title = $title;
			$this->summary = $summary;
			$this->duedate = $duedate;
			$this->tags = $tags;
		}
		
		function getTitle() {
			return $this->title;
		}
		function getDueDate() {
			return $this->duedate;
		}
		function getTags() {
			return $this->tags;
		}
	}
	abstract class CompositeToDo extends ToDo {
		protected $todos = array();
		
		function addToDo(ToDo $todo) {
			if (in_array($todo, $this->todos, true)) {
				return;
			}
			$this->todos[] = $todo;
		}
		function removeToDo(ToDo $todo) {
			$todos = array();
			foreach ($this->todos as $thisToDo) {
				if ($todo !== $thisToDo) {
					$todos[] = $thisToDo;
				}
			}
			$this->todos = $todos;
		}
		function getToDos() {
			return $this->todos;
		}	
		function getComposite() {
			return $this;
		}
	}
	class Project extends CompositeToDo {
		private $title;
		private $summary;
		private $duedate;
		private $tags = array();
		
		function __construct($title, $summary, $duedate, array $tags) {
			$this->title = $title;
			$this->summary = $summary;
			$this->duedate = $duedate;
			$this->tags = $tags;
		}
		function __toString() {
			$list;
			foreach ($this->todos as $thistodo) {
				$list .= "{$thistodo->getTitle()}\n";
			}
			return $list;
		}
		
		function getTitle() {
			return $this->title;
		}
		function getSummary() {
			return $this->summary;
		}
		function getDueDate() {
			return $this->duedate;
		}
		function getTags() {
			return $this->tags;
		}
	}
	
	// Runtime Environment
	function enumerateProject (Project $project) {
		print "{$project->getTitle()}({$project->getSummary()}): \n";
		foreach ($project->getToDos() as $eachToDo) {
			if ($eachToDo instanceof Project) {
				print "sub:";
				enumerateProject($eachToDo);
			}
			else {
				print "{$eachToDo->getTitle()}\n";
			}
		}
	}
	$project = new Project("Get Groceries", "grocery list", null, array());
	$meatProject = new Project("Meat Time", "meat list", null, array());
	$project->addToDo(new SimpleToDo("Milk", null, array()));
	$project->addToDo($meatProject);
	$meatProject->addToDo(new SimpleToDo("Beef", null, array()));
	$chicken = new Project("Chicken", "", null, array());
	$meatProject->addToDo($chicken);
	$chicken->addToDo(new SimpleToDo("Fried Chicken", null, array()));
	$chicken->addToDo(new SimpleToDo("Grilled Chicken", null, array()));
	$project->addToDo(new SimpleToDo("Water", null, array()));
	
	enumerateProject($project);
?>