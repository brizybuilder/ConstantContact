<?php

namespace Tests\Fixtures;

class CustomField extends \PHPFUI\ConstantContact\Definition\Base
	{
	protected static $fields = [
		'cf:custom_field_name' => 'string',

	];

	protected static $maxLength = [
		'cf:custom_field_name' => 255,

	];
	}
