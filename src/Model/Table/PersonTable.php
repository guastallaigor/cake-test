<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Validation\Validation;
use Cake\Chronos\Chronos;
use App\Model\Entity\Pessoa;

class PessoaTable extends Table
{
    private $PessoaEntity;
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        $this->setSchemaTable($config, 'person');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        // $this->addBehavior('CookFields');

        $this->hasOne('Profession', [
            'foreignKey' => ['profession_id'],
        ]);

        $this->PessoaEntity = new Pessoa();
    }

    public function getPersonByName($name) {
        return $this->find('all', [
            'fields'=>['name'],
            'conditions'=>[
                'name like '=>'%'.$name.'%',
            ]
        ])->toArray();
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->requirePresence('name')
            ->notEmpty('name', 'Please fill this field')
            ->add('name', [
                'length' => [
                    'rule' => ['minLength', 2],
                    'message' => 'Name need to be at least 2 characters long',
                ]
            ]);

        $validator
            ->requirePresence('surname')
            ->notEmpty('surname', 'Please fill this field')
            ->add('surname', [
                'length' => [
                    'rule' => ['minLength', 2],
                    'message' => 'Surname need to be at least 2 characters long',
                ]
            ]);

        $validator
            ->requirePresence('email')
            ->notEmpty('email', 'Please fill this field')
            ->add('email', [
                'rule' => 'email',
                'message' => 'E-mail must be valid',
            ]);

        $validator
            ->requirePresence('gender')
            ->notEmpty('gender', 'Please fill this field')
            ->add('gender', [
                'gender' => [
                    'rule' => ['inList', ['F', 'M'], false]
                    'message' => 'Please select a gender',
                ]
            ]);

        $validator
            ->requirePresence('graduation')
            ->allowEmpty('graduation');

        $validator
            ->requirePresence('state')
            ->notEmpty('state', 'Please fill this field')
            ->add('state', [
                'state' => [
                    'rule' => ['minLength', 2]
                    'message' => 'Please select a state',
                ]
            ]);

        $validator
            ->requirePresence('city')
            ->notEmpty('city', 'Please fill this field')
            ->add('city', [
                'city' => [
                    'rule' => ['minLength', 2]
                    'message' => 'Please select a city',
                ]
            ]);

        return $validator;
    }
}
