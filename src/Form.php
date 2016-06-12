<?php

namespace Beaver;

/*
 * Class de génération de formulaire HTML en PHP
 * @author Orion - OpenMy-dev <orion-dev@tuta.io>
 * @link http://www.openmy-dev.net/
 * @version 0.1.0
 */
class Form {

	/**
	 * @var string
	 */
	private $tag = 'p';

	/**
	 * @var array
	 */
	private $datas = array();

	/**
	 * @param array $datas
     */
	public function __construct($datas = array())
	{
		$this->datas = $datas;
	}

	/**
	 * @param $name
	 * @param array $options
	 * @return string
     */
	public function start($name, $options = array())
	{
		return '<form action="' . $this->get('action', $options) . '" method="' . $this->get('method', $options, 'POST') . '">';
	}

	/**
	 * @param $name
	 * @return string
     */
	public function end($name)
	{
		return '</form>';
	}

	/**
	 * @param $html
	 * @return string
     */
	protected function surround($html)
	{
		return "<{$this->tag}>$html</{$this->tag}>";
	}

	/**
	 * @param $name
	 * @param array $options
	 * @return string
     */
	public function input($name, $options = array())
	{
		$input = '<input name="' . $name . '" ';
		$input = $this->builder($name, $input, $options) . '/>';
		return $this->surround($input);
	}

	/**
	 * @param $name
	 * @param array $options
	 * @return string
	 */
	public function textarea($name, $options = array())
	{
		$input = '<textarea name="' . $name . '"';
		$input = $this->builder($name, $input, $options) . '/>';
		if($this->get($name, $this->datas) != '') {
			$this->get($name, $this->datas);
		}
		$input .= '</textarea>';
		return $this->surround($input);
	}

	/**
	 * @param $name
	 * @param $value
	 * @param array $options
	 * @return string
	 */
	public function select($name, $value, $options = array())
	{
		$input = '<select name="' . $name . '" >';
		$input = $this->builder($name, $input, $options);
		foreach($value as $k => $v) {
			$input .= '<option value="' . $k . '">' . $v . '</option>';
		}
		$input .= '</select>';
		return $this->surround($input);
	}

	/**
	 * @param $name
	 * @param array $options
	 * @return string
	 */
	public function button($name, $options = array())
	{
		$button = '<button type="' . $this->get('type', $options) . '">' . $name . '</button>';
		return $this->surround($button);
	}

	/**
	 * @param $key
	 * @param $items
	 * @param null $default
	 * @return null
	 */
	private function get($key, $items, $default = null)
	{
		if(array_key_exists($key, $items)) {
			return $items[$key];
		} else {
			return $default = isset($default) ? $default : $default;
		}
	}

	/**
	 * @param $name
	 * @param $html
	 * @param $options
	 * @return string
     */
	public function builder($name, $html, $options)
	{
		foreach($options as $k => $v) {
			if($k != 'label') {
				$html .= $k . '="' . $v . '" ';
			}
		}
		if($this->get('label', $options) != '') {
			$label = '<label for="' . $name . '">' . $this->get('label', $options) . '</label>';
			return $label . $html;
		}
		return $html;
	}
}
