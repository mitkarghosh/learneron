<?php
use Cake\Routing\Router;
$session = $this->request->session();
$controller = strtolower ($this->request->params['controller']);
$action = strtolower ($this->request->action);
?>
<aside class="sidebar">
    <div class="sidebar-container">
        <div class="sidebar-header">
            <div class="brand">
                <a href="<?php echo Router::url('/admin/',true); ?>">
                    <img src="<?php echo Router::url("/admin/images/logo-innr.png",true); ?>" width="90%">
                </a>
            </div>
        </div>
        <nav class="menu">
            <ul class="nav metismenu" id="sidebar-menu">
                <!-- Dashboard start -->
                <li class="<?php if($this->request->params['controller'] == 'AdminDetails' && $this->request->params['action'] == 'dashboard'): echo "active"; endif; ?>">
                    <a href="<?php echo Router::url(['controller' => 'admin-details', 'action' => 'dashboard']); ?>"> <i class="fa fa-home"></i> Dashboard </a>
                </li>
                <!-- Dashboard end -->
				
                <!-- Admin Users start-->				
			<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('AdminDetails')))) ){?>
				<li class="<?php if($this->request->params['controller'] == 'AdminDetails' && $this->request->params['action'] != 'dashboard'): echo "active open"; endif; ?>">
                    <a href="<?php echo Router::url(['controller' => 'AdminDetails']); ?>">
                        <i class="fa fa-user fa-fw"></i>Manage Sub Admin <i class="fa arrow"></i>
                    </a>
					<ul>
					<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('AdminDetails'))) && $session->read('permissions.'.strtolower('AdminDetails').'.'.strtolower('list-sub-admin'))==1) ){?>
                        <li class="<?php if($this->request->params['controller'] == 'AdminDetails' && $this->request->params['action'] == 'list-sub-admin'): echo "active"; endif; ?>">
                            <a href="<?php echo Router::url(['controller' => 'AdminDetails', 'action' => 'list-sub-admin']); ?>">
								<i class="fa fa-list-alt"></i>&nbsp;
								View All
							</a>
                        </li>
					<?php } ?>
					<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('AdminDetails'))) && $session->read('permissions.'.strtolower('AdminDetails').'.'.strtolower('add-sub-admin'))==1) ){?>
                        <li class="<?php if($this->request->params['controller'] == 'AdminDetails' && $this->request->params['action'] == 'add-sub-admin'): echo "active"; endif; ?>">
                            <a href="<?php echo Router::url(['controller' => 'AdminDetails', 'action' => 'add-sub-admin']); ?>">
                                <i class="fa fa-plus"></i>&nbsp;
                                Add
                            </a>
                        </li>
					<?php } ?>
                    </ul>
                </li>
			<?php } ?>
                 <!--Admin Users end -->

                <!-- User Management start -->
			<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('Users')))) ){?>
                <li class="<?php if($this->request->params['controller'] == 'Users' && $this->request->params['action'] != 'dashboard'): echo "active open"; endif; ?>">
                    <a href="<?php echo Router::url(['controller' => 'users']); ?>">
                        <i class="fa fa-users"></i>
                        User Management
						<i class="fa arrow"></i>
                    </a>
					<ul>
					<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('Users'))) && $session->read('permissions.'.strtolower('Users').'.'.strtolower('list-data'))==1) ){?>
                        <li class="<?php if($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'listData'): echo "active"; endif; ?>">
                            <a href="<?php echo Router::url(['controller' => 'Users', 'action' => 'list-data']); ?>">
								<i class="fa fa-list-alt"></i>&nbsp;
								Registered Users
							</a>
                        </li>
						<li class="<?php if($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'listData'): echo "active"; endif; ?>">
                            <a href="<?php echo Router::url(['controller' => 'Users', 'action' => 'download-reports-non-registered-users']);?>">
								<i class="fa fa-list-alt"></i>&nbsp;
								Non-registered Users
							</a>
                        </li>
					<?php } ?>
					<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('Users'))) && $session->read('permissions.'.strtolower('Users').'.'.strtolower('add-user'))==1) ){?>
                        <li class="<?php if($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'add-user'): echo "active"; endif; ?>">
                            <a href="<?php echo Router::url(['controller' => 'Users', 'action' => 'add-user']); ?>">
                                <i class="fa fa-plus"></i>&nbsp;
                                Add
                            </a>
                        </li>
					<?php } ?>
                    </ul>
                </li>
			<?php } ?>
                <!-- User Management end -->
				
				<!-- Tags Management start -->
			<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('Tags')))) ){?>
                <li class="<?php if($this->request->params['controller'] == 'Tags'): echo "active open"; endif; ?>">
					<a href="">
                        <i class="fa fa-tag" aria-hidden="true"></i>
                        Tags Management
						<i class="fa arrow"></i>
                    </a>
                    <ul>
					<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('Tags'))) && $session->read('permissions.'.strtolower('Tags').'.'.strtolower('list-data'))==1) ){?>
                        <li class="<?php if($this->request->params['controller'] == 'Tags' && $this->request->params['action'] == 'listData'): echo "active"; endif; ?>">
                            <a href="<?php echo Router::url(['controller' => 'tags', 'action' => 'list-data']); ?>">
								<i class="fa fa-list-alt"></i>&nbsp;
								View All
							</a>
                        </li>
					<?php } ?>
					<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('Tags'))) && $session->read('permissions.'.strtolower('Tags').'.'.strtolower('add-tag'))==1) ){?>
                        <li class="<?php if($this->request->params['controller'] == 'Tags' && $this->request->params['action'] == 'add-tag'): echo "active"; endif; ?>">
                            <a href="<?php echo Router::url(['controller' => 'tags', 'action' => 'add-tag']); ?>">
                                <i class="fa fa-plus"></i>&nbsp;
                                Add
                            </a>
                        </li>
					<?php } ?>
                    </ul>
                </li>
			<?php } ?>
                <!-- Tags Management end -->
				
				<!-- Question Category start -->
			<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('QuestionCategories')))) ){?>
                <li class="<?php if($this->request->params['controller'] == 'QuestionCategories'): echo "active open"; endif; ?>">
                    <a href="">
                        <i class="fa fa-question-circle"></i>&nbsp;
                        Question Categories
                        <i class="fa arrow"></i>
                    </a>
                    <ul>
					<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('QuestionCategories'))) && $session->read('permissions.'.strtolower('QuestionCategories').'.'.strtolower('list-data'))==1) ){?>
                        <li class="<?php if($this->request->params['controller'] == 'QuestionCategories' && $this->request->params['action'] == 'listData'): echo "active"; endif; ?>">
                            <a href="<?php echo Router::url(['controller' => 'question-categories', 'action' => 'list-data']); ?>">
                               <i class="fa fa-list-alt"></i>&nbsp;
                               View All
                            </a>
                        </li>
					<?php } ?>
					<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('QuestionCategories'))) && $session->read('permissions.'.strtolower('QuestionCategories').'.'.strtolower('add-question-category'))==1) ){?>
                        <li class="<?php if($this->request->params['controller'] == 'QuestionCategories' && $this->request->params['action'] == 'addCategory'): echo "active"; endif; ?>">
                            <a href="<?php echo Router::url(['controller' => 'question-categories', 'action' => 'add-question-category']); ?>">
                                <i class="fa fa-plus"></i>&nbsp;
                                Add
                            </a>
                        </li>
					<?php } ?>
                    </ul>
                </li>
			<?php } ?>
                <!-- Question Category end -->
				
				<!-- Question start -->
			<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('Questions')))) ){?>
                <li class="<?php if($this->request->params['controller'] == 'Questions'): echo "active open"; endif; ?>">
                    <a href="">
                        <i class="fa fa-question"></i>&nbsp;
                        Questions
                        <i class="fa arrow"></i>
                    </a>
                    <ul>
					<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('Questions'))) && $session->read('permissions.'.strtolower('Questions').'.'.strtolower('list-data'))==1) ){?>
                        <li class="<?php if($this->request->params['controller'] == 'Questions' && $this->request->params['action'] == 'listData'): echo "active"; endif; ?>">
                            <a href="<?php echo Router::url(['controller' => 'questions', 'action' => 'list-data']); ?>">
                               <i class="fa fa-list-alt"></i>&nbsp;
                               View All
                            </a>
                        </li>
					<?php } ?>
					<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('Questions'))) && $session->read('permissions.'.strtolower('Questions').'.'.strtolower('add-question'))==1) ){?>
                        <li class="<?php if($this->request->params['controller'] == 'Questions' && $this->request->params['action'] == 'addQuestion'): echo "active"; endif; ?>">
                            <a href="<?php echo Router::url(['controller' => 'questions', 'action' => 'add-question']); ?>">
                                <i class="fa fa-plus"></i>&nbsp;
                                Add
                            </a>
                        </li>
					<?php } ?>
                    </ul>
                </li>
			<?php } ?>
                <!-- Question end -->
				
				<!-- Question Answers start -->
			<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('QuestionAnswers')))) ){?>
                <li class="<?php if($this->request->params['controller'] == 'QuestionAnswers' || $this->request->params['controller'] == 'AnswerComments'): echo "active open"; endif; ?>">
                    <a href="">
                        <i class="fa fa-comments-o"></i>
                        Answer & Comments
                        <i class="fa arrow"></i>
                    </a>
                    <ul>
					<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('QuestionAnswers'))) && $session->read('permissions.'.strtolower('QuestionAnswers').'.'.strtolower('list-data'))==1) ){?>
                        <li class="<?php if($this->request->params['controller'] == 'QuestionAnswers' && $this->request->params['action'] == 'listData'): echo "active"; endif; ?>">
                            <a href="<?php echo Router::url(['controller' => 'question-answers', 'action' => 'list-data']); ?>">
                               <i class="fa fa-list-alt"></i>&nbsp;
                               View All
                            </a>
                        </li>
					<?php } ?>
                    </ul>
                </li>
			<?php } ?>
                <!-- Question Answers end -->
				
				<!-- Question Comments start -->
			<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('QuestionComments')))) ){?>
                <li class="<?php if($this->request->params['controller'] == 'QuestionComments'): echo "active open"; endif; ?>">
                    <a href="">
                        <i class="fa fa-comments-o"></i>
                        Question Comments
                        <i class="fa arrow"></i>
                    </a>
                    <ul>
					<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('QuestionComments'))) && $session->read('permissions.'.strtolower('QuestionComments').'.'.strtolower('list-data'))==1) ){?>
                        <li class="<?php if($this->request->params['controller'] == 'QuestionComments' && $this->request->params['action'] == 'listData'): echo "active"; endif; ?>">
                            <a href="<?php echo Router::url(['controller' => 'question-comments', 'action' => 'list-data']); ?>">
                               <i class="fa fa-list-alt"></i>&nbsp;
                               View All
                            </a>
                        </li>
					<?php } ?>
                    </ul>
                </li>
			<?php } ?>
                <!-- Question Comments end -->
				
				<!-- News Category Management start -->
			<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('NewsCategories')))) ){?>
                <li class="<?php if($this->request->params['controller'] == 'NewsCategories'): echo "active open"; endif; ?>">
					<a href="">
                        <i class="fa fa-newspaper-o"></i>&nbsp;
                        News Category
                        <i class="fa arrow"></i>
                    </a>
                    <ul>
					<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('NewsCategories'))) && $session->read('permissions.'.strtolower('NewsCategories').'.'.strtolower('list-data'))==1) ){?>
                        <li class="<?php if($this->request->params['controller'] == 'NewsCategories' && $this->request->params['action'] == 'listData'): echo "active"; endif; ?>">
                            <a href="<?php echo Router::url(['controller' => 'news-categories', 'action' => 'list-data']); ?>">
								<i class="fa fa-list-alt"></i>&nbsp;
								View All
							</a>
                        </li>
					<?php } ?>
					<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('NewsCategories'))) && $session->read('permissions.'.strtolower('NewsCategories').'.'.strtolower('add-news-category'))==1) ){?>
                        <li class="<?php if($this->request->params['controller'] == 'NewsCategories' && $this->request->params['action'] == 'add-tag'): echo "active"; endif; ?>">
                            <a href="<?php echo Router::url(['controller' => 'news-categories', 'action' => 'add-news-category']); ?>">
                                <i class="fa fa-plus"></i>&nbsp;
                                Add
                            </a>
                        </li>
					<?php } ?>
                    </ul>
                </li>
			<?php } ?>
                <!-- News Category Management end -->
				
				<!-- News Management Start -->
			<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('News')))) ){?>
                <li class="<?php if($this->request->params['controller'] == 'News' && $this->request->params['action'] == 'listData'): echo "active open"; endif; ?>">
                    <a href="">
                        <i class="fa fa-rss"></i>
                        News Management
                        <i class="fa arrow"></i>
                    </a>
                    <ul>
					<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('News'))) && $session->read('permissions.'.strtolower('News').'.'.strtolower('list-data'))==1) ){?>
                        <li class="<?php if($this->request->params['controller'] == 'News' && $this->request->params['action'] == 'listData'): echo "active"; endif; ?>">
                            <a href="<?php echo Router::url(['controller' => 'news', 'action' => 'list-data']); ?>">
                               <i class="fa fa-list-alt"></i>&nbsp;
                               View All
                            </a>
                        </li>
					<?php } ?>
					<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('News'))) && $session->read('permissions.'.strtolower('News').'.'.strtolower('add-news'))==1) ){?>
                        <li class="<?php if($this->request->params['controller'] == 'News' && $this->request->params['action'] == 'addNews'): echo "active"; endif; ?>">
                            <a href="<?php echo Router::url(['controller' => 'News', 'action' => 'add-news']); ?>">
                                <i class="fa fa-plus"></i>&nbsp;
                                Add
                            </a>
                        </li>
					<?php } ?>
                    </ul>
                </li>
			<?php } ?>
                <!-- News Management End -->
				
				<!-- News Comment Management Start -->
			<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('NewsComments')))) ){?>
                <li class="<?php if($this->request->params['controller'] == 'NewsComments'): echo "active open"; endif; ?>">
                    <a href="">
                        <i class="fa fa-comments-o"></i>
                        News Comments
                        <i class="fa arrow"></i>
                    </a>
                    <ul>
					<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('NewsComments'))) && $session->read('permissions.'.strtolower('NewsComments').'.'.strtolower('list-data'))==1) ){?>
                        <li class="<?php if($this->request->params['controller'] == 'NewsComments' && $this->request->params['action'] == 'listData'): echo "active"; endif; ?>">
                            <a href="<?php echo Router::url(['controller' => 'news-comments', 'action' => 'list-data']); ?>">
                               <i class="fa fa-list-alt"></i>&nbsp;
                               View All
                            </a>
                        </li>
					<?php } ?>
                    </ul>
                </li>
			<?php } ?>
                <!-- News Comment Management End -->
				
				<!-- Faqs start -->
			<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('Faqs')))) ){?>
                <li class="<?php if($this->request->params['controller'] == 'Faqs'): echo "active open"; endif; ?>">
                    <a href="">
                        <i class="fa fa-info-circle"></i>
                        FAQs
                        <i class="fa arrow"></i>
                    </a>
                    <ul>
					<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('Faqs'))) && $session->read('permissions.'.strtolower('Faqs').'.'.strtolower('list-data'))==1) ){?>
                        <li class="<?php if($this->request->params['controller'] == 'Faqs' && $this->request->params['action'] == 'listData'): echo "active"; endif; ?>">
                            <a href="<?php echo Router::url(['controller' => 'faqs', 'action' => 'list-data']); ?>">
                               <i class="fa fa-list-alt"></i>&nbsp;
                               View All
                            </a>
                        </li>
					<?php } ?>
					<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('Faqs'))) && $session->read('permissions.'.strtolower('Faqs').'.'.strtolower('add-faq'))==1) ){?>
                        <li class="<?php if($this->request->params['controller'] == 'Faqs' && $this->request->params['action'] == 'addFaq'): echo "active"; endif; ?>">
                            <a href="<?php echo Router::url(['controller' => 'faqs', 'action' => 'add-faq']); ?>">
                                <i class="fa fa-plus"></i>&nbsp;
                                Add
                            </a>
                        </li>
					<?php } ?>
                    </ul>
                </li>
			<?php } ?>
                <!-- Faqs end -->
                
				<!-- Contacts Management end -->
			<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('Contacts')))) ){?>
                <li class="<?php if($this->request->params['controller'] == 'Contacts'): echo "active open"; endif; ?>">
                    <a href="<?php echo Router::url(['controller' => 'contacts', 'action' => 'list-data']); ?>">
                        <i class="fa fa-envelope"></i>
                        Contacts Management
                    </a>
                </li>
			<?php } ?>
                <!-- Contacts Management start --> 
                
				<?php /*<!-- Newsletter Subscriptions Management end -->
                <li class="<?php if($this->request->params['controller'] == 'NewsletterSubscriptions'): echo "active open"; endif; ?>">
                    <a href="<?php echo Router::url(['controller' => 'newsletter-subscriptions', 'action' => 'list-data']); ?>">
                        <i class="fa fa-location-arrow"></i>
                        Newsletter Subscriber
                    </a>
                </li>
                <!-- Newsletter Subscriptions Management start -->*/?>
				
                <!-- Cms Management end -->
			<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('Cms')))) ){?>
                <li class="<?php if($this->request->params['controller'] == 'Cms'): echo "active open"; endif; ?>">
                    <a href="<?php echo Router::url(['controller' => 'cms', 'action' => 'list-data']); ?>">
                        <i class="fa fa-book"></i>
                        CMS Management
                    </a>
                </li>
			<?php } ?>
                <!-- Cms Management start -->
				
				<!-- Banner start -->
			<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('BannerSections')))) ){?>
                <li class="<?php if($this->request->params['controller'] == 'BannerSections'): echo "active open"; endif; ?>">
                    <a href="">
                        <i class="fa fa-picture-o"></i>
                        Banner Management
                        <i class="fa arrow"></i>
                    </a>
                    <ul>
					<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('BannerSections'))) && $session->read('permissions.'.strtolower('BannerSections').'.'.strtolower('list-data'))==1) ){?>
                        <li class="<?php if($this->request->params['controller'] == 'BannerSections' && $this->request->params['action'] == 'listData'): echo "active"; endif; ?>">
                            <a href="<?php echo Router::url(['controller' => 'banner-sections', 'action' => 'list-data']); ?>">
                               <i class="fa fa-list-alt"></i>&nbsp;
                               View All
                            </a>
                        </li>
					<?php } ?>
					<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('BannerSections'))) && $session->read('permissions.'.strtolower('BannerSections').'.'.strtolower('add-banner-section'))==1) ){?>
						<li class="<?php if($this->request->params['controller'] == 'BannerSections' && $this->request->params['action'] == 'addBannerSection'): echo "active"; endif; ?>">
                            <a href="<?php echo Router::url(['controller' => 'banner-sections', 'action' => 'add-banner-section']); ?>">
                                <i class="fa fa-plus"></i>&nbsp;
                                Add
                            </a>
                        </li>
					<?php } ?>
                    </ul>
                </li>
			<?php } ?>
                <!-- Banner end -->
				
				<!-- Advertisement start -->
			<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('Advertisements')))) ){?>
                <li class="<?php if($this->request->params['controller'] == 'Advertisements'): echo "active open"; endif; ?>">
                    <a href="">
                        <i class="fa fa-picture-o"></i>
                        Advertisements
                        <i class="fa arrow"></i>
                    </a>
                    <ul>
					<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('Advertisements'))) && $session->read('permissions.'.strtolower('Advertisements').'.'.strtolower('list-data'))==1) ){?>
                        <li class="<?php if($this->request->params['controller'] == 'Advertisements' && $this->request->params['action'] == 'listData'): echo "active"; endif; ?>">
                            <a href="<?php echo Router::url(['controller' => 'advertisements', 'action' => 'list-data']); ?>">
                               <i class="fa fa-list-alt"></i>&nbsp;
                               View All
                            </a>
                        </li>
					<?php } ?>
					<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') || (!empty($session->read('permissions.'.strtolower('Advertisements'))) && $session->read('permissions.'.strtolower('Advertisements').'.'.strtolower('add-advertise'))==1) ){?>
						<li class="<?php if($this->request->params['controller'] == 'Advertisements' && $this->request->params['action'] == 'addAdvertise'): echo "active"; endif; ?>">
                            <a href="<?php echo Router::url(['controller' => 'advertisements', 'action' => 'add-advertise']); ?>">
                                <i class="fa fa-plus"></i>&nbsp;
                                Add
                            </a>
                        </li>
					<?php } ?>
                    </ul>
                </li>
			<?php } ?>
                <!-- Advertisement end -->

                <?php /*<!-- Settings Management start -->
                <li class="<?php if($this->request->params['controller'] == 'Settings'): echo "active open"; endif; ?>">
                    <a href="<?php echo Router::url(['controller' => 'settings']); ?>">
                        <i class="fa fa-cogs"></i>
                        Website Settings
                    </a>
                </li>
                <!-- Settings Management end -->
				*/ ?>
            </ul>
        </nav>
    </div>
    <footer class="sidebar-footer">
        <ul class="nav metismenu" id="customize-menu">
            <li>
                <ul>
                    <li class="customize">
                        <div class="customize-item">
                            <div class="row customize-header">
                                <div class="col-xs-4"> </div>
                                <div class="col-xs-4"> <label class="title">fixed</label> </div>
                                <div class="col-xs-4"> <label class="title">static</label> </div>
                            </div>
                            <div class="row hidden-md-down">
                                <div class="col-xs-4"> <label class="title">Sidebar:</label> </div>
                                <div class="col-xs-4"> <label>
	                        <input class="radio" type="radio" name="sidebarPosition" value="sidebar-fixed" >
	                        <span></span>
	                    </label> </div>
                                <div class="col-xs-4"> <label>
	                        <input class="radio" type="radio" name="sidebarPosition" value="">
	                        <span></span>
	                    </label> </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4"> <label class="title">Header:</label> </div>
                                <div class="col-xs-4"> <label>
	                        <input class="radio" type="radio" name="headerPosition" value="header-fixed">
	                        <span></span>
	                    </label> </div>
                                <div class="col-xs-4"> <label>
	                        <input class="radio" type="radio" name="headerPosition" value="">
	                        <span></span>
	                    </label> </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4"> <label class="title">Footer:</label> </div>
                                <div class="col-xs-4"> <label>
	                        <input class="radio" type="radio" name="footerPosition" value="footer-fixed">
	                        <span></span>
	                    </label> </div>
                                <div class="col-xs-4"> <label>
	                        <input class="radio" type="radio" name="footerPosition" value="">
	                        <span></span>
	                    </label> </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <a href=""> <i class="fa fa-cog"></i> Customize </a>
            </li>
        </ul>
    </footer>
</aside>
<div class="sidebar-overlay" id="sidebar-overlay"></div>