<?php
/**
 * Contacts repository.
 */

namespace App\Repository;

/**
 * Class ContactRepository.
 */
class ContactRepository
{
    /**
     * Data.
     *
     * @var array
     */
    private $data = [
        1 => [
            'id' => 1,
            'name' => 'John',
            'surname' => 'Smith',
            'nick' => 'Johnny',
            'phone_number' => '123456789',
            'birth_date' => '12.02.1958',
        ],
        2 => [
            'id' => 2,
            'name' => 'Mariusz',
            'surname' => 'Templariusz',
            'nick' => '',
            'phone_number' => '123456789',
            'birth_date' => '12.02.1958',
        ],
        3 => [
            'id' => 3,
            'name' => 'Mathew',
            'surname' => 'Carter',
            'nick' => 'Slim',
            'phone_number' => '123456789',
            'birth_date' => '12.02.1958',
        ],
        4 => [
            'id' => 4,
            'name' => 'Hugh',
            'surname' => 'Janus',
            'nick' => 'Choco',
            'phone_number' => '123456789',
            'birth_date' => '12.02.1958',
        ],
        5 => [
            'id' => 5,
            'name' => 'Eric',
            'surname' => 'Shawn',
            'nick' => '',
            'phone_number' => '123456789',
            'birth_date' => '12.02.1958',
        ],
        6 => [
            'id' => 6,
            'name' => 'Mike',
            'surname' => 'Hawk',
            'nick' => 'Johnny',
            'phone_number' => '123456789',
            'birth_date' => '12.02.1958',
        ],
        7 => [
            'id' => 7,
            'name' => 'Hugh',
            'surname' => 'Jass',
            'nick' => 'Johnny',
            'phone_number' => '123456789',
            'birth_date' => '12.02.1958',
        ],
        8 => [
            'id' => 8,
            'name' => 'Chris',
            'surname' => 'Peacock',
            'nick' => 'Crispy',
            'phone_number' => '123456789',
            'birth_date' => '12.02.1958',
        ],
        9 => [
            'id' => 9,
            'name' => 'Moe',
            'surname' => 'Lester',
            'nick' => 'Dude',
            'phone_number' => '123456789',
            'birth_date' => '12.02.1958',
        ],
        10 => [
            'id' => 10,
            'name' => 'Gabe',
            'surname' => 'Itch',
            'nick' => 'Pony',
            'phone_number' => '123456789',
            'birth_date' => '12.02.1958',
        ],
    ];

    /**
     * Find all.
     *
     * @return array Result
     */
    public function findAll(): array
    {
        return $this->data;
    }

    /**
     * Find one by Id.
     *
     * @param int $id Id
     *
     * @return array|null Result
     */
    public function findById(int $id): ?array
    {
        return isset($this->data[$id]) && count($this->data)
            ? $this->data[$id] : null;
    }
}
