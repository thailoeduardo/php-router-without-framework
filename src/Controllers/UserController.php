<?php
namespace App\Controllers;

class UserController
{
	public function index(): string
	{
			return "Welcome to page User!";
	}

	public function show($id): string
	{
		$userId = filter_var($id, FILTER_VALIDATE_INT);
    if ($userId === false) {
			return "Invalid user ID";
    }

		return "Showing user profile for ID: {$id}";
	}
}