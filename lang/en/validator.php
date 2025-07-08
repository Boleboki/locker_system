<?php

return [
    "username" => [
        "empty" => "Username cannot be empty.",
        "length" => "Username must be between :min and :max characters.",
        "forbidden_characters" => "Username contains forbidden characters.",
        "exists" => "Username already exists"
    ],
    "password" => [
        "empty" => "Password cannot be empty.",
        "min_length" => "Password must be at least :min characters long.",
        "forbidden_characters" => "Password contains forbidden characters.",
        "equals" => "Passwords do not match.",

    ],
    'notEmpty'         => 'This field cannot be empty.',
    'email'            => 'The email address is not valid.',
    'ip'               => 'The IP address is not valid.',
    'intVal'           => 'The value must be an integer.',
    'alnum'            => 'Only letters and numbers are allowed.',
    'length'           => 'The field must be between {{minValue}} and {{maxValue}} characters.',
    'numericVal'       => 'The field must be a number.',
    'min'              => 'The number must be greater than or equal to {{compareTo}}.',
    'max'              => 'The number must be less than or equal to {{compareTo}}.',
    'alnum'            => 'The field must contain only letters and numbers.',
    'intVal'           => 'The field must contain only whole numbers.',
    'intCommaSeparator' => 'The field must be in the correct format (e.g. 123,412,512).',
    'specialCharacters' => "The field cannot contain special characters.",
    'DBduplicate' => 'Ovaj podatak već postoji.',

];
