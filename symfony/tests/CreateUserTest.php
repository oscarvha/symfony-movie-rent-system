<?php

namespace App\Tests;

use App\Entity\User;
use App\Entity\ValueObject\PasswordEncoded;
use App\Entity\ValueObject\Roles;
use App\Form\Type\CreateUserType;
use App\Kernel;
use App\Service\DTO\UserCreateDTO;
use App\Service\Handler\CreateUserHandler;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Form\Test\TypeTestCase;

class CreateUserTest extends KernelTestCase
{
    public function testSubmitValidData(): void
    {
        $formData = [
            'username' => 'oscartest',
            'password' => 'test',
            'email' => 'oscartests@gmail.com',
            'passwordPlain' => 'extremusica',
            'role' => Roles::USER
        ];

        $password = new PasswordEncoded('extremusica');
        $role = new Roles([Roles::USER]);

        $userForm = new User('oscar','oscartests@gmail.com',$password,$role);

        static::bootKernel();
        $userCreateDTO =  new UserCreateDTO('','','','');

        $form = $this->factory->create(CreateUserType::class, $userCreateDTO);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

    }
}
