<?php

namespace Bsapaka\WorkflowBundle;

use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfigOptionsResolver implements ConfigOptionsResolverInterface
{

    protected $resolver;

    /**
     * ConfigOptionsResolver constructor.
     */
    public function __construct()
    {
        $this->resolver = new OptionsResolver();
        $this->configureResolver($this->resolver);
    }

    /**
     * @param array $options
     * @return array
     */
    public function resolve(array $options = [])
    {
        return $this->resolver->resolve($options);
    }

    /**
     * @param array $parentOptions
     * @param array $originalOptions
     * @return array
     */
    public function inherit(array $parentOptions, array $originalOptions)
    {
        $nullOriginals = array_filter($originalOptions, function ($originalOption) {
            return null === $originalOption;
        });

        $nonNullParents = array_filter($parentOptions, function ($parentOption) {
            return null !== $parentOption;
        });

        foreach ($nullOriginals as $key => $nullOriginal) {
            if (array_key_exists($key, $nonNullParents)) {
                $nullOriginals[$key] = $nonNullParents[$key];
            }
        }

        $newOptions = array_merge($originalOptions, $nullOriginals);

        return $this->resolve($newOptions);

    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function configureResolver(OptionsResolver $resolver)
    {
        $this->defineOptions($resolver);

        $this->defineDefaults($resolver);

        $this->defineAllowedTypes($resolver);

        $resolver->setRequired('slug');
    }

    protected function defineOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined([
            'slug',
            'name',
            'template',
            'form_loader_class',
            'submit_handler_callable',
            'next_step_callable',
            'persistence_handler_class',
            'roles_whitelist',
            'roles_blacklist',
            'prerequisite_nodes'
        ]);
    }

    protected function defineDefaults(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'name' => null,
            'template' => null,
            'form_loader_class' => null,
            'submit_handler_callable' => null,
            'next_step_callable' => null,
            'persistence_handler_class' => null,
            'roles_whitelist' => null,
            'roles_blacklist' => null,
            'prerequisite_nodes' => []
        ]);
    }

    protected function defineAllowedTypes(OptionsResolver $resolver)
    {
        // TODO: allowed types
//        $resolver->setAllowedTypes([
//            'name' => ['string','NULL'],
//            'url_segment' => ['string','NULL'],
//            'template' => ['string','NULL'],
//            'form_loader_class'=> ['string','NULL'],
//            'submit_handler_callable' => ['callable','NULL'],
//            'next_step_callable' => ['callable', 'NULL'],
//            // 'persistence_handler_class'  => ? ,
//            'roles_whitelist'  => 'array',
//            'roles_blacklist'  => 'array',
//        ]);
    }

}