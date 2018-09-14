<?php

/*
 * Symfony DataTables Bundle
 * (c) Omines Internetbureau B.V. - https://omines.nl/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Omines\DataTablesBundle\Filter;

use Doctrine\ORM\QueryBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractFilter
{
    /** @var string */
    protected $template_html;

    /** @var string */
    protected $template_js;

    /** @var string */
    protected $operator;

    /** @var callable */
    protected $query;

    /**
     * @param array $options
     */
    public function set(array $options)
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);

        foreach ($resolver->resolve($options) as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * @param OptionsResolver $resolver
     * @return $this
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'template_html' => null,
                'template_js'   => null,
                'operator'      => '=',
                'query'         => null,
            ]
        );

        return $this;
    }

    /**
     * @return string
     */
    public function getTemplateHtml()
    {
        return $this->template_html;
    }

    /**
     * @return string
     */
    public function getTemplateJs()
    {
        return $this->template_js;
    }

    /**
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    abstract public function isValidValue($value): bool;

    public static function factory($options = [])
    {
        $object = new static;
        $object->set($options);

        return $object;
    }

    /**
     * @return callable
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param callable $query
     */
    public function setQuery(callable $query): void
    {
        $this->query = $query;
    }
}
