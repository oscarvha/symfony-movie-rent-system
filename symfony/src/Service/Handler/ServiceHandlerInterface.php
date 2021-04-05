<?php

namespace App\Service\Handler;

use App\Service\DTO\DTOInterface;

interface ServiceHandlerInterface
{
    /**
     * @param DTOInterface $dto
     *
     * @return mixed
     */
    public function handle(DTOInterface $dto);
}
