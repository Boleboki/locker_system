<?php
return [
    'page_title' => 'User List',

    'modal_delete' => [
        'title' => 'Delete Confirmation',
        'message' => 'Are you sure you want to delete user',
        'cancel' => 'Cancel',
        'confirm' => 'Delete',
    ],

    'table' => [
        'id' => 'ID',
        'username' => 'Username',
        'role' => 'Role',
        'active' => 'Active',
        'empty' => 'No users to display.',
    ],

    'roles' => [
        'admin' => 'Admin',
        'user' => 'User',
    ],

    'form' => [
        'edit_title' => 'Edit User',
        'create_title' => 'Add New User',

        'labels' => [
            'username' => 'Username',
            'password' => 'Password',
            'role' => 'Role',
            'active' => 'Active',
            'new_password' => 'New Password',
            'confirm_password' => 'Confirm Password',
        ],

        'buttons' => [
            'save_changes' => 'Save Changes',
            'save_user' => 'Save User',
            'reset_password' => 'Reset Password',
            'confirm_reset' => 'Confirm Reset',
        ],

        'modals' => [
            'reset_password_title' => 'Reset User Password',
        ],
    ],
];
