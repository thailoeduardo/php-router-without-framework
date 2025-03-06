<?php
namespace App\Controllers;

class UserController
{
	public function index(): string
	{
			return "Welcome to page User!";
	}

	public function show(array $params): string
	{
		$userId = $params['id'];
		return "Showing user profile for ID: {$userId}";
	}
}