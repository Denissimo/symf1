<?php

namespace App;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraint;
use App\Exceptions\DefaultException;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use Symfony\Component\Validator\Validation;
use App\Proxy;

class Validator
{
    /**
     * Проверка обязательных для заполнения полей
     *
     * @param array $data
     * @param array $required
     * @param string $message
     * @param string|callable $exception
     */
    public function validateRequired(
        array $data,
        array $required,
        $message = null,
        $exception = DefaultException::class
    ) {
        $fields = [];

        foreach ($required as $field) {
            $fields[$field] = new Assert\NotBlank();
        }

        $validator = new Assert\Collection([
            'fields' => $fields,
            'allowExtraFields' => true,
        ]);

        $this->validate($data, $validator, $message, $exception);
    }

    /**
     * Проверка, что переданные параметры соответствуют определенному типу
     *
     * @param array $data
     * @param array $types
     * @param string $message
     * @param string|callable $exception
     */
    public function validateType(
        array $data,
        array $types,
        $message = null,
        $exception = DefaultException::class
    ) {
        $validator = new Assert\Collection([
            'fields' => $types,
            'allowMissingFields' => true,
            'allowExtraFields' => true,
        ]);

        $this->validate($data, $validator, $message, $exception);
    }

    /**
     * Проверка, что переданные параметры соответствуют определенному типу и являются обязательными для заполнения
     *
     * @param array $data
     * @param array $types
     * @param string $message
     * @param string|callable $exception
     */
    public function validateTypeRequired(
        array $data,
        array $types,
        $message = null,
        $exception = DefaultException::class
    ) {
        $validator = new Assert\Collection([
            'fields' => $types,
            'allowMissingFields' => false,
            'allowExtraFields' => true,
        ]);

        $this->validate($data, $validator, $message, $exception);
    }

    /**
     * Валидация в соответствии с Symfony-валидаторами
     *
     * @param mixed $data
     * @param Constraint|Constraint[] $validator
     * @param string $message
     * @param string|callable $exception
     */
    public function validate(
        $data,
        $validator,
        $message = null,
        $exception = DefaultException::class
    ) {
        if (!is_string($exception) && !is_callable($exception)) {
            throw new \InvalidArgumentException(
                sprintf('Argument %s is not type string or callable', $exception)
            );
        }

        /** @var ValidatorInterface $baseValidator */
        $baseValidator = Validation::createValidator();
        $errors = $baseValidator->validate($data, $validator);

        if (count($errors) !== 0) {
            if (is_callable($exception)) {
                call_user_func(
                    $exception,
                    $errors[0]->getPropertyPath(),
                    $errors[0]->getMessage()
                );
            }

            throw new $exception(
                $message ?? $errors[0]->getPropertyPath() . ': ' . $errors[0]->getMessage()
            );
        }

    }
}