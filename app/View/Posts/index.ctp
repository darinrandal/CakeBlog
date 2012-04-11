<p><?php echo $this->Html->link('Add Post', array('action' => 'add')); ?></p>
<?php echo $this->Paginator->numbers(); ?>
<table>
    <tr>
        <th>Username</th>
        <th>Post</th>
        <th>Actions</th>
        <th>Created</th>
    </tr>

    <?php foreach ($posts as $post): ?>
    <tr>
        <td><?php echo $this->Html->link($post['User']['username'], array('controller' => 'users', 'action' => 'view', $post['User']['id'])); ?></td>
        <td>
            <?php echo nl2br($post['Post']['body']); ?>
        </td>
        <td>
            <?php echo $this->Form->postLink(
                'Delete',
                array('action' => 'delete', $post['Post']['id']),
                array('confirm' => 'Are you sure?'));
            ?>
            <?php echo $this->Html->link('Edit', array('action' => 'edit', $post['Post']['id']));?>
        </td>
        <td>
            <?php echo $this->Html->link($post['Post']['created'], array('action' => 'view', $post['Post']['id'])); ?>
        </td>
    </tr>
    <?php endforeach; ?>

</table>
<?php echo $this->Paginator->numbers(); ?>