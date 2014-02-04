<?php

require_once 'lda.inc.php';
require_once 'data_handlers/data_handler_adapter.class.php';
require_once 'data_handler_components/selector.interf.php';
require_once 'data_handler_components/viewer.interf.php';

class TwoStepDataHandler extends DataHandlerAdapter{
	
	protected $selector;
	protected $viewer;
	private $list_of_item_uris;
	
	function __construct($selector, $viewer){
		$this->selector = $selector;
		$this->viewer = $viewer;
	}
	
	function processData(){	
		$this->list_of_item_uris = $this->selector->getItemMap();
		if (isset($this->list_of_item_uris['item']) && count($this->list_of_item_uris['item']) == 0){
			throw new EmptyResponseException("Empty list returned from selector");
		}
		
		$this->viewer->applyViewerAndBuildDataGraph($this->list_of_item_uris);
	}
	
	function getItemURIList(){
		return $this->list_of_item_uris;
	}
	
	function getViewQuery(){
		return $this->viewer->getViewQuery();
	}
	
	function getSelectQuery(){
		return $this->selector->getSelectQuery();
	}
	
	function getPageUri(){
		return $this->viewer->getPageUri();
	}
	
}

?>