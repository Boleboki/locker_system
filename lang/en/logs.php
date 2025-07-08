<?php

return [
    'auth' => [
        'validation_failed' => 'Validation failed for user :username. Errors: :errors',
        'login_failed'      => 'Failed login attempt for user :username.',
        'login_success'     => 'User :username logged in successfully.',
        'logout_success'    => 'User :username logged out successfully.',
        'error_login'       => 'Error during login: :error',
        'error_logout'      => 'Error during logout: :error',
        'error_show_index'  => 'Error displaying login form: :error',
    ],

    'citaci' => [
        'error_show_index' => "Error displaying all scanners: :error",
        'error_get_all' => "Error retrieving all scanners: :error",
        'error_get_by_id' => "Error retrieving scanner with ID :id: :error",
        'not_found' => "Scanner with ID :id not found",
        'error_find' => "Error displaying scanner with ID :id: :error",
        'error_show_create' => "Error displaying scanner form: :error",
        'error_create' => "Error adding scanner: :error",
        'error_update' => "Error updating scanner with ID :id: :error",
        'error_delete' => "Error deleting scanner with ID :id: :error",
        'create_success' => "Successfully added new scanner: :citac",
        'update_success' => "Scanner with ID :id successfully updated",
        'delete_success' => "Scanner with ID :id successfully deleted",
        'missing_field' => "Missing required field: :field",
    ],

    'configuration' => [
        'error_get_all' => "Error loading all configurations: :error",
        'error_show_index' => "Error displaying all configurations: :error",
        'update_success' => "Configuration with key ':key' successfully updated to: :value",
        'error_update' => "Error updating configuration with key ':key': :error",
        'delete_success' => "Configuration with key ':key' successfully deleted",
        'error_delete' => "Error deleting configuration with key ':key': :error",
    ],

    'users' => [
        'error_show_index' => "Error displaying users: :error",
        'error_show_create' => "Error displaying user form: :error",
        'error_create' => "Error adding user: :error",
        'error_delete' => "Error deleting user with ID :id: :error",
        'error_update' => "Error updating user with ID :id: :error",
        'error_edit' => "Error displaying user for editing with ID :id: :error",
        'create_success' => "User :username successfully added",
        'delete_success' => "User :username successfully deleted",
        'update_success' => "User :username successfully updated",
        'not_found' => "User with ID :id not found",
        'exists' => "Attempt to add an existing user: :username",
        'validation_failed' => "Validation failed for user: :username. Errors: :errors",
        'error_get_by_id' => "Error retrieving user by ID :id: :error",
        'error_get_by_username' => "Error retrieving user by username ':username': :error",
        'error_get_all' => "Error retrieving all users: :error",
        'error_add' => "Error adding user ':username': :error",
        'error_delete_by_id' => "Error deleting user with ID :id: :error",
        'error_edit_by_id' => "Error updating user with ID :id: :error",
    ],

    'general' => [
        'invalid_data' => "Invalid data"
    ]
];
