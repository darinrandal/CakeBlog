<div class="users form">
<?php echo $this->Form->create('User');?>
    <fieldset>
        <legend>Add User</legend>
    <?php
        echo $this->Form->input('username');
        echo $this->Form->input('password');
        echo $this->Form->input('email');
        echo $this->Form->input('invitekey', array('label' => 'Invite Key'));
    ?>
    </fieldset>
<?php echo $this->Form->end('Submit');?>
</div>