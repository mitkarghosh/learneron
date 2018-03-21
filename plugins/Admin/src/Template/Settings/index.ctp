<?php use Cake\Routing\Router;?>
<article class="content icons-page">
    <div class="title-block">
        <h3 class="title">
            Website Settings
        </h3>
    </div>
    <section class="section" id="section_1">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block">
                        <div class="card-title-block">
                            <h3 class="title">
                                Common Settings
                            </h3>
                        </div>
                        <section class="section">
                        <?php echo $this->Flash->render('common'); ?>
                        <?php echo $this->Form->create($commonSettings,['id' => 'login-form','url' => array('plugin' => 'admin', 'controller' => 'settings', 'action' => 'index'),'role' => 'form', 'novalidate' => 'novalidate']); ?>
                                <div class="row">
                                    <div class="col-md-12 col-sm-4">
                                        <div class="row">
                                            <label for="email" class="col-sm-4 form-control-label">Email:</label>
                                           <div class="form-group col-sm-5 <?php if($this->Form->isFieldError('email')): echo 'has-error'; else: echo 'has-success'; endif; ?>">
                                                <?php echo $this->Form->input('email', ['required' => true, 'class' => 'form-control boxed', 'label' => false]);?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-4">
                                        <div class="form-group row">
                                            <label for="phone_number" class="col-sm-4 form-control-label">Phone Number:</label>
                                            <div class="form-group col-sm-5 <?php if($this->Form->isFieldError('phone_number')): echo 'has-error'; else: echo 'has-success'; endif; ?>">
                                                <?php echo $this->Form->input('phone_number', ['required' => true, 'class' => 'form-control boxed', 'label' => false]);?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-4">
                                        <div class="form-group row">
                                            <label for="address" class="col-sm-4 form-control-label">Address:</label>
                                            <div class="form-group col-sm-5 <?php if($this->Form->isFieldError('address')): echo 'has-error'; else: echo 'has-success'; endif; ?>">
                                                <?php echo $this->Form->input('address', ['type'=>'textarea' ,'required' => false, 'class' => 'form-control boxed', 'label' => false]);?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-4">
                                        <div class="form-group row">
                                            <label for="facebook_link" class="col-sm-4 form-control-label">Facebook Link:</label>
                                            <div class="form-group col-sm-5 <?php if($this->Form->isFieldError('facebook_link')): echo 'has-error'; else: echo 'has-success'; endif; ?>">
                                                <?php echo $this->Form->input('facebook_link', ['required' => true, 'class' => 'form-control boxed', 'label' => false]); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-4">
                                        <div class="form-group row">
                                            <label for="twitter_link" class="col-sm-4 form-control-label">Twitter Link:</label>
                                            <div class="form-group col-sm-5 <?php if($this->Form->isFieldError('twitter_link')): echo 'has-error'; else: echo 'has-success'; endif; ?>">
                                                <?php echo $this->Form->input('twitter_link', ['required' => true, 'class' => 'form-control boxed', 'label' => false]);?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-4">
                                        <div class="form-group row">
                                            <label for="google_plus_link" class="col-sm-4 form-control-label">Google Plus:</label>
                                            <div class="form-group col-sm-5 <?php if($this->Form->isFieldError('google_plus_link')): echo 'has-error'; else: echo 'has-success'; endif; ?>">
                                                <?php echo $this->Form->input('google_plus_link', ['required' => true, 'class' => 'form-control boxed', 'label' => false]); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-4">
                                        <div class="form-group row">
                                            <label for="linkedin" class="col-sm-4 form-control-label">Linkedin:</label>
                                            <div class="form-group col-sm-5 <?php if($this->Form->isFieldError('linkedin')): echo 'has-error'; else: echo 'has-success'; endif; ?>">
                                                <?php echo $this->Form->input('linkedin', ['required' => true, 'class' => 'form-control boxed', 'label' => false]); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="row">
                                    <div class="col-md-12 col-sm-4">
                                        <div class="form-group row">
                                            <label for="linkedin" class="col-sm-4 form-control-label">Allow automatic "Question" approval?</label>
                                            <div class="form-group col-sm-5 <?php if($this->Form->isFieldError('question_approval')): echo 'has-error'; else: echo 'has-success'; endif; ?>">
                                                <input type="checkbox" name="question_approval" value="1" <?php if($commonSettings->question_approval==1){ echo 'checked'; } ?> /> Yes
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-4">
                                        <div class="form-group row">
                                            <label for="linkedin" class="col-sm-4 form-control-label">Allow automatic "Question answer" approval?</label>
                                            <div class="form-group col-sm-5 <?php if($this->Form->isFieldError('question_answer_approval')): echo 'has-error'; else: echo 'has-success'; endif; ?>">
                                                <input type="checkbox" name="question_answer_approval" value="1" <?php if($commonSettings->question_answer_approval==1){ echo 'checked'; } ?> /> Yes
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<div class="row">
                                    <div class="col-md-12 col-sm-4">
                                        <div class="form-group row">
                                            <label for="linkedin" class="col-sm-4 form-control-label">Allow automatic "Question comment" approval?</label>
                                            <div class="form-group col-sm-5 <?php if($this->Form->isFieldError('question_comment_approval')): echo 'has-error'; else: echo 'has-success'; endif; ?>">
                                                <input type="checkbox" name="question_comment_approval" value="1" <?php if($commonSettings->question_comment_approval==1){ echo 'checked'; } ?> /> Yes
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<div class="row">
                                    <div class="col-md-12 col-sm-4">
                                        <div class="form-group row">
                                            <label for="linkedin" class="col-sm-4 form-control-label">Allow automatic "Answer comment" approval?</label>
                                            <div class="form-group col-sm-5 <?php if($this->Form->isFieldError('answer_comment_approval')): echo 'has-error'; else: echo 'has-success'; endif; ?>">
                                                <input type="checkbox" name="answer_comment_approval" value="1" <?php if($commonSettings->answer_comment_approval==1){ echo 'checked'; } ?> /> Yes
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<div class="row">
                                    <div class="col-md-12 col-sm-4">
                                        <div class="form-group row">
                                            <label for="linkedin" class="col-sm-4 form-control-label">Allow automatic "News comment" approval?</label>
                                            <div class="form-group col-sm-5 <?php if($this->Form->isFieldError('news_comment_approval')): echo 'has-error'; else: echo 'has-success'; endif; ?>">
                                                <input type="checkbox" name="news_comment_approval" value="1" <?php if($commonSettings->news_comment_approval==1){ echo 'checked'; } ?> /> Yes
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php /*<div class="row">
                                    <div class="col-md-12 col-sm-4">
                                        <div class="form-group row">
                                            <label for="footer_text" class="col-sm-4 form-control-label">Footer Text:</label>
                                            <div class="form-group col-sm-5 <?php if($this->Form->isFieldError('footer_text')): echo 'has-error'; else: echo 'has-success'; endif; ?>">
                                                <?php echo $this->Form->input('footer_text', ['required' => true, 'class' => 'form-control boxed', 'label' => false, 'error' => false]);
                                                    echo $this->Form->error('footer_text', null); ?>
                                            </div>
                                        </div>
                                        <div>
                                            Note:
                                            <ul>
                                                <li>
                                                    To show the copyright sign(&copy;) use: "<?php echo htmlentities('&copy;'); ?>"
                                                </li>
                                                <li>
                                                    To show current year(<?php echo date('Y'); ?>) use: "{@year}"
                                                </li>
                                            </ul>
                                        </div>
                                    </div>*/ ?>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-4">
                                        <div class="form-group row">
                                            <div class="col-sm-9">
                                                <?php echo $this->Form->button('Save',['class' => 'form-control btn btn-success', 'type'=>'submit' ]); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php echo $this->Form->end(); ?>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>
</article>