<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\TableView\Fields\Traits;


use Illuminate\Support\Arr;

trait TraitRules
{

    /**
     * Normalize and merge rules.
     * @param array $sourceOptions
     * @return array
     */
    protected function prepareRules(array &$sourceOptions = [])
    {
        $options = $this->options;

        // Normalize rules
        if (array_key_exists('rules_append', $sourceOptions)) {
            $sourceOptions['rules_append'] = $this->normalizeRules($sourceOptions['rules_append']);
        }

        if (array_key_exists('rules', $sourceOptions)) {
            $sourceOptions['rules'] = $this->normalizeRules($sourceOptions['rules']);
        }

        if (array_key_exists('rules', $options)) {
            $options['rules'] = $this->normalizeRules($options['rules']);
        }


        // Append rules
        if ($rulesToBeAppended = Arr::pull($sourceOptions, 'rules_append')) {
            $mergedRules = array_values(array_unique(array_merge($options['rules'], $rulesToBeAppended), SORT_REGULAR));
            $options['rules'] = $mergedRules;
        }

        return $options;
    }

    /**
     * Normalize the the given rule expression to an array.
     * @param mixed $rules
     * @return array
     */
    protected function normalizeRules($rules)
    {
        if (empty($rules)) {
            return [];
        }

        if (is_string($rules)) {
            return explode('|', $rules);
        }

        if (is_array($rules)) {
            $normalizedRules = [];
            foreach ($rules as $rule) {
                $normalizedRules[] = $this->normalizeRules($rule);
            }

            return array_values(array_unique(Arr::flatten($normalizedRules), SORT_REGULAR));
        }

        return $rules;
    }
}
