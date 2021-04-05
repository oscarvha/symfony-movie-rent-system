<?php
/**
 * User: Oscar Sanchez
 * Date: 29/3/21
 */

namespace App\Service\Handler;


use App\Entity\User;
use App\Entity\ValueObject\PasswordEncoded;
use App\Entity\ValueObject\Roles;
use App\Exception\EmailAlreadyUsedException;
use App\Exception\UsernameAlreadyUsedException;
use App\Repository\UserRepositoryInterface;
use App\Service\DTO\CreateUserWithPasswordDTO;
use App\Service\DTO\DTOInterface;

class CreateUserHandler implements ServiceHandlerInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * CreateUserHandler constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param DTOInterface|CreateUserWithPasswordDTO $dto
     * @throws EmailAlreadyUsedException
     * @throws UsernameAlreadyUsedException
     */
    public function handle(DTOInterface $dto) : void
    {
        if ($this->userRepository->findByUsername($dto->getUsername())) {
            throw new UsernameAlreadyUsedException();
        }

        if ($this->userRepository->findByEmail($dto->getEmail())) {
            throw new EmailAlreadyUsedException();
        }
        $password = new PasswordEncoded($dto->getPlainPassword());
        $role =  new Roles([$dto->getRole()]);

        $user = new User(
            $dto->getUsername(),
            $dto->getEmail(),
            $password,
            $role
        );

        $this->userRepository->save($user);
    }
}