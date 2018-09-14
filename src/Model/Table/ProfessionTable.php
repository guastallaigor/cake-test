<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Validation\Validation;
use Cake\Chronos\Chronos;
use App\Model\Entity\Profession;

class ProfessionTable extends Table
{
    private $ProfessionEntity;
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

        $this->ProfessionEntity = new Profession();
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

        return $validator;
    }
}
