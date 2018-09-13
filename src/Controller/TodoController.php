<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

class TodoController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function index()
    {
        $todos = $this->Todo->find('all');
        $this->set([
            'todos' => $todos,
            '_serialize' => ['todos']
        ]);
    }

    public function add()
    {
        $todo = $this->Todo->newEntity($this->request->getData());
        $message = 'Error';

        if ($this->Todo->save($todo)) {
            $message = 'Saved';
        }

        $this->set([
            'message' => $message,
            'recipe' => $todo,
            '_serialize' => ['message', 'recipe']
        ]);
    }

    public function edit($id)
    {
        $todo = $this->Todo->get($id);

        if ($this->request->is(['post', 'put'])) {
            $todo = $this->Todo->patchEntity($todo, $this->request->getData());
            $message = 'Error';

            if ($this->Todo->save($todo)) {
                $message = 'Saved';
            }
        }
        $this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);
    }

    public function delete($id)
    {
        $todo = $this->Todo->get($id);
        $message = 'Deleted';

        if (!$this->Todo->delete($todo)) {
            $message = 'Error';
        }

        $this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);
    }
}
