<?php

use Phalcon\Http\Response;
use Phalcon\Http\Request;

class CurlController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {


    }

    public function getAction()
    {
        $this->view->disable();
        //$request = $this->getDI()->get('request');
        $phql = 'SELECT * FROM Characters ORDER BY id';
        $characters = $this->modelsManager->executeQuery($phql);
        $data = [];
        foreach ($characters as $character){
            $data[] = [
                'id'   => $character->id,
                'name' => $character->name,
                'race' => $character->race,
            ];
        }
        return json_encode($data);
    }

    public function postAction()
    {
        $this->view->disable();
        //$request = new Request;
        $data = $this->request->getRawBody();
        $character = json_decode($data);

        $phql = 'INSERT INTO Characters (id, name, race) VALUES (:id:, :name:, :race:)';
        $status = $this->modelsManager->executeQuery(
            $phql,
            [

                'id'   => $character->id,
                'name' => $character->name,
                'race' => $character->race

            ]
        );

        $response = new Response();

        if ($status->success() === true) {

            $response->setStatusCode(201, 'Creado');

            $character->id = $status->getModel()->id;

            $response->setJsonContent(
                [
                    'status' => 'OK',
                    'data'   => $character,
                ]
            );
        } else {

            $response->setStatusCode(409, 'Conflicto');

            $errors = [];

            foreach ($status->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }

            $response->setJsonContent(
                [
                    'status'   => 'ERROR',
                    'messages' => $errors,
                ]
            );
        }

        return $response;

    }
    public function putAction()
    {
        $this->view->disable();
        //$request = new Request;
        $data = $this->request->getRawBody();
        $character = json_decode($data);
        global $id;
        $id = $this->dispatcher->getParam('param');


        $phql = 'UPDATE Characters SET name = :name:, race = :race: WHERE id = :id:';
        $status = $this->modelsManager->executeQuery(
            $phql,
            [

                'name'  => $character->name,
                'race'  => $character->race,
                'id'    => $id

            ]
        );

        $response = new Response();

        if ($status->success() === true) {

            $response->setStatusCode(201, 'Creado');

            $character->id = $status->getModel()->id;

            $response->setJsonContent(
                [
                    'status' => 'OK',
                ]
            );
        } else {

            $response->setStatusCode(409, 'Conflicto');

            $errors = [];

            foreach ($status->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }

            $response->setJsonContent(
                [
                    'status'   => 'ERROR',
                    'messages' => $errors,
                ]
            );
        }

        return $response;

    }

    public function deleteAction()
    {
        $this->view->disable();
        //$request = new Request;
        $data = $this->request->getRawBody();
        $character = json_decode($data);
        global $id;
        $id = $this->dispatcher->getParam('param');

        $phql = 'DELETE FROM Characters WHERE id = :id:';
        $status = $this->modelsManager->executeQuery(
            $phql,
            [
                'id'    => $id
            ]
        );

        $response = new Response();

        if ($status->success() === true) {

            $response->setStatusCode(201, 'Creado');

            $character->id = $status->getModel()->id;

            $response->setJsonContent(
                [
                    'status' => 'OK',
                ]
            );
        } else {

            $response->setStatusCode(409, 'Conflicto');

            $errors = [];

            foreach ($status->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }

            $response->setJsonContent(
                [
                    'status'   => 'ERROR',
                    'messages' => $errors,
                ]
            );
        }

        return $response;

    }

}

