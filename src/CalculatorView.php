<?php 

class CalculatorView {

	private static $defaultTemplateExt  = '.html.php';
	private static $defaultTemplatePath = './assets/templates/';

	private $template;
	private $data;
	private $templatePath;
	private $templateExt;
	
	public function __construct($template, $data = array(), $templatePath = '', $templateExt = '')
	{
		$this->template = $template;
		$this->data = $data;
		$this->templatePath = ($templatePath !== '') ? $templatePath : self::$defaultTemplatePath; 
		$this->templateExt = ($templateExt !== '') ? $templateExt : self::$defaultTemplateExt;
	}

	public function getFullTemplatePath()
	{
		return realpath($this->templatePath . $this->template . $this->templateExt);
	}

	public function render()
	{
		ob_start();
		extract($this->data);
		include($this->getFullTemplatePath());
		return ob_get_clean();
	}
}