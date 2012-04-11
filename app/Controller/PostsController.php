<?php
class PostsController extends AppController {
	public $helpers = array('Html', 'Form');
	public $paginate = array(
		'joins' => array(
			array(
				'table' => 'users',
				'alias' => 'User',
				'type' => 'LEFT',
				'conditions' => array(
					'Post.uid = User.id'
				)
			)
		),
		'fields' => array(
			'Post.id',
			'Post.body',
			'Post.created',
			'Post.modified',
			'Post.uid',
			'User.id',
			'User.username'
		),
		'order' => array(
			'Post.id' => 'DESC'
		), 
		'limit' => 40
	);

	public function index() {
		$this->set('posts', $this->paginate());
	}

	public function view($id = null) {
		$this->Post->id = $id;

		if(!$this->Post->exists())
			throw new NotFoundException('Invalid Post Number');

		$this->set('post', $this->Post->read());
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->request->data['Post']['uid'] = $this->Auth->user('id');
			if ($this->Post->save($this->request->data)) {
				$this->Session->setFlash('Your post has been saved.');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Unable to add your post.');
			}
		}
	}

	public function edit($id = null) {
		$this->Post->id = $id;
		if ($this->request->is('get')) {
			$this->request->data = $this->Post->read();
		} else {
			if ($this->Post->save($this->request->data)) {
				$this->Session->setFlash('Your post has been updated.');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Unable to update your post.');
			}
		}
	}

	public function delete($id) {
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		if ($this->Post->delete($id)) {
			$this->Session->setFlash('The post with id: ' . $id . ' has been deleted.');
			$this->redirect(array('action' => 'index'));
		}
	}

	public function isAuthorized($user) {
		$postId = -1;
		if(!empty($this->request->params['pass']))
			$postId = $this->request->params['pass'][0];

		if ($this->action === 'add')
			return true;

		if (in_array($this->action, array('edit', 'delete'))) {
			if ($this->Post->isOwnedBy($postId, $user['id']))
				return true;
		}

		return parent::isAuthorized($user);
	}
}