<?php use Cake\Routing\Router; ?>
<article class="content forms-page">
    <div class="title-block">
        <h3 class="title">
    		Profile (Login Password)
    	</h3>
        <p class="title-description"> All fields are required </p>
    </div>
    <section class="section">
        <div class="row sameheight-container">
            <div class="col-md-6">
                <div class="card card-block sameheight-item">
                    <div class="title-block">
                        <h3 class="title">
                            Account Details
                        </h3>
                    </div>
                    <?php echo $this->Flash->render(); ?>
                    <?php echo $this->Form->create($password,['role' => 'form', 'novalidate' => 'novalidate']); ?>

                        <div class="form-group <?php if($this->Form->isFieldError('old_password')): echo 'has-error'; else: echo 'has-success'; endif; ?>">
                            <?php echo $this->Form->input('old_password', ['type' => 'password', 'required' => true, 'class' => 'form-control underlined', 'label' => ['text' => 'Current Password','class' => 'control-label'], 'error' => false]);
                                echo $this->Form->error('old_password', null); ?>
                        </div>

                        <div class="form-group <?php if($this->Form->isFieldError('new_password')): echo 'has-error'; else: echo 'has-success'; endif; ?>">
                            <?php echo $this->Form->input('new_password', ['type' => 'password', 'required' => true, 'class' => 'form-control underlined', 'label' => ['text' => 'New Passsword','class' => 'control-label'], 'error' => false]);
                                echo $this->Form->error('new_password', null); ?>
                        </div>

                        <div class="form-group <?php if($this->Form->isFieldError('confirm_password')): echo 'has-error'; else: echo 'has-success'; endif; ?>">
                            <?php echo $this->Form->input('confirm_password', ['type' => 'password', 'required' => true, 'class' => 'form-control underlined', 'label' => ['text' => 'Confirm Passsword','class' => 'control-label'], 'error' => false]);
                                echo $this->Form->error('confirm_password', null); ?>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-10">
                                <?php echo $this->Form->button('Update',['class' => 'btn btn-success', 'type' => 'submit' ]); ?>
                            </div>
                        </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card sameheight-item">
                    <div class="card-block">
                        <!-- Nav tabs -->
                        <div class="card-title-block">
                            <h3 class="title">
                                Note
                            </h3>
                        </div>
                        <ul class="nav nav-tabs nav-tabs-bordered">
                            <li class="nav-item"> <a href="#home" class="nav-link active" data-target="#home" data-toggle="tab" aria-controls="home" role="tab">Password</a> </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabs-bordered">
                            <div class="tab-pane fade in active" id="home">
                                <h4>Account Details</h4>
                                <p>Use a good combition of letters and numbers for a strong password as this is an Admin Account. This account can change the whole websites dynamic data.</p>
                                <p>
                                    To change the Profile details open: 
                                    <?php echo $this->Html->link(
                                                'Change Profile',
                                                ['controller' => 'AdminDetails', 'action' => 'profile', '_full' => true]
                                            ); ?>
                                </p>
                                <p>
                                    To change the login email id open: 
                                    <?php echo $this->Html->link(
                                                'Change Login Email',
                                                ['controller' => 'AdminDetails', 'action' => 'loginEmail', '_full' => true]
                                            ); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-block -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
</article>