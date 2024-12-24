<?php

namespace App\Domain\Order\Validation;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class PostOrderValidator
{
    public function __construct(private readonly ValidatorInterface $validator)
    {
    }

    public function validate(mixed $data): ConstraintViolationListInterface
    {
        $constraints = new Assert\Collection([
            'product' => [
                new Assert\NotBlank(),
                new Assert\NotNull(),
                new Assert\Type(['string']),
            ],
            'qty' => [
                new Assert\NotBlank(),
                new Assert\NotNull(),
                new Assert\Type(['integer']),
                new Assert\Positive()
            ]
        ]);

        return $this->validator->validate($data, $constraints);
    }
}