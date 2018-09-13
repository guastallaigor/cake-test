<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Utility\Text;
use Cake\Validation\Validator;

class TodoTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
    }

    public function beforeSave($event, $entity, $options)
    {
        if ($entity->isNew() && !$entity->slug) {
            $sluggedTitle = Text::slug($entity->description);
            $entity->slug = substr($sluggedTitle, 0, 191);
        }
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->requirePresence('description')
            ->notEmpty('description', 'Please fill this field')
            ->add('description', [
                'length' => [
                    'rule' => ['minLength', 10],
                    'message' => 'Description need to be at least 10 characters long',
                ]
            ]);

        return $validator;
    }
}
