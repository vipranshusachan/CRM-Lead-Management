<?php

declare(strict_types=1);

namespace App\Core;

class Validator
{
    private array $data;
    private array $errors = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function validate(array $rules): bool
    {
        $this->errors = [];

        foreach ($rules as $field => $fieldRules) {
            $value = $this->data[$field] ?? null;
            $ruleList = is_string($fieldRules) ? explode('|', $fieldRules) : $fieldRules;

            foreach ($ruleList as $rule) {
                $params = [];
                if (str_contains($rule, ':')) {
                    [$ruleName, $paramStr] = explode(':', $rule, 2);
                    $params = explode(',', $paramStr);
                } else {
                    $ruleName = $rule;
                }

                $this->applyRule($field, $value, $ruleName, $params);
            }
        }

        return empty($this->errors);
    }

    private function applyRule(string $field, mixed $value, string $ruleName, array $params): void
    {
        $fieldName = ucfirst(str_replace('_', ' ', $field));

        switch ($ruleName) {
            case 'required':
                if ($value === null || $value === '' || (is_array($value) && empty($value))) {
                    $this->addError($field, "{$fieldName} is required.");
                }
                break;

            case 'email':
                if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($field, "{$fieldName} must be a valid email address.");
                }
                break;

            case 'min':
                $min = (int) ($params[0] ?? 0);
                if (!empty($value) && strlen((string)$value) < $min) {
                    $this->addError($field, "{$fieldName} must be at least {$min} characters.");
                }
                break;

            case 'max':
                $max = (int) ($params[0] ?? 255);
                if (!empty($value) && strlen((string)$value) > $max) {
                    $this->addError($field, "{$fieldName} may not be greater than {$max} characters.");
                }
                break;

            case 'in':
                if (!empty($value) && !in_array($value, $params, true)) {
                    $allowed = implode(', ', $params);
                    $this->addError($field, "{$fieldName} must be one of the following: {$allowed}.");
                }
                break;

            case 'numeric':
                if (!empty($value) && !is_numeric($value)) {
                    $this->addError($field, "{$fieldName} must be a number.");
                }
                break;

            case 'phone':
                if (!empty($value) && !preg_match('/^[0-9\-\+\s\(\)]{7,20}$/', (string)$value)) {
                    $this->addError($field, "{$fieldName} must be a valid phone number.");
                }
                break;

            case 'unique':
                if (!empty($value)) {
                    $table = $params[0] ?? '';
                    $column = $params[1] ?? $field;
                    $exceptId = $params[2] ?? null;

                    $sql = "SELECT COUNT(*) as count FROM `{$table}` WHERE `{$column}` = ?";
                    $queryParams = [$value];

                    if ($exceptId !== null) {
                        $sql .= " AND `id` != ?";
                        $queryParams[] = $exceptId;
                    }

                    $result = Database::fetch($sql, $queryParams);
                    if ($result && (int)$result['count'] > 0) {
                        $this->addError($field, "{$fieldName} is already taken.");
                    }
                }
                break;
        }
    }

    private function addError(string $field, string $message): void
    {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }
        $this->errors[$field][] = $message;
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function firstError(): ?string
    {
        foreach ($this->errors as $fieldErrors) {
            return $fieldErrors[0] ?? null;
        }
        return null;
    }
}
