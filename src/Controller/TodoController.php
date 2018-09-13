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
        $this->request->allowMethod(['GET']);
        $todos = $this->Todo->find('all');
        $this->set([
            'todos' => $todos,
            '_serialize' => ['todos']
        ]);
    }

    public function add()
    {
        $this->request->allowMethod(['POST']);
        $todo = $this->Todo->newEntity($this->request->getData());
        $message = 'Error';

        if ($this->Todo->save($todo)) {
            $message = 'Saved';
            $this->response = $this->response->withStatus(201);
        }

        $this->set([
            'message' => $message,
            'todo' => $todo,
            '_serialize' => ['message', 'todo']
        ]);
    }

    public function edit($id)
    {
        if (!($this->request->is(['PATCH', 'PUT']))) {
            return;
        }

        $todo = $this->Todo->get($id);
        $todoPatched = $this->Todo->patchEntity($todo, $this->request->getData());
        $message = 'Error';
        $this->response = $this->response->withStatus(400);

        if ($this->Todo->save($todoPatched)) {
            $message = 'Edited';
            $this->response = $this->response->withStatus(200);
        }

        $this->set([
            'message' => $message,
            'todo' => $todoPatched,
            '_serialize' => ['message', 'todo']
        ]);
    }

    public function delete($id)
    {
        $this->request->allowMethod(['DELETE']);
        $todo = $this->Todo->get($id);

        if (!$this->Todo->delete($todo)) {
            $this->response = $this->response->withStatus(400);
        }

        $this->response = $this->response->withStatus(204);
    }
}
